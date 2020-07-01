<?php
    session_start();

    $user1 = $_SESSION['username'];
    $user2 = $_SESSION['profilNaKomSmo'];

    $con = mysqli_connect('localhost', 'root', '' );
    mysqli_select_db($con, 'userregistration');

    $provera = "select user2_id, status from friends where user1_id ='$user1' and user2_id ='$user2'";
    $res = mysqli_query($con, $provera);
    $user2istat = mysqli_fetch_row($res);

    $provera1 = "select user1_id, status from friends where user2_id ='$user1' and user1_id ='$user2'";
    $res1 = mysqli_query($con, $provera1);
    $user1istat = mysqli_fetch_row($res1);

    if($user2istat[0] == $user2 && $user2istat[1] == 0){
        echo "Vec ste poslali friend request  ! ! ! ";
    }
    elseif($user1istat[0] == $user2 && $user1istat[1] == 0){
        echo "Vec vam je poslat friend request od ove osobe, sada ste prijatelji";
        $dodaj = "update friends set status=1 where user2_id ='$user1' and user1_id = '$user2'";

    }
    elseif(($user2istat[0] == $user2 && $user2istat[1] == 1) || ($user1istat[0] == $user2 && $user1istat[1] == 1)){
        echo "allready friends :)";
    }
    else {
    $s = "insert into friends (user1_id, user2_id) values ('$user1', '$user2')";   
    mysqli_query($con, $s);
    echo "poslali ste friend request :)";
    }

?>

<h1> <a href="home.php"> HOME </a> </h1>