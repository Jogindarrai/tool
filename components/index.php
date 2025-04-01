<?php 
include("../lib/config.inc.php");

if($qtag=="pgn"):
if($_GET["totpaging"]!='All'){
 $_SESSION["totpaging"] = $_GET["totpaging"];
} else {
 $_SESSION["totpaging"] = 100000000;
}
$_SESSION["compp"] = $compp;
endif;


$RW->redir($_SERVER['HTTP_REFERER'], true);
?>