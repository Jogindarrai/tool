<?php
include(FS_ADMIN . _MODS . "/admin_users/admin_user.inc.php");

$ADU = new AdminUsers();

/* ================= SAFE VARIABLES ================= */
$action      = $_GET['action'] ?? '';
$uid         = isset($_GET['uid']) ? (int)$_GET['uid'] : 0;
$arr_ids     = $_POST['arr_ids'] ?? [];

$start       = isset($start) ? (int)$start : 0;
$pagesize    = isset($pagesize) ? (int)$pagesize : 0;

$fld         = $_GET['fld'] ?? '';
$otype       = $_GET['otype'] ?? '';
$search_data = $search_data ?? '';

/* ================= ACTION HANDLER ================= */
if ($action && ($uid > 0 || !empty($arr_ids))) {

    switch ($action) {

        case "del":
            $ADU->delete($uid);
            $ADMIN->sessset('Record has been deleted', 'e');
            break;

        case "Delete":
            $ADU->delete($arr_ids);
            $ADMIN->sessset(count($arr_ids) . ' Item(s) Deleted', 'e');
            break;

        case "Active":
            $ADU->status($arr_ids, 1);
            $ADMIN->sessset(count($arr_ids) . ' Item(s) Active', 's');
            break;

        case "Inactive":
            $ADU->status($arr_ids, 0);
            $ADMIN->sessset(count($arr_ids) . ' Item(s) Inactive', 's');
            break;
    }

    $RW->redir($ADMIN->iurl($comp), true);
}

/* ================= PAGINATION ================= */
$start = (int)$start;
$pagesize = $pagesize ?: (($_SESSION["totpaging"] ?? 0) ?: DEF_PAGE_SIZE);

/* ================= FETCH DATA ================= */
list($result, $reccnt) = $ADU->display(
    $start,
    $pagesize,
    $fld,
    $otype,
    $search_data
);
?>

<div class="container">
<div class="user-wrp">
<div class="table-responsive">

<table class="table table-striped table-bordered">
<thead>
<tr>
    <th><?= $ADMIN->check_all() ?></th>
    <th>SL No</th>

    <th>
        <a href="<?= $ADMIN->iurl($comp) ?>&fld=name<?= ($otype == 'asc' ? '&otype=desc' : '&otype=asc') ?>"
           <?= ($fld == 'name' ? 'class="selectedTab"' : '') ?>>
            <span class="<?= ($otype == 'asc' ? 'des' : 'asc') ?>">User Name</span>
        </a>
    </th>

    <th>
        <a href="<?= $ADMIN->iurl($comp) ?>&fld=email<?= ($otype == 'asc' ? '&otype=desc' : '&otype=asc') ?>"
           <?= ($fld == 'email' ? 'class="selectedTab"' : '') ?>>
            <span class="<?= ($otype == 'asc' ? 'des' : 'asc') ?>">User Email</span>
        </a>
    </th>

    <th>
        <a href="<?= $ADMIN->iurl($comp) ?>&fld=user_type<?= ($otype == 'asc' ? '&otype=desc' : '&otype=asc') ?>"
           <?= ($fld == 'user_type' ? 'class="selectedTab"' : '') ?>>
            <span class="<?= ($otype == 'asc' ? 'des' : 'asc') ?>">Position</span>
        </a>
    </th>

    <th>
        <a href="<?= $ADMIN->iurl($comp) ?>&fld=dpid<?= ($otype == 'asc' ? '&otype=desc' : '&otype=asc') ?>"
           <?= ($fld == 'dpid' ? 'class="selectedTab"' : '') ?>>
            <span class="<?= ($otype == 'asc' ? 'des' : 'asc') ?>">Department</span>
        </a>
    </th>

    <th>
        <a href="<?= $ADMIN->iurl($comp) ?>&fld=status<?= ($otype == 'asc' ? '&otype=desc' : '&otype=asc') ?>"
           <?= ($fld == 'status' ? 'class="selectedTab"' : '') ?>>
            <span class="<?= ($otype == 'asc' ? 'des' : 'asc') ?>">Status</span>
        </a>
    </th>

    <th>Action</th>
</tr>
</thead>

<tbody>
<?php
if ($reccnt > 0) {

    $nums = $start ? $start + 1 : 1;
    $css = 'even';

    while ($line = $PDO->db_fetch_array($result)) {

        $user_id   = $line['user_id'] ?? '';
        $name      = $line['name'] ?? '';
        $email     = $line['email'] ?? '';
        $user_type = $line['user_type'] ?? '';
        $dpid      = $line['dpid'] ?? '';
        $status    = $line['status'] ?? '';

        $css = ($css == 'odd') ? 'even' : 'odd';
        ?>
        <tr class="<?= $css ?>">
            <td><?= $ADMIN->check_input($user_id) ?></td>
            <td><?= $nums ?></td>
            <td><?= htmlspecialchars($name) ?></td>
            <td><?= htmlspecialchars($email) ?></td>
            <td><?= $ADMIN->user_type($user_type) ?></td>
            <td><?= $PDO->getSingleResult("SELECT name FROM #_department WHERE pid='" . (int)$dpid . "'") ?></td>
            <td><?= $ADMIN->displaystatusadm($status) ?></td>
            <td><?= $ADMIN->action($comp, $user_id) ?></td>
        </tr>
        <?php
        $nums++;
    }

} else {
    echo '<tr><td colspan="8" align="center">No Record Found</td></tr>';
}
?>
</tbody>
</table>

</div>

<?php include("cuts/paging.inc.php"); ?>
</div>
</div>
