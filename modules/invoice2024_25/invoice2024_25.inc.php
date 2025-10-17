<?php

define("tblName", "invoice2024_25");

class Pages extends dbc_safe
{
  public function add($data)
{
    echo "<pre>=== DEBUG MODE ENABLED ===<br>";

    // Step 1: Initial data
    print_r($data);

    // Step 2: Set meta info
    $data['created_on'] = date("Y-m-d H:i:s");
    $data['create_by'] = $_SESSION["AMD"][0] ?? '';
    $data['salesecutiveid'] = $_SESSION["AMD"][0] ?? '';

    // Step 3: Shortorder
    $shortorderQuery = "SELECT MAX(shortorder) FROM #_" . tblName;
    echo "Shortorder Query: " . $shortorderQuery . "<br>";
    $shortorder = parent::getSingleresult($shortorderQuery) + 1;
    $data['shortorder'] = $shortorder;

    echo "Shortorder value: " . $shortorder . "<br>";

    // Step 4: Check duplicate
    if (!empty($data["inviceno"])) {
        $checkSql = "SELECT * FROM #_" . tblName . " WHERE inviceno = '" . trim($data["inviceno"]) . "'";
    } else {
        $checkSql = "SELECT * FROM #_" . tblName . " WHERE created_on = '" . $data['created_on'] . "'";
    }

    echo "Duplicate check query: " . $checkSql . "<br>";

    $checkQuery = parent::db_query($checkSql);
    echo "Duplicate row count: " . $checkQuery->rowCount() . "<br>";

    // Step 5: If record not found, insert it
    if ($checkQuery->rowCount() === 0) {
        echo "🟢 No duplicate found. Proceeding to insert...<br>";

        // Show insert data
        print_r($data);

        // Try inserting
try {
    // 🟢 Step 1: Build Insert Query manually using PDO
    $table = tblName; // example: "invoice2024_25"
    $columns = implode(", ", array_keys($data));
    $placeholders = ":" . implode(", :", array_keys($data));

    // Replace prefix if needed (optional)
    $sql = "INSERT INTO #_{$table} ($columns) VALUES ($placeholders)";
    $sql = str_replace("#_", tb_Prefix, $sql); // <-- Change 'your_prefix_' to your actual DB prefix (like 'crm_' or '')
    echo "<b>SQL Query:</b> $sql<br>";

    $stmt = $GLOBALS["dbcon"]->prepare($sql);
    $stmt->execute($data);

    // 🟢 Step 2: Get last inserted ID
    $insertid = $GLOBALS["dbcon"]->lastInsertId();
    echo "<b>Insert ID:</b> " . $insertid . "<br>";

} catch (PDOException $e) {
    echo "❌ <b>Insert error:</b> " . $e->getMessage() . "<br>";
    exit;
}

// 🟡 Step 3: Verify Insert
if (empty($insertid) || $insertid == 0) {
    echo "❌ Insert ID empty — insert failed!<br>";
    exit;
} else {
    echo "✅ Record inserted successfully with ID: " . $insertid . "<br>";
}

// 🟢 Step 4: Update invoice no if required
$updateData = [
    "inviceno" => $data["inviceno"] ?? ''
];

echo "Updating invoice no...<br>";
print_r($updateData);

try {
    $table = tblName;
    $setPart = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($updateData)));
    $updateSql = "UPDATE #_{$table} SET $setPart WHERE pid = :pid";
    $updateSql = str_replace("#_", tb_Prefix, $updateSql); // same prefix replacement
    $stmt = $GLOBALS["dbcon"]->prepare($updateSql);
    $updateData['pid'] = $insertid;
    $stmt->execute($updateData);
    echo "✅ Invoice updated successfully.<br>";
} catch (PDOException $e) {
    echo "❌ Update error: " . $e->getMessage() . "<br>";
}

// 🟢 Step 5: If lid exists, update related tables
if (!empty($data["lid"])) {
    echo "Updating leads and project tables...<br>";

    $leadsdata = [
        "invoiceno" => $data["inviceno"] ?? '',
        "invoiceid" => $insertid
    ];

    // Update leads table
    try {
        $sqlLeads = "UPDATE #_leads SET invoiceno = :invoiceno, invoiceid = :invoiceid WHERE pid = :pid";
        $sqlLeads = str_replace("#_", tb_Prefix, $sqlLeads);
        $stmt = $GLOBALS["dbcon"]->prepare($sqlLeads);
        $leadsdata["pid"] = $data["lid"];
        $stmt->execute($leadsdata);
        echo "✅ Leads table updated.<br>";
    } catch (PDOException $e) {
        echo "❌ Leads update error: " . $e->getMessage() . "<br>";
    }

    // Update project table if exists
    $orderQuery = parent::db_query("SELECT * FROM #_project WHERE lid='" . $data["lid"] . "'");
    echo "Project found rows: " . $orderQuery->rowCount() . "<br>";

    if ($orderQuery->rowCount() > 0) {
        try {
            $sqlProj = "UPDATE #_project SET invoiceno = :invoiceno, invoiceid = :invoiceid WHERE lid = :lid";
            $sqlProj = str_replace("#_", tb_Prefix, $sqlProj);
            $stmt = $GLOBALS["dbcon"]->prepare($sqlProj);
            $leadsdata["lid"] = $data["lid"];
            $stmt->execute($leadsdata);
            echo "✅ Project table updated.<br>";
        } catch (PDOException $e) {
            echo "❌ Project update error: " . $e->getMessage() . "<br>";
        }
    }
}

parent::sessset("Record has been added", "s");
return [1, $insertid];



    } else {
        echo "⚠️ Duplicate found. Record not inserted.<br>";
        parent::sessset("Record has already been added", "e");
        return [0];
    }
}


    public function update($data)
    {
        $updateid = $data['updateid'] ?? 0;
        $created_on = $data['created_on'] ?? '';

        $query = parent::db_query(
            "SELECT * FROM #_" . tblName . " WHERE created_on='" . $created_on . "' AND pid!='" . $updateid . "'"
        );

        if ($query->rowCount() === 0) {
            // Filter arrays
            foreach (['itemservice','itempriceservice','itemadon','itempriceadon'] as $key) {
                $data[$key] = !empty($data[$key]) ? array_filter($data[$key]) : '';
            }

            $data["modified_on"] = date("Y-m-d H:i:s");
            $data["modified_by"] = ($_SESSION["AMD"][0] ?? '') . ":" . ($data["modified_by"] ?? '');

            parent::safe_sqlquery(tblName, $data, 'exe', 'pid', $updateid);
            parent::sessset("Record has been updated", "s");
            return 1;
        } else {
            parent::sessset("Record has already added", "e");
            return 0;
        }
    }

    public function delete($updateid)
    {
        if (is_array($updateid)) {
            $updateid = implode(",", $updateid);
        }

        parent::db_query("DELETE FROM #_" . tblName . " WHERE pid IN ($updateid)");
    }

    public function status($updateid, $status)
    {
        if (is_array($updateid)) {
            $updateid = implode(",", $updateid);
        }

        parent::db_query(
            "UPDATE #_" . tblName . " SET status='" . $status . "' WHERE pid IN ($updateid)"
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
?>
