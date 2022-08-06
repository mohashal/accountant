function monthly_yearly(){
var year_check=document.getElementById("is_yearly").checked;
var month_check=document.getElementById("is_monthly").checked;

if(year_check){

$('#monthly').hide();
$('#yearly').show();
yearly();
}

if(month_check){

$('#yearly').hide();
$('#monthly').show();
monthly();
}
}

/*monthly_show*/
function monthly(){
var month=document.getElementById("select_monthmonthly").value;
var year=document.getElementById("select_yearmonthly").value;
if(month!='' && year!=''){
$.get("ajax_reports.php?profits=monthly&month="+month+"&year="+year, function(data){
$('.pr_td').remove();
$('#profits').append(data);
});
}

}

/*yearly_show*/
function yearly(){
var year=document.getElementById("select_yearyearly").value;
if(year!=''){
$.get("ajax_reports.php?profits=yearly&year="+year, function(data){
$('.pr_td').remove();
$('#profits').append(data);
});
}
}

function debt_merchant(){
var merchant=document.getElementById("debt_marchant").checked;
var us=document.getElementById("debt_us").checked;

if(merchant){
$.get("ajax_reports.php?debts=merchant", function(data){
document.getElementById("ap-de").innerHTML='';
$('#ap-de').append(data);
});
}

if(us){
$.get("ajax_reports.php?debts=merchant-us", function(data){
document.getElementById("ap-de").innerHTML='';
$('#ap-de').append(data);
});
}
}

function debt_customer(){
var customer=document.getElementById("debt_marchant").checked;
var us=document.getElementById("debt_us").checked;

if(customer){
$.get("ajax_reports.php?debts=customer", function(data){
document.getElementById("ap-de").innerHTML='';
$('#ap-de').append(data);
});
}

if(us){
$.get("ajax_reports.php?debts=customer-us", function(data){
document.getElementById("ap-de").innerHTML='';
$('#ap-de').append(data);
});
}
}

function select_year_partner(){
var year=document.getElementById("select_year").value;
$.get("ajax_reports.php?partners=all-year&year="+year, function(data){
$(".del").remove();
$('#partners').append(data);
});
}

function select_year_ret(){
var year=document.getElementById("select_year").value;
$.get("ajax_reports.php?salesmen=ret_check&year="+year, function(data){
$('#table_ret').append(data);
});
}

function select_year_zak(){
var year=document.getElementById("select_year").value;
$.get("ajax_reports.php?partners=zakah&year="+year, function(data){
$('#table_ret').append(data);
});
}

function select_year_emp(){
var year=document.getElementById("select_year").value;
$.get("ajax_reports.php?partners=emp_expense&year="+year, function(data){
$('#table_ret').append(data);
});
}


function select_month_year_salesmen(){
var year=document.getElementById("select_year2").value;
var month=document.getElementById("select_month2").value;
if(year!=0 && month!=0){
$.get("ajax_reports.php?salesmen=all-month&month="+month+"&year="+year, function(data){
$('.hide_sales').remove();
$('#saless').append(data);
});
}
}

function select_year_bills(){
var year=document.getElementById("select_year2").value;
var bill=document.getElementById("select_bill").value;
if(year!=0 && bill!=0){
$.get("ajax_reports.php?salesmen=all-bill-year&bill="+bill+"&year="+year, function(data){
$('.hide_bill').remove();
$('#billss').append(data);
});
}
}

function get_daily_report(){
var date=document.getElementById("daterep").value;

$.get("ajax_reports.php?profits=daily&daterep="+date, function(data){
$('.daily_rep').html(data);
});

}