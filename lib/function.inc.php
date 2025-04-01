<?php

class FuncsLib extends dbc
{ 
    /* check form submit by post mathed*/
    public function is_post_back() {
		if(count($_POST)>0) {
			return true;
		} else {
			return false;
		}
	
	}

    /* form start function */
     public function  sform($vals='')
	 {
		return '<form id="formID" class="formular" method="post" enctype="multipart/form-data" name="aforms" action=""  '.$vals.'><input type="hidden" name="action" id="action"/>';
	 }
	
	/* form end function */
	 public function  eform()
	 {
		return '</form>';
	 }
	 
	 
	 public function redir($url,$inpage=0)
	 {
		if($inpage==0)
		{
			header('location: '.$url) or die("Cannot Send to next page");
			exit;
		}else {
			echo '
			<script type="text/javascript">
			<!--
			window.location.href="'.$url.'";
			-->
			</SCRIPT>'
			;
			exit;
		}
	}
	
	public function qry_str($arr, $skip = '') {
		$s = "?";
		$i = 0;
		foreach($arr as	$key =>	$value) {
			if ($key !=	$skip) {
				if (is_array($value)) {
					foreach($value as $value2) {
						if ($i == 0) {
							$s .= $key . '[]=' . $value2;
							$i = 1;
						} else {
							$s .= '&' .	$key . '[]=' . $value2;
						}
					}
				} else {
					if ($i == 0) {
						$s .= "$key=$value";
						$i = 1;
					} else {
						$s .= "&$key=$value";
					}
				}
			}
		}
		return $s;
	}
	
	public function getFilename($filename) {
		$uniq = uniqid("");
		$arr=explode('.',$filename);
		$ext = $arr[count($arr)-1];
	
		$allowed = "/[^a-z0-9\\_]/i";
		$arr[0] = preg_replace($allowed,"",$arr[0]);
	
		$filename=$uniq.$arr[0]."_.".$ext;
	
		return $filename;
	}
	public function getextention($fname){
		$fext=explode(".",$fname);
		$ext=$fext[count($fext)-1];
		return $ext;
	}
	
	public  function checkpath($PATH){
		if(!is_dir($PATH)){
			mkdir($PATH,0777);
		}
	}
	
