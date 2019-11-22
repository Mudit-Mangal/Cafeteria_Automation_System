<?php
include 'db.php';
require 'session.php';
?>
<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart System</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <style>
        /* Make the image fully responsive */
        .carousel-inner img {
            width: 100%;
            height: 100%;
/*            display: inline-block;*/
        }
        h4{
            background-color: #5cb85c;
            color:white !important;
    text-align: center;
    font-size: 30px;
        }
        .item{
    height: 100vh;
    width: 100%;
}
.item active{
    height: 100vh;
    width: 100%;
}
    
    </style>
</head>

<body data-spy="scroll" data-target="#navbarResponsive">
    <!--   start home section-->

    <!--    navigation-->
    <nav class="navbar navbar-expand-md bg-dark navbar-dark  fixed-top">
        <a class="navbar-brand" style="font-style: italic;margin-left: 50px;" href="index.php"><img src="downloads/logo.png" style="height: 60px;margin-top: -25px;width: 140px"></a>
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="message"></div>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#home">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#items">Items</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#team">Team</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>

<!--
                <li class="nav-item active">
                    <a class="nav-link" href="signin.php">Login</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="signupform.php">Signup</a>
                </li>
-->
<li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
      <?= $username; ?>
      </a>
      <div class="dropdown-menu">
        
        <a class="dropdown-item" href="logout.php" style="display:<?php if($username == 'guest') {echo 'none' ;}  ?>;">Logout</a>
        <a class="dropdown-item" href="signin.php" style="display:<?php if($username != 'guest') {echo 'none' ;}  ?>;">Login</a>
        <a class="dropdown-item" href="signupform.php" style="display:<?php if($username != 'guest') {echo 'none' ;}  ?>;">Signup</a>
                
      </div>
    </li>
            </ul>
      
        <a href="cart.php" class="btn navbar-btn btn-primary left bg-dark border-dark">
            <i class="fa fa-shopping-cart"></i>
            <span><i><span  id="cart-item" class="badge badge-danger"></span></i></span>
        </a>
  </div>
    </nav>
    <!--start of image slider-->
<!--
    <div class="container" id="slider">
<div class="col-lg-12">
-->
    <div id="demo" class="carousel slide" data-ride="carousel" >

        <!-- Indicators -->
        <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="item-active"></li>
            <li data-target="#demo" data-slide-to="1" class="item"></li>
            <li data-target="#demo" data-slide-to="2" class="item"></li>
        </ul>

        <!-- The slideshow -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="downloads/home1.png" >
                <div class="carousel-caption text-center">
                    <h1>WELCOME TO OUR CAFETERIA</h1>
                    <h3> A VERSATILE FOOD CORNER</h3>
                    <a class="btn btn-outine-light btn-lg" href="#items" style="color:white;border-color: white;">Get Started</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="downloads/jevelin-food-website-template.jpg" alt="Chicago">
            </div>
            <div class="carousel-item">
                <img src="downloads/lidye-1Shk_PkNkNw-unsplash.jpg" alt="New York">
            </div>
        </div>

        
        <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
<!--
    </div>
    </div>
