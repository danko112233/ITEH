<?php
    session_start();
    $fr1 = $_SESSION['username'];
    $fr2 = $_SESSION['profilNaKomSmo'];

    $con = mysqli_connect('localhost', 'root', '' );
    mysqli_select_db($con, 'userregistration');
    
    if( isset($_REQUEST['action'])){
        
        switch($_REQUEST['action']){
            case "SendMessage":
                $mess = $_REQUEST['message'];
                $poruka = "insert into chat(fr_1, fr_2, message) values ('$fr1', '$fr2','$mess')";
                mysqli_query($con, $poruka);
            break;

            case "getChat":
                $poruka = "select * from chat where (fr_1 = '$fr1' and fr_2 ='$fr2') OR (fr_1 = '$fr2' and fr_2 ='$fr1') ";
                $query = mysqli_query($con, $poruka);
                $red = mysqli_fetch_all($query);
                $chat = '';
                foreach($red as $r){
                    $chat .= $r[1].' says: '.$r[3].'<hr />';
                }
                echo $chat;
            break;
        }
    }

?>