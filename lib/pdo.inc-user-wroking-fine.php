<?php

/**
 * PDO Database Class – STRICT MODE SAFE
 * PHP 8+ Compatible
 */

class dbc
{
    public function __construct()
    {
        global $ARR_DBS;

        if (!isset($GLOBALS['dbcon'])) {
            try {
                $GLOBALS['dbcon'] = new PDO(
                    "mysql:host={$ARR_DBS['dbs']['host']};dbname={$ARR_DBS['dbs']['name']}",
                    $ARR_DBS['dbs']['user'],
                    $ARR_DBS['dbs']['password'],
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]
                );
            } catch (PDOException $e) {
                die("DB Connection Failed: " . $e->getMessage());
            }
        }
    }

    public function parse_input($val)
    {
        return $val === null ? "NULL" : $GLOBALS['dbcon']->quote($val);
    }

    public function db_query($sql)
    {
        $sql = str_replace("#_", tb_Prefix, $sql);
        return $GLOBALS['dbcon']->query($sql);
    }

    public function db_fetch_array($rs)
    {
        return $rs instanceof PDOStatement ? $rs->fetch() : false;
    }

    public function getResult($sql)
    {
        $rs = $this->db_query($sql);
        return $rs ? $rs->fetch() : null;
    }

    public function getSingleresult($sql)
    {
        $rs = $this->db_query($sql);
        $row = $rs ? $rs->fetch(PDO::FETCH_NUM) : null;
        return $row[0] ?? null;
    }

    public function db_scalar($sql)
    {
        $sql = str_replace("#_", tb_Prefix, $sql);

        $stmt = $GLOBALS["dbcon"]->query($sql);

        if (!$stmt instanceof PDOStatement) {
            return null;
        }

        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0] ?? null;
    }


    public function sessset($key, $value = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $_SESSION[$k] = $v;
            }
        } else {
            $_SESSION[$key] = $value;
        }

        return true;
    }

    // =====================================================
    // ✅ FINAL SAFE INSERT / UPDATE HANDLER
    // =====================================================
    public function sqlquerywithPrefix(
        $tablename,
        $arr,
        $rs = "exe",
        $update = "",
        $id = "",
        $update2 = "",
        $id2 = ""
    ) {

        if (!$tablename || !is_array($arr) || empty($arr)) {
            return false;
        }

        $cols = $this->db_query("SHOW COLUMNS FROM `$tablename`");
        if (!$cols instanceof PDOStatement) {
            return false;
        }

        $columns    = [];
        $usedFields = [];

        while ($row = $cols->fetch(PDO::FETCH_ASSOC)) {

            $field   = $row['Field'] ?? null;
            $type    = strtolower($row['Type'] ?? '');
            $isNull  = $row['Null'] ?? 'YES';
            $default = $row['Default'];

            if (!$field) continue;

            // 🔥 UPDATE me primary key kabhi SET mat karo
            if ($update && $field === $update) {
                continue;
            }

            // auto timestamps DB handle kare
            if (in_array($field, ['created_on', 'modified_on'])) {
                continue;
            }

            // duplicate safety
            if (isset($usedFields[$field])) {
                continue;
            }

            /* -------------------------
           VALUE SELECTION
        --------------------------*/
            if (array_key_exists($field, $arr)) {

                $value = is_array($arr[$field])
                    ? implode(":", $arr[$field])
                    : trim((string)$arr[$field]);

                if ($value === '') {
                    $value = null;
                }
            } else {

                // field POST me nahi aaya
                if ($isNull === 'YES') {
                    $value = null;
                } else {

                    // NOT NULL fallback
                    if ($default !== null) {
                        $value = $default;
                    } elseif (strpos($type, 'int') !== false) {
                        $value = 0;
                    } elseif (
                        strpos($type, 'float') !== false ||
                        strpos($type, 'double') !== false ||
                        strpos($type, 'decimal') !== false
                    ) {
                        $value = 0;
                    } elseif (
                        strpos($type, 'datetime') !== false ||
                        strpos($type, 'timestamp') !== false
                    ) {
                        continue; // DB default
                    } else {
                        $value = '';
                    }
                }
            }

            // STRICT MODE SAFE
            if ($value === null && $isNull === 'NO') {
                continue;
            }

            $columns[] = "`$field`=" . $this->parse_input($value);
            $usedFields[$field] = true;
        }

        if (empty($columns)) {
            return false;
        }

        /* -------------------------
       QUERY BUILD
    --------------------------*/
        if ($update) {

            if (!$id) return false;

            $sql = "UPDATE `$tablename` SET ";
            $sql .= implode(", ", $columns);
            $sql .= " WHERE `$update`='" . addslashes($id) . "'";

            if ($update2 && $id2) {
                $sql .= " AND `$update2`='" . addslashes($id2) . "'";
            }
        } else {

            $sql = "INSERT INTO `$tablename` SET ";
            $sql .= implode(", ", $columns);
        }

        if ($rs === "show") {
            echo $sql;
            exit;
        }

        $this->db_query($sql);

        return $update ? $id : $GLOBALS["dbcon"]->lastInsertId();
    }
}

/**
 * Safe wrapper class
 */
class dbc_safe extends dbc
{

public function safe_sqlquery(
    $tablename,
    $arr,
    $rs = "exe",
    $update = "",
    $id = "",
    $update2 = "",
    $id2 = ""
) {
    if (!is_array($arr) || empty($arr)) {
        return false;
    }

    try {
        return $this->sqlquery(
            $tablename,
            $arr,
            $rs,
            $update,
            $id,
            $update2,
            $id2
        );
    } catch (Throwable $e) {
        error_log($e->getMessage());
        return false;
    }
}
}