	public function uploadFile3($PATH,$FILENAME,$FILEBOX,$SONGNAME)
	{
		$SONGNAME=trim($SONGNAME);
		$SONGNAME=str_replace(' ', '_', $SONGNAME);
		//$BSC = new DAL();	
	    $this->checkpath($PATH);

	   $PATH = $PATH.'/';

	   $ext=$this->getextention($FILENAME);

	   $FILENAME=$SONGNAME."_".mt_rand(1,1000).".".$ext;


     	//$FILENAME = renamefile($PATH,$fname);

	   $file=$PATH.$FILENAME;
	
	
	  $uploaded="TRUE";
	global $_FILES;
    if (! @file_exists($file))
    {

		if ( isset( $_FILES[$FILEBOX] ) )
        {
			if (is_uploaded_file($_FILES[$FILEBOX]['tmp_name']))
            {
				move_uploaded_file($_FILES[$FILEBOX]['tmp_name'], $file);
            }else{
				$uploaded="FALSE";
            }
        }
    } //end of if @fileexists
	return $FILENAME;
	
	}
	
	
	public function uploadFile2($PATH,$FILENAME,$FILEBOX)
	{
		
		//$BSC = new DAL();	
	    $this->checkpath($PATH);

	   $PATH = $PATH.'/';

	   $ext=$this->getextention($FILENAME);

	   $FILENAME=time()."_".mt_rand(1,1000).".".$ext;


     	//$FILENAME = renamefile($PATH,$fname);

	   $file=$PATH.$FILENAME;
	
	
	  $uploaded="TRUE";
	global $_FILES;
    if (! @file_exists($file))
    {

		if ( isset( $_FILES[$FILEBOX] ) )
        {
			if (is_uploaded_file($_FILES[$FILEBOX]['tmp_name']))
            {
				move_uploaded_file($_FILES[$FILEBOX]['tmp_name'], $file);
            }else{
				$uploaded="FALSE";
            }
        }
    } //end of if @fileexists
	return $FILENAME;
	
	}
	
	
	
	
	public function uploadFile($PATH,$FILENAME,$FILEBOX){
		global $temp_file; 
		$this->checkpath($PATH);
		$PATH = $PATH.'/';
		$ext = strtolower($this->getextention($FILENAME));
		$FILENAME_= time()."_".mt_rand(1,1000);
		$temp_file = THUMB_CACHE_DIR.$FILENAME_;
		if (isset($_FILES[$FILEBOX])){
			switch($_FILES[$FILEBOX]['type']){
				case "image/png":
					 $file = $temp_file.".".$ext;
					 $FILENAME = $FILENAME_.".jpg";
					 move_uploaded_file($_FILES[$FILEBOX]['tmp_name'], $file);
				/*     $imageObject = imagecreatefrompng($file);
					 imagejpeg($imageObject,$PATH.$FILENAME);
					 unlink($file);
					 imagedestroy($imageObject);*/
					 $input_file = $file;
					 $output_file = $FILENAME;
					 $input = imagecreatefrompng($file);
					 list($width, $height) = getimagesize($file);
					 $output = imagecreatetruecolor($width, $height);
					 $white = imagecolorallocate($output,  255, 255, 255);
					 imagefilledrectangle($output, 0, 0, $width, $height, $white);
					 imagecopy($output, $input, 0, 0, 0, 0, $width, $height);
					 imagejpeg($output, $PATH.$FILENAME);
					 unlink($file);
					 break;
				case "image/gif":
					$file = $temp_file.".".$ext;
					$FILENAME = $FILENAME_.".jpg";
					move_uploaded_file($_FILES[$FILEBOX]['tmp_name'], $file);
					$imageObject = imagecreatefromgif($file);
					imagejpeg($imageObject,$PATH.$FILENAME);
					unlink($file);
					imagedestroy($imageObject);
					break; 
				case "image/bmp":
					$file = $temp_file.".".$ext;
					$FILENAME = $FILENAME_.".jpeg";
					move_uploaded_file($_FILES[$FILEBOX]['tmp_name'], $file);
					$imageObject = imagecreatefromwbmp($file);
					imagejpeg($imageObject,$PATH.$FILENAME);
					unlink($file);
					imagedestroy($imageObject);
					break; 
				default:
					$file = $PATH.$FILENAME_.".".$ext;
					$FILENAME = $FILENAME_.".".$ext;
					move_uploaded_file($_FILES[$FILEBOX]['tmp_name'], $file);	
			}
		}	
		return $FILENAME;
	}
	
	public function make_thumb_gd($imgPath, $destPath, $newWidth, $newHeight, $ratio_type = 'width', $quality = 80, $verbose = false) {
		
		$size = getimagesize($imgPath);
		if (!$size) {
			if ($verbose) {
				echo "Unable to read image info.";
			}
			return false;
		}
		$curWidth	= $size[0];
		$curHeight	= $size[1];
		$fileType	= $size[2];
	
		// width/height ratio
		$ratio =  $curWidth / $curHeight;
		$thumbRatio = $newWidth / $newHeight;
	
		$srcX = 0;
		$srcY = 0;
		$srcWidth = $curWidth;
		$srcHeight = $curHeight;
	
		if($ratio_type=='width_height') {
			$tmpWidth	= $newHeight * $ratio;
			if($tmpWidth > $newWidth) {
				$ratio_type='width';
			} else {
				$ratio_type='height';
			}
		}
	
	   if($ratio_type=='width') {
			// If the dimensions for thumbnails are greater than original image do not enlarge
			if($newWidth > $curWidth) {
				$newWidth = $curWidth;
			}
			$newHeight	= $newWidth / $ratio;
		} else if($ratio_type=='height') {
			// If the dimensions for thumbnails are greater than original image do not enlarge
			if($newHeight > $curHeight) {
				$newHeight = $curHeight;
			}
			$newWidth	= $newHeight * $ratio;
		} else if($ratio_type=='crop') {
			if($ratio < $thumbRatio) {
				$srcHeight = round($curHeight*$ratio/$thumbRatio);
				$srcY = round(($curHeight-$srcHeight)/2);
			} else {
				$srcWidth = round($curWidth*$thumbRatio/$ratio);
				$srcX = round(($curWidth-$srcWidth)/2);
			}
		} else if($ratio_type=='distort') {
		}
	
		// create image
		switch ($fileType) {
			case 1:
				if (function_exists("imagecreatefromgif")) {
					$originalImage = imagecreatefromgif($imgPath);
				} else {
					if ($verbose) {
						echo "GIF images are not support in this php installation.";
						return false;
					}
				}
				$fileExt = 'gif';
				break;
			case 2:
				$originalImage = imagecreatefromjpeg($imgPath);
				$fileExt = 'jpg';
				break;
			case 3:
				$originalImage = imagecreatefrompng($imgPath);
				$fileExt = 'png';
				break;
			default:
				if ($verbose) {
					echo "Not a valid image type.";
				}
				return false;
		}
		// create new image
	
		$resizedImage = imagecreatetruecolor($newWidth, $newHeight);
		//echo "$srcX, $srcY, $newWidth, $newHeight, $curWidth, $curHeight";
		//echo "<br>$srcX, $srcY, $newWidth, $newHeight, $srcWidth, $srcHeight<br>";
		imagecopyresampled($resizedImage, $originalImage, 0, 0, $srcX, $srcY, $newWidth, $newHeight, $srcWidth, $srcHeight);
		imageinterlace($resizedImage, 1);
		switch ($fileExt) {
			case 'gif':
				imagegif($resizedImage, $destPath, $quality);
				break;
			case 'jpg':
				imagejpeg($resizedImage, $destPath, $quality);
				break;
			case 'png':
				imagepng($resizedImage, $destPath, $quality);
				break;
		}
		// return true if successfull
		return true;
	}
	
