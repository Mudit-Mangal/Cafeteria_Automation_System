<?php
 session_start();
if(isset($_SESSION['username'])){
    header("location:index.php");
}
$conn = new mysqli("localhost","root","","cafeteria");
$msg="";
if(isset($_POST['Signin'])){
  $username=$_POST['username'];
    $password=$_POST['password'];
    $password= sha1($password);
    
    $sql = "SELECT * FROM users WHERE username=? AND password=? ";
    $stmt=$conn->perpare($sql);
    $stmt->bind_param("ss",$username,$password);
    $stmt->execute();
    $result=$stmt->get_result();
    $row=$result->fetch_assoc();
    session_regenerate_id();
    $_SESSION['username'] = $row['username'];
    session_write_close();
    
    if($result->num_rows==1){
        header("location:index.php");
}
    else{
        
        $msg="Username or password is Incorrect!"; 
    }
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Signin Form </title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />

    <!-- //Meta tag Keywords -->
    <link rel="stylesheet" href="style.css" type="text/css" media="all" /><!-- Style-CSS -->
<!--    <link href="css/font-awesome.css" rel="stylesheet"> font-awesome-icons -->
<link  rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
</head>

<body>
    <section class="signin-form">
        <div class="overlay">
            <div class="wrapper">
                <div class="form34">
                    <h4 class="form-head">Login now</h4>
                    <p class="form-para">Login using social media to get quick access</p>
                    <div class="main-div">
                        <a href="#facebook">
                            <div class="signin facebook">
                                <span class="fa fa-facebook" aria-hidden="true"></span>
                                <p class="action">facebook</p>
                            </div>
                        </a>
                        <a href="#google-plus">
                            <div class="signin google-plus">
                                <span class="fa fa-google-plus" aria-hidden="true"></span>
                                <p class="action">google</p>
                            </div>
                        </a>
                    </div>
                    <div class="form-34or">
                        <span class="pros">
                            <span>or</span>
                        </span>
                    </div>
                    <form action="" method="post" id="login-frm">
                        <div class="">
                            <p class="text-head">Username</p>
                            <input type="text" name="username" class="input"  value="<?php if(isset($_COOKIE['username'])){echo $_COOKIE['username'];}?>" placeholder="" required />
                        </div>
                        <div class="">
                            <p class="text-head">Password</p>
                            <input type="password" name="password" class="input" value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['password'];}?>" placeholder="" required />
                        </div>
                        <label class="remember">
                            <input type="checkbox" name="rem" id="customcheck" <?php if(isset($_COOKIE['username'])) {?> checked <?php }?>>
                            <span class="checkmark"></span>Remember me
                        </label>
                        <button type="submit" class="signinbutton btn" name="login" id="login">Login</button>
                        <p class="signup">Have not an account yet?<a href="signupform.php" class="signuplink">Sign up</a>
                        <a href="masterlogin.php" class="signuplink" style="margin-left: 130px;margin-top: 10px">Admin login</a>
                        </p>
                    </form>
                </div>
            </div>
            <!-- copyright -->
		<div class="copyright text-center">
            <p> Signin Form . All rights reserved | Design by :</p>
            </div>
            <!-- //copyright --> 
        </div>
    </section>
    <script>
    $('#login').click(function(e){
       if(document.getElementById('login-frm').checkValidity()){
           e.preventDefault();
           $.ajax({
              url:'action.php',method:'post',data:$('#login-frm').serialize()+'&action=login',
               success:function(response){
                   if(response==="ok"){
                       window.location='index.php'
                   }
                   else{
                   $("#alert").show();
                   $('#result').html(response);
                   
               }}
               
           });
       }
      return true;  
    });
    </script>
</body>
</html>