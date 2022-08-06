<?php

@$co=new mysqli('localhost','root','','account-nedal');
if ($co->connect_error) {die('Database error 1');} 
$co->set_charset("utf8mb4");
$i=1;
if ($file = fopen("file.txt", "r")) {
    while(!feof($file)) {
        $line = fgets($file);
$line= explode(',', $line);
$co->query('update customers set balance='.$line[1].' where id='.$line[0]);
echo $i++.'<br>';
    }
    fclose($file);
}