	public function url($url, $dir='')
	{
		return SITE_PATH.(($dir)?$dir."/":'').$url.".html";
	}
	
	public function product_price($price)
	{
		$price = CUR.number_format(($price),2);
		
		return $price;
	}
	
	public function shipping_price($price)
	{
		$price = CUR.number_format(($price),2);
		
		return $price;
	}
	
	public function display_price($price)
	{
		$price = CUR.number_format(($price),2);
		
		return $price;
	}
	
	
	
	
	public function mak_skucode($designers_sku_code, $brand_name, $series_name, $model_name, $die_type_name, $materials, $sub_materials, $speciel_category,$color_name, $image_sku_code)
	{
	
	    $data  =$designers_sku_code;
	    $data .=ucfirst(substr(strtolower($brand_name), 0, 1));
		$data .=ucfirst(substr(strtolower($series_name), 0, 1));
		
		$model_name_arr =explode(' ',$model_name);
		
		for($i=0;$i < count($model_name_arr) && $i<2; $i++)
		{
			 $mdl .=ucfirst(substr(strtolower($model_name_arr[$i]), 0, 3));
			
		}		
		$data .=$mdl;
		$data .=ucfirst(substr(strtolower($die_type_name), 0, 2));
		$data .=ucfirst(substr(strtolower($materials), 0, 3));
		$data .=ucfirst(substr(strtolower($sub_materials), 0, 3));
		$data .=ucfirst(substr(strtolower($speciel_category), 0, 3));
		
		
		$data .=ucfirst(substr(strtolower($color_name), 0, 3));
		$data .=$image_sku_code;
		
		return $data;
		
	}
public function fsessset($val, $msg=""){
		$_SESSION['fsessmsg'] = $val;
		$_SESSION['falert'] = $msg;
	}	

public function falert(){
		if($_SESSION['falert']=='e'){
			echo $this->error();
			unset($_SESSION['fsessmsg']);$_SESSION['fsessmsg']='';
		}
		if($_SESSION['falert']=='w'){
			echo $this->fwarning();	
			unset($_SESSION['fsessmsg']);$_SESSION['fsessmsg']='';
		}
		if($_SESSION['falert']=='s'){
			echo $this->fsuccess();	
			unset($_SESSION['fsessmsg']);$_SESSION['fsessmsg']='';
		}
		if($_SESSION['falert']=='i'){
			echo $this->finfo();	
			unset($_SESSION['fsessmsg']);$_SESSION['fsessmsg']='';
		}
	}
	
	public function finfo() {
		if($_SESSION['fsessmsg']){
			return '<div class="alert alert-info alert-dismissable text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$_SESSION['fsessmsg'].'</div>';		
		}
	}
	
	public function error() {
		if($_SESSION['fsessmsg']){
			return '<div class="alert alert-danger alert-dismissable text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$_SESSION['fsessmsg'].'</div>';		
		}
	}
	
	public function fwarning() {
		if($_SESSION['fsessmsg']){
			return '<div class="alert alert-warning alert-dismissable text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$_SESSION['fsessmsg'].'</div>';		
		}	
	}
	
