<?php
$comp = $_GET['comp'] ?? '';
$mode = $_GET['mode'] ?? '';

$subpage_id = $_GET['subpage_id'] ?? null;
$source = $_GET['source'] ?? null;
$complianceId = $_GET['complianceId'] ?? null;
$other_id = $_GET['other_id'] ?? null;
$catid = $_GET['catid'] ?? null;
$die_id = $_GET['die_id'] ?? null;

// Define breadcrumb
$breadcrumb = "Dashboard";

if ($comp && is_dir(FS_ADMIN . _MODS . "/" . $comp)) {
    switch ($mode) {
        case "my-profile":
            $breadcrumb = 'My Profile';
            break;
        case "website-settings":
            $breadcrumb = 'Website Setting';
            break;
        case "rates":
            $breadcrumb = str_replace('manager', 'Rates', $comp);
            break;
        case "add":
            $breadcrumb = ($comp == "proposal_history") ? 'Send Proposal' : $breadcrumb;
            break;
        default:
            $breadcrumb = match ($comp) {
                "admin_users" => 'Users Manager',
                "affilation" => 'Affiliate History',
                "taxtation_compliance" => 'TAX CRMS',
                "project" => 'Order',
                "categorys" => 'Materials',
                default => $ADMIN->breadcrumb($comp),
            };
    }
} else {
    $breadcrumb = "Under Construction!";
}

if ($mode !== 'dashboard') {
?>
    <section class="pt-4 brdbg pb-4">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card-title">
                        <h2><?= ucfirst(str_replace('_', ' ', $breadcrumb)) ?> </h2>
                    </div>
                </div>
                <div class="col text-right addbtn">
                    <h4>
                        <?php
                        if (!in_array($mode, ['add', 'edit', 'website-settings', 'view', 'rates']) &&
                            !in_array($comp, ['orders', 'subscribes', 'custom_payments']) &&
                            $breadcrumb !== "Dashboard") {

                            $query_params = http_build_query(array_filter(compact('subpage_id', 'source', 'complianceId', 'other_id', 'catid', 'die_id')));
                            $add_url = ($comp == 'invoice') ? SITE_PATH . 'invoice/add' : $ADMIN->iurl($comp, 'add');
                            if ($query_params) {
                                $add_url .= '?' . $query_params;
                            }
                        ?>
                            <a href="<?= $add_url ?>" class="btn btn-info" title="Add New" id="add"><i class="fa fa-plus"></i></a>
                            <a href="javascript:void(0);" onclick="javascript:submitions('Delete');" title="Delete" class="btn btn-info"><i class="fa fa-trash"></i></a>
                            <?php if ($comp == 'category' && $subpage_id > 0) { ?>
                                <a href="<?= $ADMIN->iurl($comp) ?>" title="Back" class="btn btn-info"><i class="fa fa-arrow-left"></i></a>
                            <?php } ?>
                            <a href="javascript:void(0);" onclick="javascript:submitions('Active');" title="Active" class="btn btn-info"><i class="fa fa-toggle-on"></i></a>
                            <a href="javascript:void(0);" onclick="javascript:submitions('Inactive');" title="Inactive" class="btn btn-info"><i class="fa fa-ban"></i></a>
                        <?php } else if ($mode !== 'website-settings' && $breadcrumb !== "Dashboard" && !in_array($comp, ['orders', 'subscribes', 'proposal_history', 'invoice', 'custom_payments'])) { ?>
                            <a href="<?= $ADMIN->iurl($comp) ?>" title="Cancel" class="btn btn-info"><i class="fa fa-times"></i></a>
                            <a href="<?= $ADMIN->iurl($comp) ?>" title="Back" class="btn btn-info"><i class="fa fa-arrow-left"></i></a>
                        <?php } ?>
                    </h4>
                </div>
            </div>
            <div class="row">
                <div class="col"><?= $ADMIN->alert(); ?></div>
            </div>
        </div>
    </section>
<?php } ?>
