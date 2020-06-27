<?php
    session_start();

    $user1 = $_SESSION['username'];
    $user2 = $_SESSION['kogaDodajemo'];

    $con = mysqli_connect('localhost', 'root', '' );
    mysqli_select_db($con, 'userregistration');

    $update = "update friends set status=2 where user2_id ='$user1' and user1_id = '$user2'";

    mysqli_query($con, $update);

?>

<h2> Vi i <?php echo $user2; ?> niste prijatelji :( </h2>
<h1> <a href="home.php"> HOME </a> </h1>