-->
    <!--end of image slider-->


    <div id="home">
    </div>
    <!--   end home section-->
    <!--   start items section-->
    <div class="container-fluid ml-auto">
    <div class="row ">
       <div class="col-lg-3 col-sm-2 px-2  min-vh-100 bg-dark" >
           <h3 style="color:white">Filter Product</h3>
           <hr>
           <h6 class="text-info">Select Items</h6>
           <ul class="list-group ">
               <?php
               $sql="SELECT DISTINCT brand FROM product ORDER BY brand";
               $result=$con->query($sql);
               while($row=$result->fetch_assoc()){
               ?>
               <li class="list-group-item bg-dark" style="color:white">
                   <div class="form-check">
                       <label class="form-check-label">
                           <input type="checkbox" class="form-check-input product_check" value="<?= $row['brand'];?>" id="brand">
          <?= $row['brand'];?>             </label>
                   </div>
               </li>
              <?php }?> 
           </ul>
           <h6 class="text-info ">Select Price</h6>
           <ul class="list-group">
               <?php
               $sql="SELECT DISTINCT product_price FROM product ORDER BY product_price";
               $result=$con->query($sql);
               while($row=$result->fetch_assoc()){
               ?>
               <li class="list-group-item bg-dark" style="color:white">
                   <div class="form-check">
                       <label class="form-check-label">
                           <input type="checkbox" class="form-check-input product_check" value="<?= $row['product_price'];?>" id="product_price">
          <?= $row['product_price'];?>             </label>
                   </div>
               </li>
              <?php }?> 
           </ul>

        </div>
    <div class="col" id="main">
    <div id="items" class="offset">
       
        <div class="container">
           <br>
            <h3 class="heading" style="text-align: center" id="textChange">ITEMS</h3>
            <hr>
            <div class="heading-underline"></div>
            <div class="row padding justify-content" id="result" >
               <?php
        include 'db.php';
        $stmt = $con->prepare("SELECT * FROM product");
        $stmt->execute();
        $result = $stmt->get_result();
        while($row=$result->fetch_assoc()):
            ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 " style="margin-top:50px">
                    <div class="card text-center border-success" >
                        <img class="card-img-top bg-light img-fluid" src="<?= $row['product_image']?>" style="height:350px" >
                        
                        <div class="card-body">
                            <h4><?= $row['product_name']?></h4>
                            <p>Rs.&nbsp;<?= number_format($row['product_price'])?>/-</p>
                            <form action="" class="form-submit">
                                <input type="hidden" class="pid" value="<?=$row['p_id']?>">
                                <input type="hidden" class="pname" value="<?=$row['product_name']?>">
                                <input type="hidden" class="pprice" value="<?=$row['product_price']?>">
                                <input type="hidden" class="pimage" value="<?=$row['product_image']?>">
                                <input type="hidden" class="pcode" value="<?=$row['product_code']?>">
                                <button class="btn btn-primary btn-block addItemBtn" onclick="addItem(this,event)"><i class="fa fa-cart-plus"></i>&nbsp;Add To Cart</button>
                            </form>

                        </div>
                    </div>
              
                </div>
                
<?php endwhile; ?>
            </div>
           <br>
           <br>
           <br> <br>
           
          
            <!--    end of row -->
            <hr>
            <br>
           <br>
         
           
            <div class="container fixed" id="team">
  <h3 style="text-align:center">TEAM</h3>
  <br>
           <br>
           <br>
           <br>
  <div class="card" style="width:300px;display:inline-block;margin-left:10%">
    <img class="card-img-top" src="downloads/171500194.jpg" alt="Card image" style="width:100%;height:350px">
    <div class="card-body">
      <h3 class="card-title">Mudit Mangal</h3>
      <p class="card-text">Frond End Developer</p>
<!--      <a href="#" class="btn btn-primary">See Profile</a>-->
    </div>
  </div>
       <div class="card" style="width:300px;float:right;margin-right:10%">
    <img class="card-img-top" src="downloads/171500185.jpg" alt="Card image" style="width:100%;height:350px">
    <div class="card-body">
      <h3 class="card-title">Mayank Garg</h3>
      <p class="card-text">Back End Developer</p>
<!--      <a href="#" class="btn btn-primary">See Profile</a>-->
    </div>
  </div>
       <div class="card" style="width:300px;margin-top:5%;margin-left:10%">
    <img class="card-img-top" src="downloads/171500171.jpg" alt="Card image" style="width:100%;height:350px">
    <div class="card-body">
      <h3 class="card-title">Kunal Goyal</h3>
      <p class="card-text">Back End Developer</p>
<!--      <a href="#" class="btn btn-primary">See Profile</a>-->
    </div>
  </div>
       <div class="card" style="width:300px;float:right;margin-right:10%;margin-top:-45%">
    <img class="card-img-top" src="downloads/171500024.jpg" alt="Card image" style="width:100%;height:350px">
    <div class="card-body">
      <h3 class="card-title">Akash Agrawal</h3>
      <p class="card-text">Front End Developer</p>
