<?php
session_start();
$prof = $_GET['profile'];
$_SESSION['profilNaKomSmo'] = $prof;
$user = $_SESSION['username'];

$con = mysqli_connect('localhost', 'root', '' );
mysqli_select_db($con, 'userregistration');
$s = "select profilna from usertable where name = '$prof'";
$res = mysqli_query($con, $s);
$brojProfilne = mysqli_fetch_row($res);

$provera3 = "select status from friends where user1_id ='$user' and user2_id = '$prof' and status = 1";
$res3 = mysqli_query($con, $provera3);
$prijatelji = mysqli_fetch_row($res3);
$provera4 = "select status from friends where user2_id ='$user' and user1_id = '$prof' and status = 1";
$res4 = mysqli_query($con, $provera4);
$prijatelji1 = mysqli_fetch_row($res4);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    
    
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="friend.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <title>Profile</title>
</head>
<body>
    <div id = "prvi-red" class= "row">
        <div id = "prva" class= "col-sm">        
            <img src="<?php echo $prof ?>/profile_pic_<?php echo $brojProfilne[0]; ?>.jpg" height="300" width="300">  
        </div>
        <h1><?php echo $prof; ?> </h1>
        <div id = "druga" class= "col-sm">            
            
                    
            <?php
                if($_SESSION['tip'] == 1){
            ?>
                <form method="get" action="remove.php">
                    <button id="rem" type="submit" class="btn-danger">REMOVE PROFILE</button>        
                </form>
            <?php
                }

                if($_SESSION['username']!=$prof){
                    
            ?>

            <?php
                }
                else {
                    
            ?>

            <form id="pic" action="change_profile_pic.php" method="post" enctype="multipart/form-data">
                Select image to upload:
                <input id="inp1" type="file" name="fileToUpload" id="fileToUpload">
                <input id="inp2" type="submit" value="Upload Image" name="submit">
            </form>


            <?php   
                
                }
                    
            ?>
        </div>
        <div id = "treca" class="col-sm">
            <form method="get" action="logout.php">
                <button id="log" type="submit" class="btn-danger">LOG OUT</button>
            </form>
            
            <div class= "col-sm">
                <form method="get" action="home.php">
                    <button id="hom" type="submit" class="btn-success">home</a>
                </form>
            </div>
        </div>
    </div>

    <div id = "drugi-red" class= "row">

    <?php if($prof != $_SESSION['username'] ){     ?> 
        <div class= "col-sm">
            <?php if($prijatelji[0]!=1 && $prijatelji1[0]!=1){?>
                <form method="get" action="addFriend.php">
                    <button type="submit" class="btn-success">ADD FRIEND</button>
                </form>
            <?php } 
                else{    ?> 
                <form method="get" action="removeFriend.php">
                    <button type="submit" class="btn-danger">REMOVE FRIEND</button>
                </form>            
                <?php }    ?> 
        </div>
        
   
        <?php if($prijatelji[0]==1 || $prijatelji1[0]==1){?>
            <div id="chat" class= "col-sm">
                <div class="col-sm-3 col-sm-offset-4 frame">
                    <ul id='history'></ul>
                    <div>
                        <div class="msj-rta macro">                        
                            <div class="text text-r" style="background:whitesmoke !important">
                                <form action="" method="POST">
                                    <textarea id="poruka" class="txtarea"></textarea>
                                </form>
                            </div> 

                        </div>
            
                    </div>
                </div>       
            </div>
        <?php }    ?>  
    <?php }    ?>  
    </div> 

    <script>
        $(document).ready(function(){
            loadChat();
        });

        $('#poruka').keyup(function(e){
            var message = $(this).val();
            if(e.which == 13){
                $.post('ajax1.php?action=SendMessage&message='+message, function(response){  
                    loadChat();
                    $('#poruka').val(''); 
                    $('#history').animate({scrollTop: $('#history').prop("scrollHeight")}, 500);                
                });
            }
        });

        function loadChat(){
            $.post('ajax1.php?action=getChat', function(response){                
                $('#history').html(response);
                $('#history').animate({scrollTop: $('#history').prop("scrollHeight")}, 500);
            });
        }

        setInterval(function(){
            loadChat();
        }, 1000);
    </script>
</body>
</html>