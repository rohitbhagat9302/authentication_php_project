<?php 
require('connection.php');
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>login & Register</title>
</head>
<body>
    <header>
        <h2>Website</h2>
        <nav>
            <a href="#">Home</a>
            <a href="#">Blog</a>
            <a href="#">Contact</a>
            <a href="#">Service</a>
            <a href="#">About</a>
        </nav>

        <?php 
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']=true){
       echo" <div class='user'>
       $_SESSION[username] - <a  style= 'color: aqua;' href='logout.php'>LOGOUT</a>

        </div>";
    }
    else{
        echo"
        <div class = 'sign-in-up'>
        <button type='button' onclick=\"popup('login-popup')\">LOGIN</button>
        <button type='button' onclick=\"popup('register-popup')\">REGISTER</button>
    </div>";
    }
    ?>
    </header>


    <div class="popup-container" id="login-popup">
        <div class="pop">
            <form action="login_register.php" method="post">
                <h2>
                    <span>USER LOGIN</span>
                    <button type="reset" onclick="popup('login-popup')">X</button>
                </h2>
                <input type="text" placeholder="E-mail or username" name="email_username">
                <input type="password" placeholder="password" name="password">
                <button type="submit" class="login-btn" name="login">LOGIN</button>
            </form>
        </div>
    </div>
    
    <div class="popup-container" id="register-popup">
        <div class="register pop">
            <form action="login_register.php" method="post">
                <h2>
                    <span>USER REGISTER</span>
                    <button type="reset" onclick="popup('register-popup')">X</button>
                </h2>
                <input type="text" placeholder="Full Name" name="fullname">
                <input type="text" placeholder="username" name="username">
                <input type="email" placeholder="E-mail" name="email">
                <input type="password" placeholder="password" name="password">
                <button type="submit" class="register-btn" name="register">REGISTER</button>
            </form>
        </div>
    </div>
    
    <?php 
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']=true){
        echo "<h2 style= 'text-align: center; margin-top: 200px;' > WELCOME TO THIS WEBSITE - $_SESSION[username]</h2>";
    }
    ?>


    <script>
        function popup(popup_name)
        {
            get_popup=document.getElementById(popup_name);
            if(get_popup.style.display=="flex")
            {
                get_popup.style.display="none";
            }
            else {
                get_popup.style.display="flex";
            }

        }
    </script>
    
</body>
</html>