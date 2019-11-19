<?php
require 'db.php';
require 'session.php';

$grand_total = 0;
$allItems = "";
$items= array();

$sql = "SELECT CONCAT(product_name,'(',qty,')') AS ItemQty, total_price FROM cart";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()){
    $grand_total +=$row['total_price'];
    $items[] = $row['ItemQty'];
}
//echo $grand_total;
    //print_r($items);
$allItems= implode(",",$items);


?>
<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shpping Cart System</title>
    
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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Items</a>
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
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6 px-4 pb-4" id="order">
                <h3 class="text-center text-info p-2" style="margin-top:60px;margin-left:50px;">Complete your order!</h3>
                <div class="jumbotron p-3 mb-2 text-center">
                    <h6 class="lead"><b>Product(s) : </b><?= $allItems; ?></h6>
                    <h6 class="lead"><b>Delivery Charge : </b>Free</h6>
                    <h5><b>Total Amount Payable : Rs. </b><?= number_format($grand_total,2) ?>/-</h5>
                </div>
                <form action="" method="post" id="placeOrder">
                    <input type="hidden" name="products" value="<?= $allItems;?>">
                    <input type="hidden" name="grand_total" value="<?= $grand_total;?>">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                    </div>
                     <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Enter E-Mail" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required>
                    </div>
                    <div class="form-group">
                       <textarea name="address" class="form-control" rows="3" cols="10" placeholder="Enter Delivery address here (Optional)"></textarea>
                    </div>
               <h6 class="text-center lead">Select Payment Mode</h6>
               <div class="form-group">
                   <select name="pmode" class="form-control">
                       <option value="" selected disabled>Select Payment Mode</option>
                       <option value="cod">Cash On Deivery</option>
                       <option value="cards">Debit/Credit cards</option>
                   </select>
               </div>
               <div class="form-group">
                   <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
               </div>
                </form>
            </div>
        </div>
    </div>
    <div id="contact" class="offset">

        <footer>
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <h2 style="font-style: italic;margin-left: 35%;padding: 20px;">Cafeteria</h2>
                    <h5 style="margin-left: 40%;padding: 10px;">ContactInfo:-</h5>
                    <p style="font-style: italic;margin-left: 40%;padding: 10px;">9634435420<br>mudit.mangal_cs17@gla.ac.in</p>
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
    $(document).ready(function(){
        
        $("#placeOrder").submit(function(e){
            e.preventDefault();
            $.ajax({
                url: 'action.php',
                method: 'post',
                data:$('form').serialize()+"&actiono=order",
                success: function(response){
                    $("#order").html(response);
                }
            });
        });
        
        $(".addItemBtn").click(function(e){
           e.preventDefault();
            var $form = $(this).closest(".form-submit");
            var pid = $form.find(".pid").val();
            var pname = $form.find(".pname").val();
            var pprice = $form.find(".pprice").val();
            var pimage = $form.find(".pimage").val();
            var pcode = $form.find(".pcode").val();
            
            $.ajax({
                url:"action.php",method:"post",
                data:{pid:pid,pname:pname,pprice:pprice,pimage:pimage,pcode:pcode},
                success:function(response){
                    $("#message").html(response);
//                    window.scrollTo(0,0);
                    load_cart_item_number();
                }
            });
        });
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
    });
    </script>
</body>

</html>
