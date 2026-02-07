<?php
if ($_SESSION["AMD"][3] != 1) {
    // $BSC->redir(SITE_PATH_ADM);
}

class AdminUsers extends dbc
{
    /* ================= ADD ================= */
public function add($data)
{
    // Make sure email exists
    $email = $data['email'] ?? '';
    if (!$email) {
        parent::sessset('Email is required', 'e');
        return 0;
    }

    // Check for duplicate email
    $query = parent::db_query("SELECT * FROM pms_admin_users WHERE email='" . addslashes($email) . "'");
    if ($query->rowCount() > 0) {
        parent::sessset('Email already exists', 'e');
        return 0;
    }

    // Encrypt password
    if (!empty($data['password'])) {
        $data['password'] = $this->password($data['password']);
    }

    // Add audit fields
    $data['created_on'] = date('Y-m-d H:i:s');
    $data['create_by']  = $_SESSION["AMD"][0] ?? 0;
    $data['shortorder'] = parent::getSingleresult("SELECT MAX(shortorder) FROM pms_admin_users") + 1;

    // Set defaults for NOT NULL columns to avoid PDO 1364
    $mandatoryFields = ['tf_1','tf_2','tf_3','tf_4','logintime','userdoc','accessmodule','address','image','emailsign','']; // adjust for your table
    foreach ($mandatoryFields as $field) {
        if (!isset($data[$field])) {
            $data[$field] = ($field === 'logintime') ? date('Y-m-d H:i:s') : '';
        }
    }

    // Insert into database
    parent::sqlquerywithprefix('pms_admin_users', $data);

    // Success message
    parent::sessset('User has been added successfully', 's');
    return 1;
}



    /* ================= UPDATE ================= */
    public function update($data)
    {
        extract($data);

        // Check if email exists for other users
        $query = parent::db_query(
            "SELECT * FROM pms_admin_users
             WHERE email='" . addslashes($email) . "'
             AND user_id!='" . (int)$updateid . "'"
        );

        if ($query->rowCount() == 0) {

            $data['modified_on'] = date('Y-m-d H:i:s');

            // UPDATE database
            parent::sqlquerywithprefix(
                'pms_admin_users',
                $data,
                'exe',
                'user_id',
                $updateid
            );

            parent::sessset('Record has been updated', 's');
            return 1;
        }

        parent::sessset('Record has already been added', 'e');
        return 0;
    }

    /* ================= DELETE ================= */
    public function delete($updateid)
    {
        if (is_array($updateid)) {
            $updateid = implode(',', array_map('intval', $updateid));
        } else {
            $updateid = (int)$updateid;
        }

        parent::db_query("DELETE FROM pms_admin_users WHERE user_id IN ($updateid)");
    }

    /* ================= STATUS ================= */
    public function status($updateid, $status)
    {
        if (is_array($updateid)) {
            $updateid = implode(',', array_map('intval', $updateid));
        } else {
            $updateid = (int)$updateid;
        }

        parent::db_query(
            "UPDATE pms_admin_users SET status='" . (int)$status . "' WHERE user_id IN ($updateid)"
        );
    }

    /* ================= DISPLAY ================= */
    public function display($start, $pagesize, $fld, $otype, $search_data)
    {
        $start    = (int)$start;
        $pagesize = (int)$pagesize;

        $wh = '';
        $search_data = trim($search_data ?? ($_GET['search'] ?? ''));

        if ($search_data !== '') {
            $search_data = addslashes($search_data);
            $wh = " AND (
                name LIKE '%$search_data%'
                OR email LIKE '%$search_data%'
                OR user_type LIKE '%$search_data%'
            )";
        }

        $allowed_fields = ['name','email','user_type','dpid','status','shortorder'];
        $order_by = in_array($fld, $allowed_fields) ? $fld : 'shortorder';
        $order_by2 = ($otype === 'asc') ? 'ASC' : 'DESC';

        $sql_base = " FROM pms_admin_users WHERE 1 $wh";
        $sql_count = "SELECT COUNT(*) " . $sql_base;
        $sql = "SELECT * " . $sql_base . " ORDER BY $order_by $order_by2 LIMIT $start, $pagesize";

        $result = parent::db_query($sql);
        $reccnt = parent::db_scalar($sql_count);

        return [$result, $reccnt];
    }

    /* ================= PASSWORD ================= */
    public function password($password)
    {
        // Stronger hashing
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
