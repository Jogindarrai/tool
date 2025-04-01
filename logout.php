<?php
	#Server setting files>
	include("lib/config.inc.php");
	#settins for javascript and style sheets
	session_destroy();
	session_unset();
?>
<div align="center">
  <p><img src="<?=SITE_PATH_ADM?>images/logo.png" width="320" height="134" /></p>
  <p><span><font face="Arial, Helvetica, sans-serif"><strong><font size="2">You are Logging out.....</font></strong><font size="2"><meta http-equiv="refresh" content="3;URL=<?=SITE_PATH_ADM?>login/" />

          <br>
          <a href="<?=SITE_PATH_ADM?>login/" style="text-decoration:none; color:#333;">The page will refresh in 5 seconds......if you want instantly click here...</a></font></font></span></p>
</div>