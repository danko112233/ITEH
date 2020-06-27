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
    <title>Home Page</title>
    <script src="ajax.js"></script> 
</head>
<body>

    <div id = "prvi-red" class= "row">
        <div id = "prva" class= "col-sm">
        <form>
             <input id="find" type="text" size="30" onkeyup="showResult(this.value)">
                <div id="livesearch"></div>
            </form>

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
        <p> Trenutna temperatura u Beogradu: </p>
        <p id = 'trenutna' >  </p>
        <p>  Feels like: </p>
        <p id = 'feels-like'>  </p>
        <p>  Minimalna dnevna: </p>
        <p id = 'minT'>  </p>
        <p>  Maksimalna dnevna: </p>
        <p id = 'maxT'>  </p>
            <script>
                var data = null;

                var xhr = new XMLHttpRequest();
                xhr.withCredentials = false;

                xhr.addEventListener("readystatechange", function () {
                    if (this.readyState === this.DONE) {
                        console.log(this.responseText);

                        var a = this.responseText.split("temp");
                        var kelvin = parseFloat(a[1].substring(2,8));
                        var celzius = Math.round((kelvin - 273.15) * 100) / 100;
                        document.getElementById('trenutna').innerHTML = celzius;

                        var a1 = this.responseText.split("feels_like");
                        var kelvin1 = parseFloat(a1[1].substring(2,8));
                        var celzius1 = Math.round((kelvin1 - 273.15) * 100) / 100;
                        document.getElementById('feels-like').innerHTML = celzius1;

                        var a2 = this.responseText.split("temp_min");
                        var kelvin2 = parseFloat(a2[1].substring(2,8));
                        var celzius2 = Math.round((kelvin2 - 273.15) * 100) / 100;
                        document.getElementById('minT').innerHTML = celzius2;

                        var a3 = this.responseText.split("temp_max");
                        var kelvin3 = parseFloat(a3[1].substring(2,8));
                        var celzius3 = Math.round((kelvin3 - 273.15) * 100) / 100;
                        document.getElementById('maxT').innerHTML = celzius3;

                    }
                });

                xhr.open("GET", "https://community-open-weather-map.p.rapidapi.com/weather?callback=test&id=2172797&units=%2522metric%2522%20&mode=xml%252C%20html&q=Belgrade");
                xhr.setRequestHeader("x-rapidapi-host", "community-open-weather-map.p.rapidapi.com");
                xhr.setRequestHeader("x-rapidapi-key", "8a8b21910cmshd8cb182cc7e24cdp10cdb1jsn7221eb5a917d");
                // za ovaj key treba registracija 
                xhr.send(data);
                
                
            </script>
        </div>
        <div class= "col-sm">
            
        </div>
    </div>  
</body>
</html>