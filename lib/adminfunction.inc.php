<?php
class FuncsAmd
{
	private $var;
	public function adminsbox()
	{

		return '';
	}

	public function adminebox()
	{
		return '';
	}

	public function breadcrumb($com)
	{

		if ($com == 'pages') {

			return "CMS";
		} else if ($com == 'bg') {

			return "Background";
		} else if ($com == 'dt') {

			return "Device type";
		} else if ($com == 'top') {

			return "Type of product";
		} else if ($com == 'adm') {

			return "CMS User";
		} else if ($com == 'salesorders') {

			return "Sales Orders";
		} else if ($com == 'sales') {

			return "Sales user";
		} else if ($com == 'cate') {

			return "Category";
		} else if ($com == 'category') {

			return "Category";
		} else if ($com == 'member') {

			return "Customers";
		} else if ($com == 'setting') {

			if ($mode == "payment") {

				return "Payment Gateway";
			}
		} else {

			return ucfirst($com);
		}
	}
	public function admincids($val)
	{

		$arr = explode(",", $val);

		$newarr = array();

		foreach ($arr as $k => $v) {

			if ($v)

				$newarr[] = $v;
		}

		return $newarr;
	}
	public function calcinch($f, $i)
	{

		$inch = ($f * (12)) + $i;

		return $inch;
	}

	public function sessset($val, $msg = "")
	{

		$_SESSION['sessmsg'] = $val;

		$_SESSION['alert'] = $msg;
	}

	public function adminpublish($val)
	{

		if ($val == 'Active') {

			return "Deactivate";
		} else {

			return "Activate";
		}
	}
	public function secure()
	{


		if (!$_SESSION["AMD"][0] and !$_SESSION["AMD"][2]) {

			header('Location: '.SITE_PATH_ADM.'login.php');

			echo '

			<script type="text/javascript">



			window.location.href="' . SITE_PATH_ADM . 'login/";



			</SCRIPT>';

			exit;
		}
	}
	public function url($file)
	{

		return SITE_PATH_ADM . $file . ".php";
	}

	public function iurl($comp, $mode = '', $id = '', $action = '')
	{

		return SITE_PATH_ADM . "index.php?comp=" . $comp . (($mode) ? "&mode=" . $mode : '') . (($id) ? "&uid=" . $id : '') . (($action) ? "&action=" . $action : '');
	}

	public function furl($file)
	{

		return SITE_PATH_ADM . $file . "/";
	}



	public function alert()
	{
		if (!empty($_SESSION['alert']) && $_SESSION['alert'] == 'e') {
			echo $this->error();
			unset($_SESSION['sessmsg']);
			$_SESSION['sessmsg'] = '';
		}

		if (isset($_SESSION['alert']) && $_SESSION['alert'] == 'w') {
			echo $this->warning();
			unset($_SESSION['sessmsg']);
			$_SESSION['sessmsg'] = '';
		}

		if (isset($_SESSION['alert']) && $_SESSION['alert'] == 's') {
			echo $this->success();
			unset($_SESSION['sessmsg']);
			$_SESSION['sessmsg'] = '';
		}
	}



	public function info()
	{

		if ($_SESSION['sessmsg']) {

			return '<div class="alert alert-success">' . $_SESSION['sessmsg'] . '</div>';
		}
	}



	public function error()
	{

		if ($_SESSION['sessmsg']) {

			return '<div class="alert alert-danger">' . $_SESSION['sessmsg'] . '</div>';
		}
	}



	public function warning()
	{

		if ($_SESSION['sessmsg']) {

			return '<div class="alert alert-warning">' . $_SESSION['sessmsg'] . '</div>';
		}
	}



	public function success()
	{

		if ($_SESSION['sessmsg']) {

			return '<div class="alert alert-success">' . $_SESSION['sessmsg'] . '</div>';
		}
	}



	public function rowerror($n)
	{

		return '<tr class="grey"><td align="center" colspan="' . $n . '"><b>Sorry! No record in databse.</b></td></tr>';
	}



