<?php
/***************************************************** */
function dbconnect(){
include('conf/config.php');

$link = mysql_connect($config['MYSQL']['HOST'], $config['MYSQL']['USER'], $config['MYSQL']['PWD'])
        or die("Could not connect : " . mysql_error());
mysql_select_db($config['MYSQL']['DBNAME']) or die("Could not select database");
}
/***************************************************** */

/***************************************************** */
function db_close_connect($result){
mysql_free_result($result);
}
/***************************************************** */

function auth($fname,$param) {
$query = explode("/", $_SERVER['REQUEST_URI']);
$key=$query[1];
$comment=$query[2];
$GLOBALS['keys'] = $key;
$GLOBALS['comment'] = $comment;

dbconnect();
$sqlquery= "SELECT `userid`,INET_NTOA(`userip`),`enable`,`key` FROM `users` WHERE `key` = '".mysql_real_escape_string($key)."';";
$result = mysql_query($sqlquery) or die("Query failed : " . mysql_error());
$row = mysql_fetch_array($result);
#var_dump($row);

if ($row[3] != $key) { echo "wrong key";}
elseif ($row[1] != $_SERVER['REMOTE_ADDR']) {echo "valid key, wrong ip - ". $_SERVER['REMOTE_ADDR'];}
else { 

#all ok. processing...
call_user_func($fname,$param);

}
db_close_connect();
}

function get(){

dbconnect();
$sqlquery= "SELECT INET_NTOA(`ip`) FROM list WHERE `date` BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW();";
$result = mysql_query($sqlquery) or die("Query failed : " . mysql_error());
#$row = mysql_fetch_array($result);
#var_dump ($row);

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
echo $row[0]."\r\n";
}

db_close_connect();
}



function put($content)
{
$c=explode("$",$content, -1);

saveput($c);

dbconnect();

foreach ($c as $ip) {
$sqlquery= "SELECT `count`,`last_commit` FROM `list` WHERE `ip`=INET_ATON('".mysql_real_escape_string($ip)."');";
$result = mysql_query($sqlquery) or die("Query failed : " . mysql_error());
$t = mysql_fetch_array($result);

if (is_array($t)) 
{
updateip($ip, $t['count'], $t['last_commit']);
}else {
addnewip($ip);
}


}
db_close_connect();
echo "OK\r\n";
}

function updateip($ip, $count, $last_commit){
global $last_trans_log;
$sqlquery = "UPDATE `list` SET `count`=count+1, `added_id`=concat(added_id, ',".$last_trans_log."'),`date` = CURRENT_TIMESTAMP WHERE `ip` = INET_ATON('".$ip."');";
$result = mysql_query($sqlquery) or die("Query failed : " . mysql_error());

}

function addnewip($ip){
global $last_trans_log;
dbconnect();
$sqlquery= "INSERT INTO `list` (`ip`,`added_id`,`last_commit`,`count`,`date`) VALUES (INET_ATON('".mysql_real_escape_string($ip)."'),'".$last_trans_log."', '".$last_trans_log."', 1, CURRENT_TIMESTAMP);";
$result = mysql_query($sqlquery) or die("Query failed : " . mysql_error());

}


function saveput($ips) {
dbconnect();
global $keys;
global $comment;
$z=implode("\r\n",$ips);
$sqlquery= "INSERT INTO `log` (`id`, `key`, `ip_array`, `date`, `comment`) VALUES (NULL, '".mysql_real_escape_string($keys)."', '".mysql_real_escape_string($z)."', CURRENT_TIMESTAMP, '".mysql_real_escape_string(base64_decode($comment))."');";
$result = mysql_query($sqlquery) or die("Query failed : " . mysql_error());
$lastid = mysql_fetch_row(mysql_query("SELECT LAST_INSERT_ID()"));
$GLOBALS['last_trans_log'] = $lastid[0];
}
