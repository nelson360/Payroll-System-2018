<?php // rnfunctions.php
error_reporting(E_ALL ^ E_DEPRECATED);
$dbhost = 'localhost'; // Unlikely to require changing
$dbname = 'kencity '; // Modify these...
$dbuser = 'root'; // ...variables according
$dbpass = ''; // ...to your installation
m ysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());
function sessionStart()
{
session_start();
}
function createTable($name, $query)
{
if (tableExists($name))
{
echo "Table '$name' already exists<br />";
}
else
{
queryMysql("CREATE TABLE $name($query)");
echo "Table '$name' created<br />";
}
}
function tableExists($name)
{
$result = queryMysql("SHOW TABLES LIKE '$name'");
return mysql_num_rows($result);
}
function queryMysql($query)
{
$result = mysql_query($query) or die(mysql_error());
return $result;
}
function destroySession()
{
$_SESSION=array();
if (session_id() != "" || isset($_COOKIE[session_name()]))
setcookie(session_name(), '', time()-2592000, '/');
session_destroy();
}
function sanitizeString($var)
{
$var = strip_tags($var);
$var = htmlentities($var);
$var = stripslashes($var);
return mysql_real_escape_string($var);
}


function processQuery($query)
{
    
    $result=queryMysql($query);
    return $result;
    
}

function longdate($timestamp)
{
return date("l F jS Y", $timestamp);
}
function getTaxableIncome($staffid,$nssf,$period){
	$r=mysql_fetch_array(mysql_query("SELECT salary,totalbenefits FROM payroll_tbl where staffid='$staffid' and payrollrun='$period'"));
	$bens=$r['totalbenefits'];
	$salary=$r['salary'];
	$taxableincome=($bens+$salary)-$nssf;
	return $taxableincome;

}
?>
