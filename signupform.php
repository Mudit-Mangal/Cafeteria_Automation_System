<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Signin Form </title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />

    <!-- //Meta tag Keywords -->
    <link rel="stylesheet" href="style.css" type="text/css" media="all" /><!-- Style-CSS -->
<!--    <link href="font-awesome.css" rel="stylesheet"> font-awesome-icons -->
   <link  rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
</head>

<body>
    <section class="signin-form">
          <div class="overlay">
           <div class="container">
            <div id="alert" >
                <strong id="result"></strong>
            </div>
        </div>
            <div class="wrapper">
                <div class="form34" >
                    <h4 class="form-head">Sign up now</h4>
                    <p class="form-para">Sign up using social media to get quick access</p>
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
                    <form action="" method="post" id="register-frm">
                        <div class="">
                            <p class="text-head">Full Name</p>
                            <input type="text" name="name" class="input" placeholder="" required />
                        </div>
                        <div class="">
                            <p class="text-head">Username</p>
                            <input type="text" name="username" class="input" placeholder="" required />
                        </div>
                        <div class="">
                            <p class="text-head">Email Id</p>
                            <input type="email" name="email" class="input" placeholder="" required />
                        </div>
                        <div class="">
                            <p class="text-head">Password</p>
                            <input type="password" name="password" class="input" placeholder="" required />
                        </div>
                        <label class="remember">
                            <input type="checkbox">
                            <span class="checkmark"></span>Remember me
                        </label>
                        <button type="submit" class="signinbutton btn" id="register">Sign up</button>
                        <p class="signup">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Having an account ?<a href="signin.php" class="signuplink">Sign in</a>
                        </p>
                    </form>
                </div>
            </div>
            <!-- copyright -->
		<div class="copyright text-center">
            <p> Signup Form . All rights reserved | Design by :</p>
            </div>
            <!-- //copyright --> 
        </div>
    </section>
    <script>
    $('#register').click(function(e){
       if(document.getElementById('register-frm').checkValidity()){
           e.preventDefault();
           $.ajax({
              url:'action.php',method:'post',data:$('#register-frm').serialize()+'&action=register',
               success:function(response){
                   $("#alert").show();
                   $('#result').html(response);
                   
               }
               
           });
       }
      return true;  
    });
        
    </script>
</body>

</html>