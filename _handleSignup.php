<?php
$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $username=$_POST['signupusername'];
    $user_email = $_POST['signupEmail'];
    $pass = $_POST['signupPassword'];
    $cpass = $_POST['signupcPassword'];


    // Check whether this email exists
    $existSql = "select * from `users` where user_email = '$user_email'";
    $result = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($result);
    if($numRows>0){
        $showError = "Email already in use";
    }
    else{
        if($pass == $cpass){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`username`, `user_email`, `user_pass`, `timestamp`) VALUES ( '$username','$user_email', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            
            if($result){
                $showAlert = true;
                header("Location: /subham/forum/index.php?signupsuccess=true");
                exit();
            }

        }
        else{
            $showError = "Passwords do not match"; 
            
        }
    }
    header("Location:/subham/forum/index.php?signupsuccess=false&error=$showError");

}
?>