	public function fsuccess() {
		if($_SESSION['fsessmsg']){
			return '<div class="alert alert-success alert-dismissable text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$_SESSION['fsessmsg'].'</div>';	
		}	
	}		
		
	public function sendmail($to, $subject, $message, $fname='', $femail=''){
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.(($fname)?$fname:$this->getSingleresult("select company from #_setting where `pid`='1'")).' <'.(($femail)?$femail:$this->getSingleresult("select email from #_setting where `pid`='1'")).'>' . "\r\n";
		@mail($to, $subject, $message, $headers);
	}
	
	public function cart_totalprice()
	{
		 $had_cart_query = $this->db_query("select * from #_cart where `ssid`='".$_SESSION["ssid"]."' order by id ASC");
		 while($had_cart_rows = $this->db_fetch_array($had_cart_query))
		 {
			 
			  $product_query = $this->db_query("select * from #_products where status ='1' and pp_id='".$had_cart_rows['proid']."' ");
			  $product_rows = $this->db_fetch_array($product_query);
			  
			 // $prd_name =explode(' for ',$product_rows['product_name']);
			  
			  $UnitPrice =$had_cart_rows['price'];
			  
			  $QtyPrice =$had_cart_rows['price']*$had_cart_rows['qty'];
			  
			  $GtotalProce = $GtotalProce + $QtyPrice;  
			  $Gquantity = $Gquantity + $had_cart_rows['qty'];
		 }
		 $arr=array();
		 $arr['Gquantity']=($Gquantity)?$Gquantity:0;
		 $arr['GtotalProce']=($GtotalProce)?$GtotalProce:0;
		 return $arr;
	}
public function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = '786';
    $secret_iv = '07';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}	
	public function emailSignature($userType)
	{ $signature='<table width="100%" border="0" style="max-width:540px; font-size:12px; color:#00293c; font-family:Arial, Helvetica, sans-serif; " cellspacing="0"> <tr><td width="30%" style="padding-bottom:30px;">Thanks & Warm Regards</td></tr> <tr> <td>'.$_SESSION["AMD"][1].'</td> </tr> <tr>   <td>'.$userType.'</td> </tr> <tr>   <td>trademarkbazaar.com</td> </tr> <tr>   <td>STARTUPNOTE INDIA PRIVATE LIMITED</td> </tr> <tr>   <td>Address: 169 Third Floor Kapil Vihar, Pitampura, New Delhi-110034 </td> </tr> <tr>   <td>Website: <a href="#">www.trademarkbazaar.com</a></td> </tr>
                    </table>
<table width="100%" border="0"  style="font-size:12px;  font-family:Arial, Helvetica, sans-serif;"> <tr>   <td width="35%" >Mobile No :  +91 '.$_SESSION["AMD"][4].'</td>   <td width="65%" >Email ID : '.$_SESSION["AMD"][2].'</td> </tr></table>
 <table width="100%" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px"  cellspacing="0"> <tr> </tr> <tr>   <td style="border-top:dashed #ccc 1px; border-bottom:dashed #ccc 1px; padding:4px 0px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">       <tr>         <td colspan="4"><img src="'.SITE_PATH.'images/logo.png" width="130"></td>       </tr>       <tr>         <td width="2%" ><img src="'.SITE_PATH.'images/social-media/phone.png"></td>         <td style=" font-size:12px;"  width="36%"> +91-9999-462-751</td>         <td  width="2%"><img src="'.SITE_PATH.'images/social-media/mail.png"></td>         <td width="60%" style="font-size:12px;"> support@trademarkbazaar.com </td>       </tr>     </table></td> </tr> <tr>   <td><table width="100%" border="0"  style=" max-width:180px; margin-top:0px; ">       <tr>         <td align="left"><a href="https://www.facebook.com/trademarkbazaar/"><img src="https://trademarkbazaar.com/images/emailer/face.png"></a></td>         <td align="left"><a href="https://twitter.com/TrademarkBazaar"><img src="https://trademarkbazaar.com/images/emailer/twitter.png"></a></td>         <td align="left"><a href="https://www.linkedin.com/in/trademark-bazaar-075300144/"><img src="https://trademarkbazaar.com/images/emailer/link.png"></a></td>                         </tr>     </table></td> </tr>
                    </table>';
		 return $signature;
	}
	public function convert_number_to_words($number) 
	{

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . $this->convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . $this->convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= $this->convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
  }
}
?>