<?php

include "inc.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
echo "POST";
}
elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
auth("get");
}
elseif ($_SERVER['REQUEST_METHOD'] == "PUT") {
$content="";
$s = fopen("php://input", "r");
    while($kb = fread($s, 1024))
      { $content.=$kb; }
fclose($s);
Header("HTTP/1.1 201 Created");
$data=array(explode("$",$content));
debug($data);
auth("put",$content);
}