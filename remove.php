<?php
    session_start();
    $brisi = $_SESSION['profilNaKomSmo'];
    $con = mysqli_connect('localhost', 'root', '' );
    mysqli_select_db($con, 'userregistration');
    $s = "delete from usertable where name = '$brisi'";
    mysqli_query($con, $s);

    header('location:home.php');
?>
