<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);



ini_set('session.gc_maxlifetime', 18000);
session_set_cookie_params(18000);
session_start();

if (!defined('SCRIPT_START_TIME')) {
    define('SCRIPT_START_TIME', microtime(true));
}


//error_reporting(E_ALL & ~E_NOTICE);
ini_set('memory_limit', '800M');
set_time_limit(0);
ini_set('post_max_size', '300M');
ini_set('upload_max_filesize', '800M');
ini_set('max_input_time', 36000);

date_default_timezone_set('Asia/Kolkata');

$host = $_SERVER['HTTP_HOST'] ?? '';

if (in_array($host, ['127.0.0.1', 'localhost', 'Ajay'])) {
    define('LOCAL_MODE', true);
} else {
    define('LOCAL_MODE', false);
}

$ARR_DBS = [];

if (LOCAL_MODE) {
    $ARR_DBS["dbs"] = [
        'host' => 'localhost',
        'name' => 'tools',
        'user' => 'root',
        'password' => ''
    ];
    define('SITE_SUB_PATH', '/tools/');
} else {
    $ARR_DBS["dbs"] = [
        'host' => 'localhost',
        'name' => 'tools',
        'user' => 'root',
        'password' => ''
    ];
    define('SITE_SUB_PATH', '/');
}





define('tb_Prefix', 'tmb_');

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

$tmp = str_replace(['\\', '/lib'], ['/', ''], dirname(__FILE__));
define('SITE_FS_PATH', $tmp);
define('HOST_FS_PATH', str_replace('/pms', '', $tmp));
define('SITE_PATH', "$protocol://$host" . SITE_SUB_PATH);
define('HOST_PATH', "$protocol://$host");
define('SITE_PATH_ADM', SITE_PATH);
define('UP_FILES_FS_PATH', SITE_FS_PATH . '/uploaded_files');
define('UP_HOST_FS_PATH', HOST_FS_PATH . '/uploaded_files');
//$comp = '';

//define('tblName', $comp);
define('SITE_NAME', 'AGSK & Co');
define('SITE_TITLE', SITE_NAME);
define('POWERED_BY', 'AGSK & Co');
define('DEF_PAGE_SIZE', 25);
define('ITEM_PER_LOAD', 8);

require_once SITE_FS_PATH . "/lib/pdo.inc.php";
require_once SITE_FS_PATH . "/lib/function.inc.php";
require_once SITE_FS_PATH . "/lib/adminfunction.inc.php";
require_once SITE_FS_PATH . "/lib/php_image_magician.php";
require_once SITE_FS_PATH . "/lib/rwmailing.php";
require_once SITE_FS_PATH . "/lib/sendgrid-php/sendgrid-php.php";

$PDO = new dbc();
$RW = new FuncsLib();
$ADMIN = new FuncsAmd();

$SETNG = $PDO->db_fetch_array($PDO->db_query("SELECT * FROM #_setting WHERE pid='1' "));
define('SITE_MAIL', $SETNG['email'] ?? '');
define('SITE_COMP', $SETNG['company'] ?? '');
define('SITE_PHONE', $SETNG['phone'] ?? '');
define('SITE_ADD', $SETNG['address'] ?? '');

define('SMTP_HOST', '');
define('SMTP_PORT', 587);
define('SMTP_USER', '');
define('SMTP_FROM', '');
define('SMTP_PASSWORD', '');
define('SMTP_SECURE', 'NONE');


	/* Admin Path */
	define('ADMIN_DIR', '');
// add here

define('FS_ADMIN', SITE_FS_PATH.'/'.ADMIN_DIR);
//define('FS_ADMIN', 'http://tools.test/');
//echo FS_ADMIN;



// Define Module folder name //
define('_MODS', "modules");
// end her



if (isset($_SERVER['REQUEST_URI']) && in_array($_SERVER['REQUEST_URI'], ['/index.html', '/index.php'])) {
    header("Location: " . SITE_PATH);
    exit;
}
?>
