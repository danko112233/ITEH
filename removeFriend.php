<?php
    session_start();

    $user1 = $_SESSION['username'];
    $user2 = $_SESSION['profilNaKomSmo'];

    $con = mysqli_connect('localhost', 'root', '' );
    mysqli_select_db($con, 'userregistration');

    $brisanje = "delete from friends where user1_id ='$user1' and user2_id ='$user2'";
    $res = mysqli_query($con, $brisanje);

    $brisanje1 = "delete from friends where user2_id ='$user1' and user1_id ='$user2'";
    $res1 = mysqli_query($con, $brisanje1);
    header('location:home.php');
?>