	public function even_odd($vars)
	{

		if ($vars % 2 == 1) {

			return ' class="grey"';
		}
	}



	public function orders($vars, $files = '')
	{

		return $vars;

		//return '<a href="'.(($files)?$PHP_SELF:'javascript:void(0);').'">'.$vars.'</a>';

	}

	public function norders($vars)
	{

		return $vars;
	}



	public function check_all()
	{

		return '<input name="check_all" type="checkbox" id="check_all" value="1" onClick="checkall(this.form)">';
	}



	public function check_input($vars)
	{

		return '<input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="' . $vars . '">';
	}

	public function actiond($comp, $pid)
	{

		return '<a href="' . SITE_PATH_ADM . 'index.php?comp=' . $comp . '&tagss=deals&mode=dealers-add&uid=' . $pid . '"><img src="' . SITE_PATH_ADM . 'images/icon_edit.png" alt="Edit Record" title="Edit Record"/></a><a href="' . SITE_PATH_ADM . 'index.php?comp=' . $comp . '&uid=' . $pid . '&action=del&tagss=deals" onclick="return confirm(\'Do you want delete this record?\');"><img src="' . SITE_PATH_ADM . 'images/delete-icon.png"  alt="Delete Record"  title="Delete Record"/></a>';
	}

	public function actionSame($comp, $pid, $pgn)
	{

		return '<a href="' . SITE_PATH_ADM . 'index.php?comp=' . $comp . '&mode=add&uid=' . $pid . '&start=' . $pgn . '"><img src="' . SITE_PATH_ADM . 'images/icon_edit.png" alt="Edit Record" title="Edit Record"/></a><a href="' . SITE_PATH_ADM . 'index.php?comp=' . $comp . '&uid=' . $pid . '&action=del&start=' . $pgn . '" onclick="return confirm(\'Do you want delete this record?\');"><img src="' . SITE_PATH_ADM . 'images/delete-icon.png"  alt="Delete Record"  title="Delete Record"/></a>';
	}
	public function actionSub($comp, $pid, $sub, $sid)
	{

		return '<a href="' . SITE_PATH_ADM . 'index.php?comp=' . $comp . '&mode=add&uid=' . $pid . '&' . $sub . '=' . $sid . '"><img src="' . SITE_PATH_ADM . 'images/icon_edit.png" alt="Edit Record" title="Edit Record"/></a><a href="' . SITE_PATH_ADM . 'index.php?comp=' . $comp . '&uid=' . $pid . '&action=del&' . $sub . '=' . $sid . '" onclick="return confirm(\'Do you want delete this record?\');"><img src="' . SITE_PATH_ADM . 'images/delete-icon.png"  alt="Delete Record"  title="Delete Record"/></a>';
	}

	public function action($comp, $pid)
	{



		//return '<table border="0" cellpadding="0" cellspacing="0"><tr><td><a href="'.$vars.'&id='.$ids.'"><img src="'.SITE_PATH_ADM.'images/edit-btn.jpg" alt="Edit record" title="Edit record"/></a></td><td style="padding-left:15px;"><a href="'.SITE_PATH_ADM.(($tags)?$tags:CPAGE).'?id='.$ids.'&action=del&view=true" onclick="return confirm(\'Do you want delete this record?\');"><img src="'.SITE_PATH_ADM.'images/delete-btn.jpg" alt="Delete record" title="Delete record"/></a></td></tr></table>';

		return '<a href="' . SITE_PATH_ADM . 'index.php?comp=' . $comp . (($_GET[start]) ? '&start=' . $_GET[start] : '') . '&mode=add&uid=' . $pid . '"><i class="fa fa-edit"></i></a><a href="' . SITE_PATH_ADM . 'index.php?comp=' . $comp . (($_GET[start]) ? '&start=' . $_GET[start] : '') . '&uid=' . $pid . '&action=del" onclick="return confirm(\'Do you want delete this record?\');"><i class="fa fa-trash"></i></a>';
	}

