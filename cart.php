<?php
//session_start();
//require 'db.php';
require 'session.php';
?>
<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        /* Make the image fully responsive */
        .carousel-inner img {
            width: 100%;
            height: 100%;
            /*            display: inline-block;*/
        }

        h4 {
            background-color: #5cb85c;
            color: white !important;
            text-align: center;
            font-size: 30px;
        }

        .item {
            height: 100vh;
            width: 100%;
        }

        .item active {
            height: 100vh;
            width: 100%;
        }

    </style>
</head>

<body data-spy="scroll" data-target="#navbarResponsive">
    <!--   start home section-->

    <!--    navigation-->
    <nav class="navbar navbar-expand-md bg-dark navbar-dark  fixed-top">
        <a class="navbar-brand" href="index.php" style="font-style: italic;margin-left: 50px;" ><img src="downloads/logo.png" style="height: 60px;margin-top: -25px;width: 140px"></a>
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
<!--
                <li class="nav-item active">
                    <a class="nav-link" href="#team">Team</a>
                </li>
-->
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
<li class="nav-item dropdown ">
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
            <span><i><span id="cart-item" class="badge badge-danger"></span></i></span>
        </a>
  </div>
    </nav>
    <!--end of navbar section-->
      <div class="container">
          <div class="row justify-content-center">
              <div class="col-lg-10">
                 <div  style="display:<?php if(isset($_SESSION['showAlert'])){echo $_SESSION['showAlert'];} else {
                              echo 'none';} unset($_SESSION['showAlert']); ?>"class="alert alert-success alert-dismissible" style="margin-top:60px">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong><?php if(isset($_SESSION['message'])){echo $_SESSION['message'];} unset($_SESSION['showAlert']);?></strong> 
        </div>
                  <div class="table-responsive ">
                      <table class="table table-bordered table-striped text-center " style="margin-top:100px">
                          <thead>
                              <tr>
                              <td colspan="7">
                                  <h4 class="text-center text-info bg-light" >Products in your cart</h4>
                              </td>
                          </tr>
                          <tr>
                              <th>S.NO</th>
                              <th>Image</th>
                              <th>Product</th>
                              <th>Price</th>
                              <th>Quantity</th>
                              <th>Total Price</th>
                              <th>
                                  <a href="action.php?clear=all" class="badge-danger p-1"onclick="return confirm('Are you sure want to clear your cart?');"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                              </th>
                          </tr>
                          </thead>
                          <tbody>
                              <?php
                              require 'db.php';
                              $stmt = $con->prepare("SELECT * FROM cart WHERE uid=?" );
                              $stmt->bind_param('i',$uid);
                              $stmt->execute();
                              $result = $stmt->get_result();
                              $grand_total =0;
                              $sno = 0;
                              while($row = $result->fetch_assoc()):
                                $sno++;
                              ?>
                              <tr>
                            <td><?= $sno ?></td>
                            <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                             <td><img src="<?= $row['product_image']?>" width='50'></td>
                             <td><?= $row['product_name'] ?></td>
                             <td>Rs. <?= number_format($row['product_price'],2);?> </td>
                             <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                             <td><input type="number" class="form-control itemQty" value="<?= $row['qty']?>" style="width:75px;"></td>
                             <td>Rs. <?= number_format($row['total_price'],2);?></td>
                             <td>
                                 <a href="action.php?remove=<?= $row['id']?>" class="text-danger lead" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a>
                             </td>
                              </tr>
                              <?php $grand_total +=$row['total_price'];?>
                              <?php endwhile; ?>
                              <tr>
                                  <td colspan="3"><a href="index.php" class="btn btn-success"><i class="fa fa-cart-plus"></i>&nbsp;&nbsp;Continue Shopping</a></td>
                                  <td colspan="2"><b>Grand Total</b></td>
                                  <td><b>Rs. <?= number_format($grand_total,2);?></b></td>
                                  <td>
                                      <a href="checkout.php" class="btn btn-info <?= ($grand_total>1)?"":"disabled";?>"><i class="fa fa-credit-card"></i>&nbsp;Checkout</a>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
    

    <!--start of footer section-->
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
                    <p style="margin-left: 40%">&copy; Cafeteria</p>
                </div>
                <!--                <hr class="socket">-->

            </div>
        </footer>
    </div>
    <!--   end contact section-->
<script type="text/javascript">
    $(document).ready(function(){
        
        $(".itemQty").on("change",function(){
           var $el = $(this).closest('tr');
            var pid = $el.find('.pid').val();
            var pprice = $el.find('.pprice').val();
            var qty = $el.find('.itemQty').val();
            location.reload(true);
            $.ajax({
                url:'action.php',
                method:'post',
                cache: false,
                data:{qty:qty,pid:pid,pprice:pprice},
                success:function(response){
                    console.log(response);
                    
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
