<?php
require('connection.php');
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function sendMail($email, $v_code)
{
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    require 'PHPMailer/Exception.php';

    $mail = new PHPMailer(true);
   
    try {
       // Server setting
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'rohitbhagat9302@gmail.com'; //SMTP username
        $mail->Password = 'sqpuofxbnuckoaki'; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
        $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

       // Recipients
        $mail->setFrom('rohitbhagat9302@gmail.com', 'Rohit Bhagat');
        $mail->addAddress('rohitbhagat9302@gmail.com'); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'E-mail Verification';
        $mail->Body = "Thanks! for Registration
        click the below link to verify your e-mail
        <a href='http://localhost/practice5/verify.php?email=$email&v_code=$v_code'>click here to verify </a>";

        $mail->send();
        return true;
        echo 'Message has been sent';
    } 
    catch (Exception $e) {
        return false;
    }
}

if (isset($_POST['login'])) {
    $query = "SELECT * FROM login WHERE email='$_POST[email_username]' OR username='$_POST[email_username]'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $result_fetch = mysqli_fetch_assoc($result);
            if (password_verify($_POST['password'], $result_fetch['password'])) {

                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $result_fetch['username'];
                header("location: index.php");

            } else {
                echo "rohit";
                echo " <script> alert('password do not match'); 
                window.location.href='index.php'; </script>";

            }


        } else {
            echo " <script> alert('E-mail or username does not exist'); 
            window.location.href='index.php'; </script>";
        }

    } else {

        echo " <script> alert('Cannot run query'); 
        window.location.href='index.php'; </script>";
    }

} else {

}

if (isset($_POST['register'])) {
    $user_exist_query = "SELECT * FROM login WHERE  username='$_POST[username]' OR email='$_POST[email]'";
    $result = mysqli_query($conn, $user_exist_query);

    if ($result) {

        if (mysqli_num_rows($result) > 0) {
            $result_fetch = mysqli_fetch_assoc($result);

            if ($result_fetch['username'] == $_POST['username']) {
                echo " <script> alert('$result_fetch[username] - Username Already Exist'); 
            window.location.href='index.php'; </script>";

            } else {
                echo " <script> alert('$result_fetch[email] - E-mail Already Exist'); 
            window.location.href='index.php'; </script>";
            }
        } else {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $v_code = bin2hex(random_bytes(16));

            $query = "INSERT INTO `login` (`fullname`, `username`, `email`, `password`,`verification_code`, `its_verified`) VALUES ('$_POST[fullname]','$_POST[username]', '$_POST[email]','$password' , '$v_code', '0')";

            if (mysqli_query($conn, $query) 
            && sendMail($_POST['email'], $v_code)
        ) {
                echo " <script> alert('Registeration successfully'); 
                   window.location.href='index.php'; </script>";

             }
             else {
                echo " <script> alert('Server down'); 
                window.location.href='index.php'; </script>";

            }

        }


    } else {
        echo " <script> alert('Cannot run query'); 
window.location.href='index.php'; </script>";

    }



} else {

}
?>