<?php

include "./inc/functions.php";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $ip=str_replace('/', "",$_SERVER["REQUEST_URI"]);
    if (preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $ip)) {
    get($ip); }
     else  { printdesign();}
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $_POST["ip"])) {
    get($_POST["ip"]); }
     else  { printdesign();}
}