	public function Eaction($comp, $pid)
	{

		$eurl = SITE_PATH_ADM . 'index.php?comp=' . $comp . '&mode=add&uid=' . $pid;

		return ' onclick="location.href=\'' . $eurl . '\';" ';
	}

	public function Caction($comp, $pid)
	{

		$eurl = SITE_PATH_ADM . 'index.php?comp=' . $comp . '&mode=customquotesupdate&uid=' . $pid;

		return ' onclick="location.href=\'' . $eurl . '\';" ';
	}

	public function cataction($vars, $ids, $tags = '')
	{

		return '<table border="0" cellpadding="0" cellspacing="0"><tr><td><a href="' . $vars . '?id=' . $ids . '"><img src="' . SITE_PATH_ADM . 'images/edit-btn.jpg" alt="Edit record" title="Edit record"/></a></td><td style="padding-left:15px;"><a href="' . SITE_PATH_ADM . (($tags) ? $tags : CPAGE) . '?id=' . $ids . '&action=del&view=true" onclick="return confirm(\'Do you want delete this record?\');"><img src="' . SITE_PATH_ADM . 'images/delete-btn.jpg" alt="Delete record" title="Delete record"/></a></td></tr></table>';
	}

	public function action2($comp, $pid)
	{

		return '<a href="' . SITE_PATH_ADM . 'index.php?comp=' . $comp . '&mode=add&uid=' . $pid . '"><img src="' . SITE_PATH_ADM . 'images/icon_edit.png" alt=""></a><a href="javascript:void(0);"><img  style="opacity:0.8;color:#333; " src="' . SITE_PATH_ADM . 'images/delete-icon.png" alt=""></a>';
	}

	public function actionEX($comp, $pid)
	{

		return '<div align="center"><a href="' . SITE_PATH_ADM . 'index.php?comp=' . $comp . (($_GET[start]) ? '&start=' . $_GET[start] : '') . '&mode=add&uid=' . $pid . '"><img src="' . SITE_PATH_ADM . 'images/icon_edit.png" alt=""></a></div>';
	}



	public function action3($comp, $pid)
	{

		return '<a href="' . SITE_PATH_ADM . 'index.php?comp=' . $comp . '&mode=add&uid=' . $pid . '"><img src="' . SITE_PATH_ADM . 'images/icon_edit.png" alt=""></a>';
	}
	public function actionajax($comp, $pid)
	{

		return '<a class="ajaxopen" href="' . SITE_PATH_ADM . _MODS . '/' . $comp . '/update.php?comp=' . $comp . '&uid=' . $pid . '"><img src="' . SITE_PATH_ADM . 'images/icon_edit.png" alt=""></a>';
	}
	public function action4($comp, $pid)
	{

		return '<a href="' . SITE_PATH_ADM . 'index.php?comp=' . $comp . '&mode=add&uid=' . $pid . '"><img src="' . SITE_PATH_ADM . 'images/view-icon.png" alt=""></a>';
	}

	public function viewmode($comp, $pid)
	{

		return '<a href="' . SITE_PATH_ADM . 'index.php?comp=' . $comp . '&mode=view&uid=' . $pid . '"><img src="' . SITE_PATH_ADM . 'images/view-icon.png" alt=""></a>';
	}



	public function h1_tag($vars, $others = '&nbsp;')
	{

		return '<h1><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="50%" align="left">' . $vars . '</td><td width="50%">' . $others . '</td></tr></table></h1>';
	}



