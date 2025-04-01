<?php


	ini_set('session.gc_maxlifetime', 18000);
    session_set_cookie_params(18000);
	@session_start();
	/*$inactive = 18000;
$session_life = time() - $_session['timeout'];
if($session_life > $inactive)
{  session_destroy(); //header("Location: logoutpage.php");
   }
$_session['timeout']=time();*/
	@extract($_POST);
	@extract($_GET);
	@extract($_SERVER);
	@extract($_SESSION);
	@error_reporting(E_ALL ^ E_NOTICE);
	error_reporting(0);

	ini_set('register_globals', 'on');

	ini_set('memory_limit', '800M');
	set_time_limit(0);
	ini_set('post_max_size',"300M");
	ini_set('upload_max_filesize',"800M");
	ini_set('max_upload_filesize',"800M");
	ini_set("max_input_time",36000);

	//ini_set('max_input_vars', 10000);

	// Define Time Zone //
	@date_default_timezone_set('Asia/Kolkata');

	if ($HTTP_HOST == "127.0.0.1" || $HTTP_HOST == "localhost" || $HTTP_HOST == "Ajay" )
	{
		define('LOCAL_MODE', true);
	} else {
		define('LOCAL_MODE', false);
		//die('<span style="font-family: tahoma, arial; font-size: 11px">config file cannot be included directly');
	}

	if (LOCAL_MODE || $HTTP_HOST == 'Ajay' || $HTTP_HOST == '192.168.0.1')
	{
		/*Localhost database detail*/
		$ARR_DBS["dbs"]['host'] = 'localhost';
		$ARR_DBS["dbs"]['name'] = 'tools';
    	$ARR_DBS["dbs"]['user'] = 'root';
		$ARR_DBS["dbs"]['password'] = '';
		define('SITE_SUB_PATH', '/tools/');
		/*$ARR_DBS["dbs"]['host'] = 'formalfunky.com';
		$ARR_DBS["dbs"]['name'] = 'formaekv_funky_new';
    	$ARR_DBS["dbs"]['user'] = 'formaekv_fun';
		$ARR_DBS["dbs"]['password'] = 'bP}}hKTQ9ikf';
		define('SITE_SUB_PATH', '/formal_funky_live/');*/

	} else {
		/* live database connection */
	$ARR_DBS["dbs"]['host'] = 'localhost';
		$ARR_DBS["dbs"]['name'] = 'u783300902_agsktool';
    	$ARR_DBS["dbs"]['user'] = 'u783300902_agsktooluser';
		$ARR_DBS["dbs"]['password'] = '3*Pzc13XZ5';
		define('SITE_SUB_PATH', '/tool/');

 	}

	// Database table prefix //
	define('tb_Prefix', 'tmb_');

    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {$protocol = "https"; } else {$protocol = "http"; }

    /* Define Directory file Path */
    $tmp = dirname(__FILE__);
	$tmp = str_replace('\\' ,'/',$tmp);
	$tmp = str_replace('/lib' ,'',$tmp);
	define('SITE_FS_PATH', $tmp);
	$tmph = str_replace('/pms' ,'',$tmp);
	define('HOST_FS_PATH', $tmph);
	define('_JEXEC', $tmp);

	/* Site Path */
	define('SITE_PATH', $protocol.'://'.$HTTP_HOST.SITE_SUB_PATH);
	define('HOST_PATH', $protocol.'://'.$HTTP_HOST);

	/*SEqure Site Path */
	define('SITE_PATH_S', $protocol.'://'.$HTTP_HOST.SITE_SUB_PATH);
	/* Admin Path */
	define('ADMIN_DIR', '');
	//define('SITE_PATH_ADM', 'http://'.$HTTP_HOST.SITE_SUB_PATH.ADMIN_DIR);
	define('SITE_PATH_ADM', $protocol.'://'.$HTTP_HOST.SITE_SUB_PATH);

	/*Define Live Site Path*/
	define('LIVE_SITE_PATH_ADM', '');
	define('LIVE_SITE_PATH', '');

    /* plugins Path */
	define('PLUGINS_DIR', 'lib/plugins');

	 /* file upload Path */
	define('UP_FILES_FS_PATH', SITE_FS_PATH.'/uploaded_files');
	define('UP_HOST_FS_PATH', HOST_FS_PATH.'/uploaded_files');

	define('FS_ADMIN', SITE_FS_PATH.'/'.ADMIN_DIR);

	// Define Module folder name //
	define('_MODS', "modules");



	define('PWDBYL', 'AGSK & Co');
	define('PWDBY', 'AGSK & Co');

	/* Site name */
	define('SITE_NAME', 'AGSK & Co');
	define('SITE_TITLE', SITE_NAME);
	define('POWERED_BY', 'AGSK & Co');

	// pagination defalut limt
	define('DEF_PAGE_SIZE', 25);


	define('ORDERP', 10000);
	// define table name ///
	define('tblName', $comp);

	define('CUR', '');
	define('CURRN', 'Rs ');
define('SENDGRID_API_KEY', '');
	// Include files

	require_once(SITE_FS_PATH."/lib/pdo.inc.php");
	require_once(SITE_FS_PATH."/lib/function.inc.php");
	require_once(SITE_FS_PATH."/lib/adminfunction.inc.php");
	require_once(SITE_FS_PATH."/lib/function.inc.php");
	require_once(SITE_FS_PATH."/lib/php_image_magician.php");
	require_once(SITE_FS_PATH."/lib/rwmailing.php");
	require_once(SITE_FS_PATH."/lib/sendgrid-php/sendgrid-php.php");
	//require_once(SITE_FS_PATH.'/smtp_mail/class.phpmailer.php');
    //require_once(SITE_FS_PATH."/smtp_mail/class.smtp.php");

    // Data base class object
	$PDO = new dbc();

	// comman function lass object
	$RW = new FuncsLib();

	// Admin function file ///
	$ADMIN = new FuncsAmd();

	//$RW = new Rwmail();


	$SETNG = $PDO->db_fetch_array($PDO->db_query("select * from #_setting where pid='1' "));
	define('SITE_MAIL', $SETNG[email]);
	define('SITE_COMP', $SETNG[company]);
	define('SITE_PHONE', $SETNG[phone]);
	define('SITE_ADD', $SETNG[address]);
	define('SITE_TW', $SETNG[twitter]);
	define('SITE_FB', $SETNG[facebook]);
	define('SITE_IN', $SETNG[linkedin]);
	define('SITE_U', $SETNG[youtube]);
	define('CODC', $SETNG[codc]);
	define('CODA', $SETNG[codcor]);
	define('CODAMT', $SETNG[codamt]);
	define('SHP', $SETNG[ship]);
	define('SHPA', $SETNG[shipamt]);
	define('DOMAINS', $SETNG[domains]);
	define('TAX', $SETNG[tax]);
	define('STOKQTY', 5);

	define('PRD_PER_PAGE', 4);

	define('SMTP_HOST', '');
	define('SMTP_PORT', 587);
	define('SMTP_USER', '');
	define('SMTP_FROM', '');
	define('SMTP_PASSWORD', '');
	define('SMTP_SECURE', 'NONE');

	define('ITEM_PER_LOAD', 8);


	$PRECH_BY =array('1'=>'Trademarkbazaar','3'=>'');


	if($_SERVER['REQUEST_URI']=='/index.html' || $_SERVER['REQUEST_URI']=='/index.php')
	{
          header('location:'.SITE_PATH);
		  exit;
	}
?>

ye code php me php ke 7.4 ke accrding bana hai abhi php 8.2 ke uppar chala hai main main chata hoom sare erro display ho yaha par
