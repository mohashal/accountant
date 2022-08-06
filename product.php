<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>البضائع</title>
<style>
body{width:99%;height:auto;direction:rtl;}
.t1{width:80%;margin:15px auto;text-align:center;border-collapse: collapse;border:1px solid black;}
.t1 td{border:1px solid black;padding:3px;}
.t1 tr{border:1px solid black;}
.t1 th{border:1px solid black;padding:3px;}
p{text-align:center;margin:3px auto;font-size:20px;font-weight:bold;}
.d{width:100%;}
</style>
</head>
<body>

<?php
@$co=new mysqli('localhost','root','','account-last2');
if ($co->connect_error) {die('Database error 1');} 
$co->set_charset("utf8mb4");
$i=1;
$q='';
if(isset($_GET['s'])){
    switch ($_GET['s']){
        case'n':$q='CAST(quantity*0.4 AS int) as q';$nam='كمية البضاعة ل نضال';break;
        case'r':$q='CAST(quantity*0.6 AS int) as q';$nam='كمية البضاعة ل راضي';break;
        default:$q='quantity as q';$nam='كمية البضاعة كاملة';break;
    }
}

$m=$co->query('SELECT id,name FROM `categories`');
while($row=$m->fetch_assoc()){
echo '<div class="d">

<table class="t1"><thead><tr><th colspan="3"><p>'.$nam.' ---  التصنيف : '.$row['name'].'</p></th></tr>
<tr><th>رقم البضاعة</th><th>الاسم</th><th>الكمية</th></tr></thead>';
$m2=$co->query('select id2,name,'.$q.' from products where category_id='.$row['id']);
while($row2=$m2->fetch_assoc()){
echo '<tr><td>'.$row2['id2'].'</td><td>'.$row2['name'].'</td><td>'.$row2['q'].'</td></tr>';
}
echo'</table></div>';
}


?>

</body>
</html>