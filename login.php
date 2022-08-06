<?php session_start();
require_once 'webcon/config.php';
include_once 'webcon/he_fo.php';
include_once 'webcon/login.php';

$co=new config();
$lo=new login();
$hf=new he_fo();

$conn=$co->connect();


echo "<!DOCTYPE html>
<html dir='rtl' lang='ar'>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>".langu['login']." - ".langu['site_name']."</title>
<link href='csss/reset.css' rel='stylesheet' type='text/css'/>
<link href='csss/login.css' rel='stylesheet' type='text/css'/>
<style>
html,body,ul,a,li,div{margin:0;padding:0;font-family:'Times New Roman','Traditional Arabic',Times,serif;
border:0;outline:none;vertical-align:top;text-decoration:none;}

body{background-color:#FFF;width:100%;height:100%;}/*background-image: url('../images/main/body-bg.png');*/
.wrap{width:98%;margin:0 auto;}
</style>
<link rel='icon' href='images/main/logo2.png' type='image/png'/>
<link rel='apple-touch-icon-precomposed' href='images/main/logo2.png'/>
</head>
<body><div class='wrap'>";
if(isset($_POST['username'])){
$lo->loginm($_POST['username'],$_POST['password'], $conn);
}
elseif(isset($_GET['logout'])){$lo->logout();}
else{$lo->login_form();}
echo"</div></body></html>";


?>