	public function heading($vars)
	{

		return '<h2>' . $vars . '</h2>';
	}
	public function get_editor_s_front($fld, $vals, $w = '45', $h = '4', $cls = 'form-control', $ph = 'Your comments*...', $rq = true)
	{

		$rqd = $rq ? 'required' : '';

		return '<textarea class="' . $cls . '" placeholder="' . $ph . '" cols="' . $w . '" id="' . $fld . '" name="' . $fld . '" rows="' . $h . '" ' . $rqd . ' >' . $vals . '</textarea>

		<script type="text/javascript">

		//<![CDATA[



			// Replace the <textarea id="editor"> with an CKEditor

			// instance, using default configurations.

			CKEDITOR.replace( \'' . $fld . '\',

				{
					allowedContent : true,
					extraPlugins : \'uicolor\',

					toolbar :

					[

						[ \'Bold\', \'Italic\',\'FontSize\', \'-\', \'NumberedList\', \'BulletedList\', \'-\', \'Link\', \'Unlink\' ]

					]

				});



		//]]>

		</script>';
	}
	public function get_editor($fld, $vals, $path = '', $w = '900', $h = '350')
	{
		return '<textarea name="' . $fld . '" id="' . $fld . '"  rows=""  cols="" class="textareas">' . $vals . '</textarea><script type="text/javascript">
				window.onload = function(){
					var editor_' . $fld . '=CKEDITOR.replace(\'' . $fld . '\',{
					allowedContent : true,
					//customConfig: "' . SITE_SUB_PATH . 'lib/ckeditor/config.js",
					//extraPlugins : \'ckawesome\',
			        uiCoor : \'#9AB8F3\',
					width : \'' . $w . 'px\',
					height : \'' . $h . 'px\'
    			} );
				CKFinder.setupCKEditor( editor_' . $fld . ', \'' . SITE_SUB_PATH . 'lib/ckfinder/\' );};</script>';
	}

	/*public function get_editor($fld, $vals, $path='', $w='80', $h='10'){

		return '<textarea name="'.$fld.'" id="'.$fld.'"  rows="$w"  cols="$h" class="textareas">'.$vals.'</textarea><script type="text/javascript">

//<![CDATA[

    CKEDITOR.replace(\''.$fld.'\',

	{

     	fullPage : true,

            extraPlugins : \'\'

    });

//]]>

</script>';

	}*/



	public function get_editor_s($fld, $vals, $w = '45', $h = '7')
	{

		return '<textarea cols="' . $w . '" id="' . $fld . '" name="' . $fld . '" rows="' . $h . '">' . $vals . '</textarea>

		<script type="text/javascript">

		//<![CDATA[



			// Replace the <textarea id="editor"> with an CKEditor

			// instance, using default configurations.

			var sub_' . $fld . '= CKEDITOR.replace( \'' . $fld . '\',

				{
					allowedContent : true,


					toolbar :[
						[\'Source\', \'Bold\', \'Italic\', \'-\', \'NumberedList\', \'BulletedList\', \'-\', \'Link\', \'Unlink\' ],
						[ \'Image\' ]
					],
				});



		//]]>



		CKFinder.setupCKEditor( sub_' . $fld . ', \'' . SITE_SUB_PATH . 'lib/ckfinder/\' );</script>';
	}



	public function imageurl($string)
	{



		/*$string=strtolower($string);

		$string=preg_replace('/\s+/',' ',$string);

		$string=trim($string);

		//$string = str_replace(' ', '-', $string);

		$string =preg_replace('/[^A-Za-z0-9\-]/', '', $string);

		$string = preg_replace('/-+/', '-', $string);*/
		//$string = str_replace(" ", "",trim(strtolower($string)));

		$string = str_replace("/", " ", $string);

		$string = str_replace('\\', " ", $string);

		$string = str_replace("(", "", $string);

		$string = str_replace(")", "", $string);

		$string = str_replace("&", "", $string);

		$string = str_replace("#", "", $string);

		$string = str_replace("---", "", $string);

		$string = str_replace("--", "", $string);

		$string = str_replace("-", "", $string);

		$string = str_replace("&shy;", "", $string);

		$string = str_replace("&minus;", "", $string);

		$string = str_replace("'", "", $string);

		$string = str_replace('"', "", $string);

		$string = str_replace(" –", "", $string);

		$string = str_replace("+", "", $string);

		$string = str_replace(",", "", $string);

		$string = str_replace("   ", " ", $string);

		$string = str_replace("  ", " ", $string);



		return $string;
	}





	public function imagename($designers_sku_code, $design_title, $color_name, $materials, $sub_materials, $speciel_category, $die_type_name, $die_name, $brand_name, $series_name, $model_name)

	{

		$imagename = '';

		if ($designers_sku_code != '') {

			$imagename = $this->imageurl(trim($designers_sku_code));
		}

		if ($design_title != '') {

			$imagename .= ' (' . $this->imageurl(trim($design_title)) . ') ';
		}



		if ($color_name != '') {

			$imagename .= $this->imageurl(trim($color_name)) . ' ';
		}



		if ($materials != '') {

			$imagename .= $this->imageurl(trim($materials)) . ' ';
		}



		if ($sub_materials != '') {

			$imagename .= $this->imageurl(trim($sub_materials)) . ' ';
		}



		if ($speciel_category != '') {

			$imagename .= $this->imageurl(trim($speciel_category)) . ' ';
		}



		if ($die_type_name != '') {

			$imagename .= $this->imageurl(trim($die_type_name)) . ' ';
		}



		if ($die_name != '') {

			$imagename .= $this->imageurl(trim($die_name)) . ' ';
		}



		if ($brand_name != '') {

			$imagename .= 'for ' . $this->imageurl(trim($brand_name)) . ' ';
		}



		if ($series_name != '') {

			$imagename .= $this->imageurl(trim($series_name)) . ' ';
		}



		if ($model_name != '') {

			$imagename .= $this->imageurl($model_name);
		}



		return $imagename;
	}



	public function mk_prdname($color_name, $materials, $sub_materials, $speciel_category, $die_type_name, $die_name, $brand_name, $series_name, $model_name)

	{
		$imagename;



		if ($color_name != '') {

			$imagename .= (trim($color_name)) . ' ';
		}



		if ($materials != '') {

			$imagename .= (trim($materials)) . ' ';
		}



		if ($sub_materials != '') {

			$imagename .= (trim($sub_materials)) . ' ';
		}



		if ($speciel_category != '') {

			$imagename .= (trim($speciel_category)) . ' ';
		}



		if ($die_type_name != '') {

			$imagename .= (trim($die_type_name)) . ' ';
		}



		if ($die_name != '') {

			$imagename .= (trim($die_name)) . ' ';
		}



		if ($brand_name != '') {

			$imagename .= 'for ' . (trim($brand_name)) . ' ';
		}



		if ($series_name != '') {

			$imagename .= (trim($series_name)) . ' ';
		}



		if ($model_name != '') {

			$imagename .= ($model_name);
		}

		return $imagename;
	}




public function baseurl(?string $string): string
{
    $string = $string ?? ''; // Handle null

    if (function_exists('transliterator_transliterate')) {
        $string = transliterator_transliterate('Any-Latin; Latin-ASCII', $string);
    }

    $string = mb_strtolower($string, 'UTF-8');
    $string = preg_replace('/\s+/', ' ', $string);
    $string = trim($string);
    $string = str_replace(' ', '-', $string);
    $string = preg_replace('/[^a-z0-9\-]/', '', $string);
    $string = preg_replace('/-+/', '-', $string);

    return $string;
}



	public function spl($vals)
	{

		$vals = str_replace("'", "&#039;", trim($vals));

		$vals = str_replace('"', "&quot;", trim($vals));

		return $vals;
	}

	public function spl1($vals)
	{

		$vals = str_replace("'", "&#039;", trim($vals));

		return $vals;
	}

	public function viewimage($path, $img)
	{

		if ($img and file_exists(UP_FILES_FS_PATH . "/" . $path . "/" . $img)) {

			return '<a href="' . SITE_PATH . 'uploaded_files/' . $path . '/' . $img . '" target="_blank">View</a>';
		} else {

			return "N/A";
		}
	}
	public function encrypt_decrypt($action, $string)
	{
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = '786';
		$secret_iv = '07';
		// hash
		$key = hash('sha256', $secret_key);

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if ($action == 'encrypt') {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} else if ($action == 'decrypt') {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}


	public function textcount($one, $two, $num)
	{

		return 'onKeyDown="textCounter(document.aforms.' . $one . ',document.aforms.' . $two . ',' . $num . ')" onKeyUp="textCounter(document.aforms.' . $one . ',document.aforms.' . $two . ',' . $num . ')"';
	}

	public function maxnum($name, $num)
	{

		return '<input readonly type="text" name="' . $name . '" size="3" maxlength="3" value="' . $num . '">';
	}



	public function compname($name)

	{

		$name = str_replace('_', ' ', $name);

		$name = ucfirst($name);

		return $name;
	}

	public function displaystatusemail($status)

	{

		switch ($status) {

			case 0:

				$val = 'Not Sent';

				break;

			case 1:

				$val = 'Sent';

				break;


			default:

				//code to be executed if n is different from all labels;

		}



		return $val;
	}
	public function displaystatusadm($status)

	{

		switch ($status) {

			case 0:

				$val = 'Inactive';

				break;

			case 1:

				$val = 'Active';

				break;


			default:

				//code to be executed if n is different from all labels;

		}



		return $val;
	}

	public function displayPaymentMode($status)

	{

		switch ($status) {

			case 0:

				$val = 'Cash';

				break;

			case 1:

				$val = 'Cheque';

				break;
			case 2:

				$val = 'NEFT';

				break;
			case 3:

				$val = 'Link';

				break;

			case 4:

				$val = 'Paytm';

				break;

			default:

				//code to be executed if n is different from all labels;

		}



		return $val;
	}

	public function displayflightName($name)

	{

		switch ($name) {

			case 'airindia':

				$val = 'AirIndia';

				break;

			case 'jetairways':

				$val = 'JetAirways';

				break;
			case 'airindiaexpress':

				$val = 'AirIndia Express';

				break;
			case 'indigo':

				$val = 'IndiGo';

				break;

			case 'emirates':

				$val = 'Emirates';

				break;

			case 'etihad':

				$val = 'Etihad Airways';

				break;

			case 'flydubai':

				$val = 'flydubai';

				break;

			case 'spicejet':

				$val = 'Spicejet';

				break;

			case 'srilankan':

				$val = 'Srilanka Airlines';

				break;

			case 'airarbia':

				$val = 'Air Arabia';

				break;

			case 'gulfair':

				$val = 'Gulf Air';

				break;

			default:

				//code to be executed if n is different from all labels;

		}



		return $val;
	}



	public function activityGroup($status)

	{

		switch ($status) {

			case 1:

				$val = 'Phone Call';

				break;

			case 2:

				$val = 'Waste';

				break;
			case 3:

				$val = 'Follow Up';
				break;


			case 4:

				$val = 'Meeting';
				break;



			case 5:

				$val = 'Quotation';

				break;


			case 6:

				$val = 'Payment';

				break;

			case 7:

				$val = 'Invoice';
				break;
			case 8:

				$val = 'Order';
				break;

			case 9:

				$val = 'Travel Planning';
				break;
			case 10:

				$val = 'Client Travelled';
			default:

				//code to be executed if n is different from all labels;

		}



		return $val;
	}
	public function displaystatusModuleAccess($status)

	{

		switch ($status) {

			case 1:

				$val = 'SEO Master';

				break;

			case 2:

				$val = 'TM Master';

				break;
			case 3:

				$val = 'Proposals Manager';

				break;
			case 4:

				$val = 'My Leads';

				break;

			case 5:

				$val = 'Invoice Manager';

				break;
			case 6:

				$val = 'Master';

				break;
			case 7:

				$val = 'CRMS';

				break;

			default:

				//code to be executed if n is different from all labels;

		}



		return $val;
	}

	public function displaystatusLeave($status)

	{

		switch ($status) {

			case 0:

				$val = 'Pending';

				break;

			case 1:

				$val = 'Approved';

				break;

			case 2:

				$val = 'Disapproved';

				break;
			default:

				//code to be executed if n is different from all labels;

		}



		return $val;
	}

	public function displayWorkType($workType)

	{

		switch ($workType) {

			case 1:

				$val = 'GST Compliance';

				break;

			case 2:

				$val = 'Income Tax Return';

				break;
			case 3:

				$val = 'Service Tax';

				break;
			case 4:

				$val = 'VAT Compliance';

				break;
			case 5:

				$val = 'Other';

				break;

			default:

				//code to be executed if n is different from all labels;

		}



		return $val;
	}


	public function displaystatusCompliance($status)

	{

		switch ($status) {

			case 0:

				$val = 'Open';

				break;

			case 1:

				$val = 'Close';

				break;


			default:

				//code to be executed if n is different from all labels;

		}



		return $val;
	}
	public function getMonthName($values)

	{
		switch ($values) {
			case 1:
				$values = 'January';
				break;
			case 2:
				$values = 'February';
				break;
			case 3:
				$values = 'March';
				break;
			case 4:
				$values = 'April';
				break;
			case 5:
				$values = 'May';
				break;
			case 6:
				$values = 'June';
				break;
			case 7:
				$values = 'July';
				break;
			case 8:
				$values = 'August';
				break;
			case 9:
				$values = 'September';
				break;
			case 10:
				$values = 'October';
				break;
			case 11:
				$values = 'November';
				break;
			case 12:
				$values = 'December ';
				break;
			default:

				//code to be executed if n is different from all labels;

		}



		return $values;
	}
	public function displayorderstatus($pstatus)

	{

		switch ($pstatus) {

			case 0:

				$val = 'Pending';

				break;

			case 1:

				$val = 'Successful';

				break;
			case 2:

				$val = 'failure';

				break;

			default:

				//code to be executed if n is different from all labels;

		}



		return $val;
	}
	public function displayprojectstatus($pstatus)

	{

		switch ($pstatus) {

			case 0:

				$val = 'Open';

				break;

			case 1:

				$val = 'Closed';

				break;


			default:

				//code to be executed if n is different from all labels;

		}



		return $val;
	}

	public function displayLeadsstatus($status)

	{

		switch ($status) {

			case 1:

				$val = 'Potential';

				break;

			case 2:

				$val = 'Med. Report Received';

				break;

			case 3:

				$val = 'Treatment Reverted';

				break;
			case 4:

				$val = 'Visa Process';

				break;

			case 5:

				$val = 'Travel Confirmation';

				break;

			case 6:

				$val = 'Treatment/Admission';


			default:


				//code to be executed if n is different from all labels;

		}



		return $val;
	}

	public function displaystatus($status)

	{

		switch ($status) {

			case 0:

				$val = 'Processing';

				break;

			case 1:

				$val = 'Document Recieved';

				break;

			case 2:

				$val = 'Work Started';

				break;
			case 3:

				$val = 'File Sent';

				break;
			case 4:

				$val = 'File Recieved';

				break;
			case 5:

				$val = 'Form Upload';

				break;
			case 6:

				$val = 'Work Complete';

				break;




			default:

				//code to be executed if n is different from all labels;

		}



		return $val;
	}



	public function user_type($user)

	{

		switch ($user) {



			case 1:
				$val = 'Operation Head';

				break;
			case 2:
				$val = 'Team Head';

				break;
			case 3:
				$val = 'Sales Head';

				break;
			case 4:
				$val = 'Executive Assistance';

				break;
			case 5:
				$val = 'Business Consultant';

				break;
			case 6:
				$val = 'CEO';

				break;
			case 7:
				$val = 'COO';

				break;
			default:

				//code to be executed if n is different from all labels;

		}



		return $val;
	}
	public function html_cut($text, $max_length)

	{

		$tags   = array();

		$result = "";



		$is_open   = false;

		$grab_open = false;

		$is_close  = false;

		$in_double_quotes = false;

		$in_single_quotes = false;

		$tag = "";



		$i = 0;

		$stripped = 0;



		$stripped_text = strip_tags($text);



		while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length) {

			$symbol  = $text[$i];


			$result .= $symbol;



			switch ($symbol) {

				case '<':

					$is_open   = true;

					$grab_open = true;

					break;



				case '"':

					if ($in_double_quotes)

						$in_double_quotes = false;

					else

						$in_double_quotes = true;



					break;



				case "'":

					if ($in_single_quotes)

						$in_single_quotes = false;

					else

						$in_single_quotes = true;



					break;



				case '/':

					if ($is_open && !$in_double_quotes && !$in_single_quotes) {

						$is_close  = true;

						$is_open   = false;

						$grab_open = false;
					}



					break;



				case ' ':

					if ($is_open)

						$grab_open = false;

					else

						$stripped++;



					break;



				case '>':

					if ($is_open) {

						$is_open   = false;

						$grab_open = false;

						array_push($tags, $tag);

						$tag = "";
					} else if ($is_close) {

						$is_close = false;

						array_pop($tags);

						$tag = "";
					}



					break;



				default:

					if ($grab_open || $is_close)

						$tag .= $symbol;



					if (!$is_open && !$is_close)

						$stripped++;
			}



			$i++;
		}

		$j = 1;

		while ($tags) {

			if ($j == 1) $result .= " ....</" . array_pop($tags) . ">";

			else $result .= "</" . array_pop($tags) . ">";

			$j++;
		}
		$result = preg_replace('/(<[^>]+) calibri".*?"/i', '$1', $result);
		return $result;
	}

	public function send_mail($mailer_arr)
	{
		$mailer_arr = array_merge(array('to' => '', 'from_name' => '', 'from' => '', 'subject' => '', 'message' => '', 'cc' => '', 'bcc' => '', 'file_name' => '', 'file_path' => ''), $mailer_arr);
		$EmailTo = strip_tags($mailer_arr['to']);
		$EmailFrom = strip_tags($mailer_arr['from']);
		$EmailFromNmae = strip_tags($mailer_arr['from_name']);
		$EmailSubject = $mailer_arr['subject'];
		$EmailMessage = stripslashes($mailer_arr['message']);
		$EmailCc = strip_tags($mailer_arr['cc']);
		$EmailBcc = strip_tags($mailer_arr['bcc']);
		$filepath = $mailer_arr['file_path'];
		$filename = $mailer_arr['file_name'] ? $mailer_arr['file_name'] : end(explode("/", $filepath));
		$eol = PHP_EOL;
		$headers = "";
		if (!empty($EmailFromNmae)) {
			if (!empty($EmailFrom))
				$headers  .= "From: " . $EmailFromNmae . '<' . $EmailFrom . '>' . $eol;
		} else {
			if (!empty($EmailFrom))
				$headers  .= "From: " . $EmailFrom . $eol;
		}
		if (!empty($EmailFrom))
			$headers .= "Reply-To: " . $EmailFrom . $eol;
		if (!empty($EmailCc))
			$headers .= "CC: " . $EmailCc . $eol;
		if (!empty($EmailBcc))
			$headers .= "BCC: " . $EmailBcc . $eol;
		$headers .= "MIME-Version: 1.0" . $eol;
		if (!isset($mailer_arr['file_path']) || $mailer_arr['file_path'] == '') {
			$headers .= "Content-type: text/html" . $eol;
			if (mail($EmailTo, $EmailSubject, $EmailMessage, $headers))
				return true;
			else
				return false;
		}
		$attachment = chunk_split(base64_encode(file_get_contents($filepath)));
		$separator = md5(time());
		$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"";
		$body = "";
		$body .= "--" . $separator . $eol;
		$body .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
		$body .= "Content-Transfer-Encoding: 7bit" . $eol . $eol; //optional defaults to 7bit
		$body .= $EmailMessage . $eol;
		// attachment
		$body .= "--" . $separator . $eol;
		$body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
		$body .= "Content-Transfer-Encoding: base64" . $eol;
		$body .= "Content-Disposition: attachment" . $eol . $eol;
		$body .= $attachment . $eol;
		$body .= "--" . $separator . "--";
		// send message
		if (mail($EmailTo, $EmailSubject, $body, $headers, '-f' . $EmailFrom)) {
			return true;
		} else {
			return false;
		}
	}
}