<!--      <a href="#" class="btn btn-primary">See Profile</a>-->
    </div>
  </div>
        </div>
        
<!--
        <div class="container">

  
        </div>
-->
        
        
        </div>
    </div>
      </div>
       
        
    </div>
</div>
    <!--   end items section-->
    <!--   start team section-->
<!--
    <div id="team" class="offset">

    </div>
-->
    <!--   end team section-->
    <!--   start contact section-->
    <div id="contact" class="offset">

        <footer>
            <div class="row justify-content-center">
                <div class="col-md-5 justify-content-center">
                    <h2 style="font-style: italic;margin-left: 35%;padding: 15px;">Cafeteria</h2>
                    <h5 style="margin-left: 35%;">ContactInfo:-</h5>
                    <p style="font-style: italic;margin-left: 40%;padding: 0px;">6396852830</p>
                    <p style="font-style: italic;margin-left: 30%;padding:0px">mudit.mangal_cs17@gla.ac.in</p>
                    <p style="font-style: italic;margin-left: 40%;padding: 0px;">9149296380</p>
                    <p style="font-style: italic;margin-left: 30%;padding:0px">kunal.goyal_cs17@gla.ac.in</p>
                    <p style="font-style: italic;margin-left: 40%;padding: 0px;">8650584434</p>
                    <p style="font-style: italic;margin-left: 30%;padding:0px">mayank.garg_cs17@gla.ac.in</p>
                    <p style="font-style: italic;margin-left: 30%;padding:0px">akash.agrawal_cs17@gla.ac.in</p>
                    
                    
<!--
                    <a href="" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true" style="margin-left: 100%;"></i></a>
                    <a href="" target="_blank"><i class="fa fa-twitter-square" style="margin-left: 100%;display:inline;"></i></a>
                    <a href="" target="_blank"><i class="fa fa-instagram" style="margin-left: 100%;"></i></a>
               
--> 
 <p style="margin-left: 40%">&copy; Cafeteria</p></div>
<!--                <hr class="socket">-->
           
            </div>
        </footer>
    </div>
    <!--   end contact section-->
<script type="text/javascript">
     function addItem(x,e)
    {
        e.preventDefault();
            var $form = $(x).closest(".form-submit");
//            alert($form.find(".pid").val());
            
            var pid = $form.find(".pid").val();
            var pname = $form.find(".pname").val();
            var pprice = $form.find(".pprice").val();
            var pimage = $form.find(".pimage").val();
            var pcode = $form.find(".pcode").val();
            
            $.ajax({
                url:"action.php",method:"post",
                data:{actiona:'add',pid:pid,pname:pname,pprice:pprice,pimage:pimage,pcode:pcode},
                success:function(response){
                   // $("#message").html(response);
                    alert(response);
//                    window.scrollTo(0,0);
                    load_cart_item_number();
                }
            });
    }
//    $(".addItemBtn").click(function(e){
//           alert('hello')
//           
//        });
    $(".product_check").click(function(){
           var action = 'data';
            var brand = get_filter_text("brand");
            var product_price = get_filter_text("product_price");
            
            $.ajax({
               url:'action.php',
                method:'POST',
                data:{actionf:action,brand:brand,product_price:product_price},
                success:function(response){
                    $("#result").html(response);
                    $("#textChange").text("Filtered Products");
                }
            });
            
        });
    function get_filter_text(text_id){
        var filterData = [];
        $("#"+text_id+":checked").each(function(){
           filterData.push($(this).val());
        });
        return filterData;
    }
        
        load_cart_item_number();
        function load_cart_item_number(){
            $.ajax({
                url: "action.php",
                method:'get',
                data: {cartItem:"cart_item"},
                success:function(response){
                  $("#cart-item").html(response);  
                }
            });
        }
    $(document).ready(function(){
        
        
    });
//    $(document).ready(function(){
//        
//    });
    </script>
    
</body>

</html>
