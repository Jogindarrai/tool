<?php include("../lib/config.inc.php");

   $filepath = $_GET[files];

   header('Content-Type: application/octet-stream');

		header("Content-Transfer-Encoding: Binary"); 

		header("Content-disposition: attachment; filename=\"" . basename($filepath ) . "\""); 

		 @readfile($filepath);

 unlink($_GET[files]);

   //header("Pragma: public");

//   header("Expires: 0");

//   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

//   //setting content type of page

//   header("Content-Type: application/force-download");

//   header("Content-Disposition: attachment; filename=".basename($filepath ));

//   header("Content-Description: File Transfer");

//   @readfile($filepath);

//   unlink($_GET[files]);

?>