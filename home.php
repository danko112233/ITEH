<?php

session_start();
if(!isset($_SESSION['username'])){
    header('location:login.php');
    
}
$user = $_SESSION['username'];

$con = mysqli_connect('localhost', 'root', '' );
mysqli_select_db($con, 'userregistration');

$provera1 = "select user1_id, status from friends where user2_id ='$user' and status = 0";
$res1 = mysqli_query($con, $provera1);
$friend2 = mysqli_fetch_row($res1);
$_SESSION['kogaDodajemo'] = $friend2[0];

$provera2 = "select user2_id, status from friends where user1_id ='$user' and status = 2";
$res2 = mysqli_query($con, $provera2);
$noFriend2 = mysqli_fetch_row($res2);

$provera3 = "select user2_id from friends where user1_id ='$user' and status = 1";
$res3 = mysqli_query($con, $provera3);
$prijatelji = mysqli_fetch_all($res3, MYSQLI_ASSOC);
$provera4 = "select user1_id from friends where user2_id ='$user' and status = 1";
$res4 = mysqli_query($con, $provera4);
$prijatelji1 = mysqli_fetch_all($res4, MYSQLI_ASSOC);


#var_dump($prijatelji1);
#print_r($prijatelji1);


if($friend2[1] == "0"){
?>
    <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <?php echo $friend2[0]; ?> wants to be your friend
            <form id = "fr" method="get" action="accept.php">
                <button type="submit" class="btn-success">accept</button>
            </form>
            <form id = "notfr" method="get" action="deny.php">
                <button type="submit" class="btn-danger">deny</button>
            </form>
    </div> 
<?php
}

if($noFriend2[1] == "2"){
    ?>
    <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <?php echo $noFriend2[0]; ?> doesn't want you as a friend :(      
            <?php 
            $ok = "update friends set status=3 where user1_id ='$user' and user2_id = '$noFriend2[0]'";
            mysqli_query($con, $ok);            
            ?>        
    </div> 
    <?php
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login and Signup</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styleHOME.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Home Page</title>
    <script src="ajax.js"></script> 
    
</head>
<body>
    <?php 
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "localhost/ITEH/ITEH/usertable.json");

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($curl);
        $output = json_decode($output);
 
        $o = '';
        for($i = 0; $i < sizeof($output); $i++){         
            $o .= "<li id = 'imena'>".$output[$i]->{'name'}."</li> ";                            
        }
        curl_close($curl);
    ?>  
    <div id = "prvi-red" class= "row">
        <div id = "prva" class= "col-sm">
            <form>

                <input id="find" type="text" size="30" onkeyup="showResult(this.value)"  onmouseover="lista()" onmouseout="nemaliste()">
                <div id="livesearch"> </div>
                
            </form>                
                <ul id="lista">  </ul>
                <script>
                    function lista(){
                        document.getElementById("lista").innerHTML=" <?php echo $o; ?> ";
                        }
                        function nemaliste(){
                        document.getElementById("lista").innerHTML="";
                        }
                </script>
        </div>

        <div id = "druga" class= "col-sm">            
            <a href="finduser.php?profile=<?php echo ''.$_SESSION['username'] ?>">
            visit your profile <?php echo $_SESSION['username'] ?> </a>

        </div>
        
        <div id = "treca" class="col-sm">
                <form method="get" action="logout.php">
                    <button id="log" type="submit" class="btn-danger">LOG OUT</button>
                </form>
        </div>
    </div>

    <div id = "drugi-red" class= "row"> 
        <div id = "prvi" class= "col-sm">


            <img id="slika1" name="sveslike" src="" > 
            <img id="slika2" name="sveslike" src="" > 
            <img id="slika3" name="sveslike" src="" > 
            <img id="slika4" name="sveslike" src="" > 
            <img id="slika5" name="sveslike" src="" > 
            <img id="slika6" name="sveslike" src="" > 
            <img id="slika7" name="sveslike" src="" > 
            <img id="slika8" name="sveslike" src="" > 
            <img id="slika9" name="sveslike" src="" > 
            <img id="slika10" name="sveslike" src="" > 
            <script>
                var data = null;

                var xhr = new XMLHttpRequest();
                xhr.withCredentials = false;

                xhr.addEventListener("readystatechange", function () {
                    if (this.readyState === this.DONE) {
                        console.log(this.responseText);
                        var obj = JSON.parse(this.responseText);
                        for(i=0; i<10; i++){                 
                            var j = i+1;         
                            document.getElementById('slika'+j).src = obj[i].download_url;
                        }
                    }
                });
                var stranica = Math.floor((100*Math.random()) +1);
                xhr.open("GET", "https://picsum.photos/v2/list?page="+stranica+"&limit=10");
                xhr.send(data);
    
            </script>
        </div>

        <div id="drugi" class= "col-sm">
            <ul id="listaPr" class="w3-ul">
                <?php
                    foreach($prijatelji1 as $value){
                        echo '<li class="w3-hover-blue"><a href="finduser.php?profile='.$value['user1_id'].'">'.$value['user1_id']."</a></li>";
                    }
                    
                    foreach($prijatelji as $value){
                        echo '<li class="w3-hover-green"><a href="finduser.php?profile='.$value['user2_id'].'">'.$value['user2_id']."</a></li>";
                    }    
                ?>
            </ul>   
        </div>
    </div>
</body>
</html>