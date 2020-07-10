<?php

session_start();

$con = mysqli_connect('localhost', 'root', '' );
mysqli_select_db($con, 'userregistration');

$name = $_POST['username'];
$pass = $_POST['password'];
$s = "select * from usertable where name = '$name' && password = '$pass'";
$ss = "select profilna from usertable where name = '$name' && password = '$pass'";
$sss = "select type from usertable where name = '$name' && password = '$pass'";

$result = mysqli_query($con, $s);
$num = mysqli_num_rows($result);

$res = mysqli_query($con, $ss);
$prof = mysqli_fetch_row($res);

$res1 = mysqli_query($con, $sss);
$type = mysqli_fetch_row($res1);

if($num == 1){
    $_SESSION['username'] = $name;
    $_SESSION['profilna'] = $prof[0];
    $_SESSION['tip'] = $type[0];    
    if(!file_exists("C:/xampp/htdocs/ITEH/ITEH/".$name)){
        mkdir("C:/xampp/htdocs/ITEH/ITEH/".$name);
    }
    if($prof[0]==0){
        $file = 'C:/xampp/htdocs/ITEH/ITEH/img_upload/default.jpg';
        $newfile = 'C:/xampp/htdocs/ITEH/ITEH/'.$name.'/profile_pic_0.jpg';

        if (!copy($file, $newfile)) {
            echo "failed to copy";
        }
    }
    header('location:home.php');
} else {
    header('location:login.php?msg=failed');
}
?>