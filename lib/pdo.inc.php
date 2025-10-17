<?php
/**
 * PDO Database Class - PHP 8+ Compatible
 * Includes safe sqlquery wrappers to avoid empty array errors
 */

class dbc
{
    function __construct()
    {
        global $ARR_DBS;
        if (!isset($GLOBALS["dbcon"])) {
            try {
                $GLOBALS["dbcon"] = new PDO(
                    "mysql:host=" . $ARR_DBS["dbs"]["host"] . ";dbname=" . $ARR_DBS["dbs"]["name"],
                    $ARR_DBS["dbs"]["user"],
                    $ARR_DBS["dbs"]["password"],
                    [
                        PDO::ATTR_PERSISTENT => false,
                        PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]
                );
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
    }

    public function PDBC()
    {
        return $GLOBALS["dbcon"];
    }

    public function parse_input($val)
    {
        return $GLOBALS["dbcon"]->quote($val);
    }

    public function parse_output($val)
    {
        return stripslashes($val);
    }

    public function checkpoint($from_start = false)
    {
        global $PREV_CHECKPOINT;
        if ($PREV_CHECKPOINT == "") $PREV_CHECKPOINT = SCRIPT_START_TIME;
        $cur_microtime = $this->getmicrotime();
        if ($from_start) return $cur_microtime - SCRIPT_START_TIME;
        $time_taken = $cur_microtime - $PREV_CHECKPOINT;
        $PREV_CHECKPOINT = $cur_microtime;
        return $time_taken;
    }

    public function db_query($sql, $dbcon2 = null)
    {
        if ($dbcon2 === null) $dbcon2 = $GLOBALS["dbcon"];
        $sql = str_replace("#_", tb_Prefix, $sql);
        $result = $dbcon2->query($sql);
        if (!$result) die(print_r($dbcon2->errorInfo(), true));
        return $result;
    }

    public function db_fetch_array($rs, $mode = PDO::FETCH_BOTH)
    {
        return $rs->fetch($mode);
    }

    public function db_fetch_all($rs, $mode = PDO::FETCH_BOTH)
    {
        return $rs->fetchAll($mode);
    }

    public function getSingleresult($sql, $dbcon2 = null)
    {
        $dbcon2 = $dbcon2 ?? $GLOBALS["dbcon"];
        $result = $this->db_query($sql, $dbcon2);
        $line = $this->db_fetch_array($result);
        return $line[0] ?? null;
    }

    public function getResult($sql, $dbcon2 = null)
    {
        $dbcon2 = $dbcon2 ?? $GLOBALS["dbcon"];
        $result = $this->db_query($sql, $dbcon2);
        return $this->db_fetch_array($result) ?? null;
    }

    // ---------------- Safe sqlquery ----------------
    public function sqlquery($tablename, $arr, $rs = "exe", $update = "", $id = "", $update2 = "", $id2 = "")
    {
        if (empty($tablename)) throw new Exception("Table name cannot be empty.");
        if (!is_array($arr) || empty($arr)) throw new Exception("Data array cannot be empty for table `$tablename`.");

        $sql = $this->db_query("DESC " . tb_Prefix . "$tablename");
        $makesql = $update === "" ? "INSERT INTO " . tb_Prefix . "$tablename SET " : "UPDATE " . tb_Prefix . "$tablename SET ";

        $columns = [];
        while ($row = $sql->fetch()) {
            $field = $row["Field"];
            if (array_key_exists($field, $arr)) {
                $value = is_array($arr[$field]) ? implode(":", $arr[$field]) : $arr[$field];
                $columns[] = $field . "=" . $this->parse_input($value);
            }
        }

        if (empty($columns)) throw new Exception("No valid columns found in array for table `$tablename`.");
        $makesql .= implode(", ", $columns);

        if ($update) {
            if (empty($id)) throw new Exception("Update ID is missing for table `$tablename`.");
            $makesql .= " WHERE " . $update . "='" . $id . "'";
            if ($update2 && $id2) $makesql .= " AND " . $update2 . "='" . $id2 . "'";
        }

        if ($rs === "show") {
            echo $makesql;
            exit();
        }

        $this->db_query($makesql);
        return $update ? $id : $GLOBALS["dbcon"]->lastInsertId();
    }

    // ---------------- Safe sqlquerywithPrefix ----------------
    public function sqlquerywithPrefix($tablename, $arr, $rs = "exe", $update = "", $id = "", $update2 = "", $id2 = "")
    {
        if (empty($tablename)) throw new Exception("Table name cannot be empty.");
        if (!is_array($arr) || empty($arr)) throw new Exception("Data array cannot be empty for table `$tablename`.");

        $sql = $this->db_query("DESC $tablename");
        $makesql = $update === "" ? "INSERT INTO $tablename SET " : "UPDATE $tablename SET ";

        $columns = [];
        while ($row = $sql->fetch()) {
            $field = $row["Field"];
            if (array_key_exists($field, $arr)) {
                $value = is_array($arr[$field]) ? implode(":", $arr[$field]) : $arr[$field];
                $columns[] = $field . "=" . $this->parse_input($value);
            }
        }

        if (empty($columns)) throw new Exception("No valid columns found in array for table `$tablename`.");
        $makesql .= implode(", ", $columns);

        if ($update) {
            if (empty($id)) throw new Exception("Update ID is missing for table `$tablename`.");
            $makesql .= " WHERE " . $update . "='" . $id . "'";
            if ($update2 && $id2) $makesql .= " AND " . $update2 . "='" . $id2 . "'";
        }

        if ($rs === "show") {
            echo $makesql;
            exit();
        }

        $this->db_query($makesql);
        return $update ? $id : $GLOBALS["dbcon"]->lastInsertId();
    }

    public function db_scalar($sql, $dbcon2 = null)
    {
        $dbcon2 = $dbcon2 ?? $GLOBALS["dbcon"];
        $result = $this->db_query($sql, $dbcon2);
        $line = $this->db_fetch_array($result);
        return $line[0] ?? null;
    }

    public function encrypt_decrypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = "786";
        $secret_iv = "07";
        $key = hash("sha256", $secret_key);
        $iv = substr(hash("sha256", $secret_iv), 0, 16);

        if ($action == "encrypt") {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } elseif ($action == "decrypt") {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    public function sessset($val, $msg = "")
    {
        $_SESSION["sessmsg"] = $val;
        $_SESSION["alert"] = $msg;
    }

    public function print_error()
    {
        $trace = debug_backtrace();
        for ($i = 1; $i < count($trace); $i++) {
            $e = $trace[$i];
            echo "<div><span>File:</span> " . str_replace(SITE_FS_PATH ?? "", "", $e["file"]) .
                 "<br><span>Line:</span> " . $e["line"] .
                 "<br><span>Function:</span> " . $e["function"] . "</div>";
        }
    }

    public function pageinfo($page)
    {
        $pageInfo = [];
        $pageInfo['title'] = $this->get_static_content("meta_title", $page);
        $pageInfo['keyword'] = $this->get_static_content("meta_keyword", $page);
        $pageInfo['description'] = $this->get_static_content("meta_description", $page);
        $pageInfo['heading'] = $this->get_static_content("heading", $page);
        $pageInfo['body'] = $this->get_static_content("body", $page);
        return $pageInfo;
    }

    public function get_static_content($key, $pname)
    {
        return $this->db_scalar("SELECT " . $key . " FROM #_pages WHERE url='$pname'");
    }
}

/**
 * Safe wrapper class
 */
class dbc_safe extends dbc
{
    public function safe_sqlquery($tablename, $arr, $rs = "exe", $update = "", $id = "", $update2 = "", $id2 = "")
    {
        if (!is_array($arr) || empty($arr)) {
            error_log("Skipped sqlquery for table `$tablename` because data array is empty.");
            return null;
        }

        try {
            return $this->sqlquery($tablename, $arr, $rs, $update, $id, $update2, $id2);
        } catch (Exception $e) {
            error_log("SQL Query Error for table `$tablename`: " . $e->getMessage());
            return null;
        }
    }

    public function safe_sqlquerywithPrefix($tablename, $arr, $rs = "exe", $update = "", $id = "", $update2 = "", $id2 = "")
    {
        if (!is_array($arr) || empty($arr)) {
            error_log("Skipped sqlquerywithPrefix for table `$tablename` because data array is empty.");
            return null;
        }

        try {
            return $this->sqlquerywithPrefix($tablename, $arr, $rs, $update, $id, $update2, $id2);
        } catch (Exception $e) {
            error_log("SQL QueryWithPrefix Error for table `$tablename`: " . $e->getMessage());
            return null;
        }
    }
}
