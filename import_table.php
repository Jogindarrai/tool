<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', -1);
error_reporting(E_ALL);

$link = mysqli_connect('localhost', 'gvsdco_sachin', 'Maurya@123') or die(mysqli_connect_error());
mysqli_select_db($link, 'gvsdco_erp');

$sql = file_get_contents(__DIR__ . '/tmb_citylist.sql');
$sql = explode(';', $sql);
$count = count($sql);
echo "$count<br>";
$i = 16;
$j=$i;
$query = "";
while (!preg_match('/' . preg_quote(')', '/') . '([\s]*)$/', $sql[$i])) {
    $query .= ";$sql[$i]";
    $i++;
}
$query .= ";$sql[$i]";
$query= ltrim($query,';');
mysqli_query($link, $query) or die("$j to $i => $query");
echo "done ".($i+1)." => $query";