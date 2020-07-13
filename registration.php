<?php

session_start();
header('location:login.php');

$con = mysqli_connect('localhost', 'root', '' );
mysqli_select_db($con, 'userregistration');

$name = $_POST['username'];
$pass = $_POST['password'];
$s = "select * from usertable where name = '$name'";
$result = mysqli_query($con, $s);
$num = mysqli_num_rows($result);

if($num == 1){
    header('location:login.php?msg1=failed');
} 
elseif(strlen($pass) < 8){
    header('location:login.php?msg1=notEnough');
} 
elseif(!preg_match("#[0-9]+#", $pass)){
    header('location:login.php?msg1=noNum');
} 
elseif(!preg_match("#[a-zA-Z]+#", $pass)){
    header('location:login.php?msg1=noLett');
}
elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $pass)){
    header('location:login.php?msg1=noSymb');
}
else{
    $reg = "insert into usertable(name , password) values ('$name', '$pass')";
    mysqli_query($con, $reg);
       
    mkdir("C:/xampp/htdocs/ITEH/ITEH/".$name);
    
    $file = 'C:/xampp/htdocs/ITEH/ITEH/img_upload/default.jpg';
    $newfile = 'C:/xampp/htdocs/ITEH/ITEH/'.$name.'/profile_pic_0.jpg';

    if (!copy($file, $newfile)) {
        echo "failed to copy";
    }

    header('location:login.php?msg1=succ');
}
?>