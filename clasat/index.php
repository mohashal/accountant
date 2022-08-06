<?php

class index {

function money_charts($mysqli){

$i2=0;
for($i=date('n');$i>=1;$i--){if($i2==6){break;}$labels2[]=$i;$i2++;}
/*$labels=implode('/'.date('Y').', ',$labels2);
$labels.=" / ".date('Y');*/
$labels=implode(', ',$labels2);

for($i=0;$i<count($labels2);$i++){
$row=$mysqli->query('SELECT sum(cash_value+checks_value) as co FROM revenue where year(add_date)='.date('Y').' and MONTH(add_date)='.$labels2[$i]);
if($row->num_rows>0){
$row=$row->fetch_assoc();
$row3=$mysqli->query('SELECT sum(check_value) as co FROM checks where is_returned=1 and year(returned_date)='.date('Y').' and MONTH(returned_date)='.$labels2[$i]);
if($row3->num_rows>0){$row3=$row3->fetch_assoc();$data[]=$row['co']-$row3['co'];$r=$row['co']-$row3['co'];}
else{$data[]=$row['co'];$r=$row['co'];}
}
else{$data[]=0;$r=0;}
$row2=$mysqli->query('SELECT sum(cash_value+check_value) as co FROM expense where year(date)='.date('Y').' and MONTH(date)='.$labels2[$i]);
if($row2->num_rows>0){$row2=$row2->fetch_assoc();$data2[]=$row2['co'];$e=$row2['co'];}
else{$data2[]=0;$e=0;}
$data3[]=$r-$e;
}


$data=implode(', ',$data);
$data2=implode(', ',$data2);
$data3=implode(', ',$data3);

$rev=langu['revenue']." ".langu['shekel'];
$exp=langu['expenses']." ".langu['shekel'];
$pr=langu['profits']." ".langu['shekel'];
echo "
<div class='charts'>
<div class='charts_main'>
<div class='charts_title'>".langu['revenue']." - ".date('Y')."</div>
    <div class='chart-container'>
        <canvas id='revenue'></canvas>
    </div>
</div>
<div class='charts_main'>
<div class='charts_title'>".langu['expenses']." - ".date('Y')."</div>
    <div class='chart-container'>
        <canvas id='expense'></canvas>
    </div>
</div>
<div class='charts_main'>
<div class='charts_title'>".langu['profits']." - ".date('Y')."</div>
    <div class='chart-container'>
        <canvas id='profit'></canvas>
    </div>
</div>
</div>
";

$js='<script>money_chart("'.$labels.'","'.$data.'","'.$rev.'","revenue","95, 138, 199");
money_chart("'.$labels.'","'.$data2.'","'.$exp.'","expense","255,99,132");
money_chart("'.$labels.'","'.$data3.'","'.$pr.'","profit","13, 189, 35");</script>';

return $js;
}



}