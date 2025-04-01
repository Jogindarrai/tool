<?php
// phpinfo();

// Prevent direct access if constants are missing
if (!defined('FS_ADMIN')) {
    die('Error: FS_ADMIN is not defined.');
}
if (!defined('_MODS')) {
    die('Error: _MODS is not defined.');
}

$mode = isset($_GET['mode']) ? basename($_GET['mode']) : ''; // Sanitize mode value

echo $RW->sform((($mode || (!empty($_GET['stags']))) ? 'onsubmit="return formvalid(this)"' : ''));

if (!empty($comp)) {
    $modulePath = FS_ADMIN . _MODS . "/" . $comp;
    $fileToInclude = $modulePath . "/" . ($mode ? basename($mode) : 'manage') . ".php";

    if (is_dir($modulePath) && file_exists($fileToInclude)) {
        include($fileToInclude);
    } else {
        include(FS_ADMIN . _MODS . "/404.php");
    }
} else {
    include(FS_ADMIN . _MODS . "/dashboard.php");
    echo "The full path is: " . FS_ADMIN . _MODS . "/dashboard.php";
}
?>
<input type="hidden" name="action2" id="action2"/>
<?= $RW->eform(); ?>
