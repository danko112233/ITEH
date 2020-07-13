<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login and Signup</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    
    <div class="container">
        <div class="login-box">
        <div class="row">
        <div class="col-md-6 login-left">
            <h2> LOGIN </h2>
            <form action="validation.php" method="post">

                <div calass="form-group">
                    <label> username: </label>
                    <input type="text" id="username" name="username" class="form-control" reqired> <br> <br> 
                </div>

                <div calass="form-group">
                    <label> password: </label>
                    <input type="password" id="password" name="password" class="form-control" reqired> <br> <br> 
                </div>
                    <button type="submit" class="btn-primary"> Log in </button> <br> <br>
            </form>
    <?php
        if (isset($_GET["msg"]) && $_GET["msg"] == 'failed') {
            echo "Wrong Username or Password, try again";
        }
    ?>        

        </div>
 
        <div class="col-md-6 login-right">
            <h2> SIGNUP </h2>
            <form action="registration.php" method="post">

                <div calass="form-group">
                    <label> username: </label>
                    <input type="text" id="username1" name="username" class="form-control" reqired> <br> <br> 
                </div>

                <div calass="form-group">
                    <label> password: </label>
                    <input type="password" id="password1" name="password" class="form-control" reqired> <br> <br> 
                </div>
                    <button type="submit" class="btn-primary"> Sign up </button> <br> <br>
            </form>
    <?php
        if (isset($_GET["msg1"]) && $_GET["msg1"] == 'failed') {
            echo "Username already taken";
        }
        elseif (isset($_GET["msg1"]) && $_GET["msg1"] == 'notEnough') {
            echo "Password must be at least 8 characters long";
        }
        elseif (isset($_GET["msg1"]) && $_GET["msg1"] == 'noNum') {
            echo "Password must contain at least one num [1-9]";
        }
        elseif (isset($_GET["msg1"]) && $_GET["msg1"] == 'noLett') {
            echo "Password must contain at least one letter";
        }
        elseif (isset($_GET["msg1"]) && $_GET["msg1"] == 'noSymb') {
            echo "Password must contain at least one symbol: \'^£$%&*()}{@#~?><>,|=_+¬-";
        }
        elseif (isset($_GET["msg1"]) && $_GET["msg1"] == 'succ') {
            echo "Registration successful";
        }
        
    ?>  
        </div>
        
        </div>  <!-- zatvaram row -->
        </div> <!-- zatvaram login-box -->
    </div>  <!-- zatvaram container -->
                    
</body>
</html>