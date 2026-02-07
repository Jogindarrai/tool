<?php

define("tblName", "invoice2024_25");

class Pages extends dbc_safe
{
    public function add($data)
    {
        // Convert arrays to strings
        foreach (['itemservice', 'itempriceservice', 'itemadon', 'itempriceadon'] as $key) {
            if (!empty($data[$key]) && is_array($data[$key])) {
                $data[$key] = implode(":", array_filter($data[$key]));
            }
        }

        $data['created_on'] = date("Y-m-d H:i:s");
        $data['create_by'] = $_SESSION["AMD"][0] ?? '';
        $data['salesecutiveid'] = $_SESSION["AMD"][0] ?? '';

        // Shortorder
        $shortorderQuery = "SELECT MAX(shortorder) FROM #_" . tblName;
        $shortorder = parent::getSingleresult($shortorderQuery) + 1;
        $data['shortorder'] = $shortorder;

        // Duplicate check
        $checkField = !empty($data["inviceno"]) ? "inviceno = :field" : "created_on = :field";
        $checkValue = !empty($data["inviceno"]) ? trim($data["inviceno"]) : $data['created_on'];

        $sqlCheck = "SELECT * FROM #_" . tblName . " WHERE $checkField";
        $sqlCheck = str_replace("#_", tb_Prefix, $sqlCheck);
        $stmtCheck = $GLOBALS["dbcon"]->prepare($sqlCheck);
        $stmtCheck->execute(['field' => $checkValue]);

        if ($stmtCheck->rowCount() === 0) {
            // Insert
            $columns = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));
            $sqlInsert = "INSERT INTO #_" . tblName . " ($columns) VALUES ($placeholders)";
            $sqlInsert = str_replace("#_", tb_Prefix, $sqlInsert);

            $stmt = $GLOBALS["dbcon"]->prepare($sqlInsert);
            $stmt->execute($data);

            $insertid = $GLOBALS["dbcon"]->lastInsertId();

            // Update inviceno if required
            if (!empty($data["inviceno"])) {
                $updateData = ["inviceno" => $data["inviceno"], "pid" => $insertid];
                $setPart = "inviceno = :inviceno";
                $sqlUpdate = "UPDATE #_" . tblName . " SET $setPart WHERE pid = :pid";
                $sqlUpdate = str_replace("#_", tb_Prefix, $sqlUpdate);
                $stmtUpdate = $GLOBALS["dbcon"]->prepare($sqlUpdate);
                $stmtUpdate->execute($updateData);
            }

            // Update leads table if lid exists
            if (!empty($data["lid"])) {
                $leadsData = [
                    "invoiceno" => $data["inviceno"] ?? '',
                    "invoiceid" => $insertid,
                    "pid" => $data["lid"]
                ];
                $sqlLeads = "UPDATE #_leads SET invoiceno = :invoiceno, invoiceid = :invoiceid WHERE pid = :pid";
                $sqlLeads = str_replace("#_", tb_Prefix, $sqlLeads);
                $stmtLeads = $GLOBALS["dbcon"]->prepare($sqlLeads);
                $stmtLeads->execute($leadsData);

                // Update project if exists
                $projCheck = parent::db_query("SELECT * FROM #_project WHERE lid='" . $data["lid"] . "'");
                if ($projCheck->rowCount() > 0) {
                    $projData = [
                        "invoiceno" => $data["inviceno"] ?? '',
                        "invoiceid" => $insertid,
                        "lid" => $data["lid"]
                    ];
                    $sqlProj = "UPDATE #_project SET invoiceno = :invoiceno, invoiceid = :invoiceid WHERE lid = :lid";
                    $sqlProj = str_replace("#_", tb_Prefix, $sqlProj);
                    $stmtProj = $GLOBALS["dbcon"]->prepare($sqlProj);
                    $stmtProj->execute($projData);
                }
            }

            parent::sessset("Record has been added", "s");
            return [1, $insertid];
        } else {
            parent::sessset("Record has already been added", "e");
            return [0];
        }
    }
    public function update($data)
    {
        $updateid   = $data['updateid'] ?? 0;
        $created_on = $data['created_on'] ?? '';

        if (!$updateid) {
            parent::sessset("Invalid update id", "e");
            return 0;
        }

        $sqlCheck = "SELECT pid FROM #_" . tblName . "
                 WHERE created_on = :created_on
                 AND pid != :pid";

        $sqlCheck = str_replace("#_", tb_Prefix, $sqlCheck);
        $stmtCheck = $GLOBALS["dbcon"]->prepare($sqlCheck);
        $stmtCheck->execute([
            'created_on' => $created_on,
            'pid'        => $updateid
        ]);

        if ($stmtCheck->rowCount() > 0) {
            parent::sessset("Record has already added", "e");
            return 0;
        }

        // ❌ non-db key remove
        unset($data['updateid']);

        // ✅ ensure pid context
        $data['pid'] = $updateid;

        // arrays → string
        foreach (['itemservice', 'itempriceservice', 'itemadon', 'itempriceadon'] as $key) {
            if (!empty($data[$key]) && is_array($data[$key])) {
                $data[$key] = implode(":", array_filter($data[$key]));
            }
        }

        $data["modified_on"] = date("Y-m-d H:i:s");
        $data["modified_by"] = ($_SESSION["AMD"][0] ?? '') . ":" . ($data["modified_by"] ?? '');

        parent::safe_sqlquery(tblName, $data, 'exe', 'pid', $updateid);
        parent::sessset("Record has been updated", "s");

        return 1;
    }


    public function delete($updateid)
    {
        if (is_array($updateid)) {
            $updateid = implode(",", array_map('intval', $updateid));
        } else {
            $updateid = intval($updateid);
        }

        parent::db_query("DELETE FROM #_" . tblName . " WHERE pid IN ($updateid)");
    }

    public function status($updateid, $status)
    {
        if (is_array($updateid)) {
            $updateid = implode(",", array_map('intval', $updateid));
        } else {
            $updateid = intval($updateid);
        }

        parent::db_query(
            "UPDATE #_" . tblName . " SET status=:status WHERE pid IN ($updateid)",
            ['status' => $status]
        );
    }

    public function display($start, $pagesize, $fld = '', $otype = 'DESC', $search_data = '', $zone = '', $mtype = '', $extra = '', $extra1 = '', $extra2 = '')
    {
        $start = intval($start);
        $zone = $_GET['zone'] ?? $zone;
        $mtype = $_GET['mtype'] ?? $mtype;
        $extra = $_GET['extra'] ?? $extra;
        $extra1 = $_GET['extra1'] ?? $extra1;
        $extra2 = $_GET['extra2'] ?? $extra2;
        $wh = $_GET['wh'] ?? '';

        $columns = "SELECT * ";
        $sql = " FROM #_" . tblName . " WHERE 1 $zone $mtype $extra $extra1 $extra2 $wh ";
        $order_by = $fld ?: 'pid';
        $order_by2 = $otype ?: 'DESC';
        $sql_count = "SELECT COUNT(*) " . $sql;
        $sql .= " ORDER BY $order_by $order_by2 ";
        $sql .= " LIMIT $start, $pagesize ";
        $sql = $columns . $sql;

        $result = parent::db_query($sql);
        $reccnt = parent::db_scalar($sql_count);

        return [$result, $reccnt];
    }
}
