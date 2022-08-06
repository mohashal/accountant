<?php
//gender: 0=male , 1=female
class login {
/*----------------فنكشن فورم  تسجيل الدخول  ----------------
<div class='log_line2' style='margin:8px 2%;font-size:20px;'><input type='checkbox' name='remember'> ".langu['remember_me']."</div>*/
function login_form(){
echo "
<div class='log_form'>
<form action='login.php' method='post'><input type='hidden' name='login'>
<div class='log_line'><div class='utitle'>R</div><div class='uinput'><input type='text' autocomplete='off' name='username' placeholder='".langu['username']."' value=''></div></div>
<div class='log_line'><div class='utitle'>%</div><div class='uinput'><input type='password' autocomplete='off' name='password' placeholder='".langu['password']."' value=''></div></div>
<div class='login_submit'><input type='submit' class='submit' value='".langu['login']."'></div>
</form>

</div>";
}

/*----------------فنكشن تسجيل الدخول  ----------------*/
function loginm($user,$pass,$co){
$user=$co->real_escape_string($user);
$pass=md5(md5($pass));
$re=null;
$q=$co->query("select * from users where name='$user'");
$row=$q->fetch_assoc();
if($pass==$row['password']){
if(isset($_POST['remember'])){$re=1;}
$this->save_login_session($row,$re);
}
else {$this->msg(langu['login_error'],0);$this->login_form();}
}
/*-----------------فنكشن تسجيل الجلسة من معلومات قاعدة البيانات------------------*/
function save_login_session($row,$remember=null,$home=null){
$_SESSION['id']=$row['id']; 
$_SESSION['username']=$row['name'];
$_SESSION['permission']=$row['permission'];

if($remember!=null){$hash=md5($row['name'].$row['password'].'ta').'.'.$row['id'];
ob_start();setcookie('re',$hash,time()+2592000,null,'.'.langu['domainn'],null,true);ob_end_flush();}

$this->msg(langu['welcome'].$_SESSION['username'].','.langu['login_success'], 2);
}
/*----------------فنكشن تسجيل الخروج  ----------------*/
function logout(){
session_destroy();ob_start();setcookie('re','hhh',time()-2592000,null,'.'.langu['domainn'],null,true);ob_end_flush();
$this->msg('<div id="co">تم تسجيل الخروج بنجاح</div>',1);
}
/*------------------- msg -------------------------------*/
function msg($text,$re){
if($re==0){echo "<div class='login_msg'>";}
elseif($re==1) {echo "<script>setTimeout(\"window.top.location.reload()\",1000);</script>
<div class='login_msg'>";}
else{echo "<script>setTimeout(\"window.top.location.href='index.php'\",1000);</script>
<div class='login_msg'>";}
echo"<br><div class='text_msg'>".$text."</div></div>";
}
}?>