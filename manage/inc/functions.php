<?php

function printdesign() {
$html = <<< STOP
<html>
<body>
<form name="search" method="post" action="?">
<table>
<tr><td>IP:</td><td><input type=text name=ip value="enter IP"></input></td><td><input type="submit" value="Search it!"></td></tr>
</table>

</form>
</body>
</html>

STOP;
#<?php
echo $html;
}

function get($ip) {
echo "select ".$ip;
include('./conf/config.php');

$link = mysql_connect($config['MYSQL']['HOST'], $config['MYSQL']['USER'], $config['MYSQL']['PWD'])
        or die("Could not connect : " . mysql_error());
        mysql_select_db($config['MYSQL']['DBNAME']) or die("Could not select database");
$sqlquery= "SELECT * from `log` where `ip_array` like '%".mysql_real_escape_string($ip)."%' order by date desc limit 0,15";
$result = mysql_query($sqlquery) or die("[get($ip)] Query failed : " . mysql_error());

$design= <<< STOP
<table border="2" cellpadding="2">
<tr><td>ID</td><td>key</td><td>date</td><td>comment</td><td>queue</td>
STOP;

while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
$design .= "<tr><td>".$row['id']."</td><td>".base64_decode($row['key'])."</td><td>".$row['date']."</td><td>".$row['comment']."</td><td>".$row['queue']."</td></tr>";
}
echo $design;
}

