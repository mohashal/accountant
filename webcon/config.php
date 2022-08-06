<?php
include_once 'lang.php';
class config {
protected $host='localhost';
protected $db_name='account-test';/*last2*/
protected $db_user='root';
protected $db_pass='';

function connect(){
@$co=new mysqli($this->host,$this->db_user,$this->db_pass, $this->db_name);
if ($co->connect_error) {die('Database error 1');} 
$co->set_charset("utf8mb4");
return $co;
/*mysql_query("set names 'utf8';");
$conn->set_charset("utf8");
    public function __destruct()
    {
        mysql_close($this->connection);
    } */
}

function get_auto_increment_value($mysqli,$table_name){
$q=$mysqli->query("SELECT AUTO_INCREMENT as ai FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$this->db_name."' AND TABLE_NAME = '".$table_name."'");
$q=$q->fetch_assoc();
return $q['ai'];
}




/*-------------------- فنكشن تعدد الصفحات-----------------------*/
/*$lpp=limit per page ; $pn=page numper ; $rn=rows number ;$ident=get post variable
return array=> 1)link='div contains navigation links' 2)query='same query with limit in last' 3)rn='row number'*/
function pages($lpp,$pn,$query,$ident){
$sql=$this->connect();
$q=$sql->query($query);
$rn=$q->num_rows;
$last=ceil($rn/$lpp);

if($last<1){$last=1;}

if($pn<1){$pn=1;}
elseif($pn>$last){$pn=$last;}

$query=$query.' LIMIT '.($pn-1)*$lpp.','.$lpp;

$link="<div class='paginat'><div class='paginat_container'>";
$link.="<div class='p_frompage'>".langu['page'].'&nbsp'.$pn.'&nbsp'.langu['from'].'&nbsp'.$last.'</div>';
if($last>7){

if($pn==1){$link.="<div class='p_spage'><</div>";}
else {$link.="<a class='p_pages' href='".$ident."1.html'>".langu['first']."</a>
<a class='p_pages' href='".$ident.($pn-1).".html'><</a>";}

for($i=$pn-2;$i<=$pn+2;$i++){
if($i>$last){continue;}
if($i<1){continue;}
if($i==$pn){$link.="<div class='p_spage'>".$pn.'</div>';}
else {$link.="<a class='p_pages' href='".$ident.$i.".html'>".$i.'</a>';}

}

if($last==$pn){$link.="<div class='p_spage'>></div>";}
else {$link.="<a class='p_pages' href='".$ident.($pn+1).".html'>></a>
<a class='p_pages' href='".$ident.$last.".html'>".langu['last']."</a>";}

}

else {

if($pn==1){$link.="<div class='p_spage'><</div>";}
else {$link.="<a class='p_pages' href='".$ident.($pn-1).".html'><</a>";}

for($i=1;$i<=$last;$i++){
if($i==$pn){$link.="<div class='p_spage'>".$pn.'</div>';}
else {$link.="<a class='p_pages' href='".$ident.$i.".html'>".$i.'</a>';}
}

if($last==$pn){$link.="<div class='p_spage'>></div>";}
else {$link.="<a class='p_pages' href='".$ident.($pn+1).".html'>></a>";}

}

$link.='</div></div>';

$ret=array();
$ret['link']=$link;$ret['query']=$query;$ret['rn']=$rn;
return $ret;}

/*-------------------------------فنكشن التقيم--------------------------------*/
/*id=store id;*/
function rating($rate_point,$rater_number,$id,$upadte=null,$voters=null){
$id=intval($id);
$rate_active=0;
$u="_no_update'";
if($rate_point==0){$rate=0;}
else{$rate=round($rate_point/$rater_number);}

$m="<div class='rating' id='rate-".$id."' data-rate='$rate'>";

for($i=0;$i<5;$i++){
if($upadte==1){$u="' onmouseover='hmouseover($i,$id)' onmouseout='hmouseout($id)' onclick='update_rate(".($i+1).",".$id.",\"".langu['rate']."\")'";}
/*onmouseover='hmouseover($i)' onmouseout='hmouseout()' onclick='update_rate(\"".($i+1)."\",\"".$id."\",\"".langu['rate']."\")'*/

if($rate_active<$rate && $rate!=0){$m.="<div id='rate-".$id."-".$i."' class='active rate_star".$u."></div>";$rate_active++;}
else{$m.="<div id='rate-".$id."-".$i."' class='rate_star".$u."></div>";}
}
$m.='</div>';
if($voters==1){$m.="<div id='rater'>($rater_number ".langu['voters'].")</div>";}
return $m;
}


}
?>