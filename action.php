<?php
if(!isset($_SESSION))
{
    session_start();
}
include 'session.php';
//print_r($_POST);
require 'db.php';
if(isset($_POST['actionr'])){
  $name=check_input($_POST['name']);
    $uname=check_input($_POST['username']);
    $email=check_input($_POST['email']);
    $pass=check_input($_POST['password']);
    $pass= sha1($pass);
    $created=date('Y-m-d');
    
    $sql=$con->prepare("SELECT username,email FROM users WHERE username=? OR email=?");
    $sql->bind_param("ss",$uname,$email);
    $sql->execute();
    $result=$sql->get_result();
    $row=$result->fetch_array(MYSQLI_ASSOC);
    
    if($row['username']==$uname){
         echo"username not available try different!";
        
    }
    elseif($row['email']==$email){
        echo"email is already registered try different!";
    }
    else{
        $stmt=$con->prepare("INSERT INTO users (name,username,email,password,created) VALUES(?,?,?,?,?)");
$stmt->bind_param("sssss",$name,$uname,$email,$pass,$created);
        if($stmt->execute()){
            echo 'Registered successfully. login now';
            
        }
        else{
            echo 'Something went wrong. Try again';
        }
    } 
    
}
if(isset($_POST['actionl'])){
   if(!isset($_SESSION))
{
    session_start();
}
    $username=$_POST['username'];
    $password=sha1($_POST['password']);
    
    $stmt_l=$con->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt_l->bind_param("ss",$username,$password);
    $stmt_l->execute();
    $user=$stmt_l->fetch();
    
    if($user!=null){
        $_SESSION['username']=$username;
        echo 'ok' ;
        
        if(!empty($_POST['rem'])){
            setcookie('username',$_POST['username'],time()+(10*365*24*60*60));
              setcookie('password',$_POST['password'],time()+(10*365*24*60*60));
        }
        else{
            if(isset($_COOKIE['username'])){
                setcookie('username','');
                
            }
            if(isset($_COOKIE['password'])){
                setcookie('password','');
                
            }
        }
    }
    else{
        echo 'login failed! check your username and password';
    }
}


function check_input($data){
    
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}
//if(!mysqli_query($con,"INSERT INTO users (name,username,email,password,created) VALUES('mudit','mudit','mudit@gla.com','12345678','2019-05-20')"))
//{
//    echo(mysqli_error($con));
//}


if(isset($_POST['actiona'])){
    
    $pid = $_POST['pid'];
     $pname = $_POST['pname'];
     $pprice = $_POST['pprice'];
     $pimage = $_POST['pimage'];
     $pcode = $_POST['pcode'];
    $pqty = 1;
    $stmt = $con->prepare("SELECT product_code FROM cart WHERE product_code=? and uid=?");
        $stmt->bind_param("si",$pcode,$uid);
    $stmt->execute();
    $res = $stmt->get_result();
    $r = $res->fetch_assoc();
    $code = $r['product_code'];
    
    if($username !='guest')
    {
    if(!$code){
       $query = $con->prepare("INSERT INTO cart (uid,product_name,product_price,product_image,qty,total_price,product_code) VALUES(?,?,?,?,?,?,?)");
        $query->bind_param("isssiss",$uid,$pname,$pprice,$pimage,$pqty,$pprice,$pcode);
        $query->execute();
//        if(!mysqli_query($con,"INSERT INTO cart (product_name,product_price,product_image,qty,total_price,product_code) VALUES(?,?,?,?,?,?)"))
//{
//    echo(mysqli_error($con));
//}

        
//        echo '<div class="alert alert-success alert-dismissible mt-2">
//  <button type="button" class="close" data-dismiss="alert">&times;</button>
//  <strong>Item added to your cart!</strong> 
//</div>';
        echo "Item added to your cart!";
    }
    else{
//      echo '<div class="alert alert-danger alert-dismissible mt-2">
//  <button type="button" class="close" data-dismiss="alert">&times;</button>
//  <strong>Item already added to your cart!</strong> 
//</div>';  
        echo "Item already added to your cart!";
    }
}
    else
    {
//         echo '<div class="alert alert-danger alert-dismissible mt-2">
//  <button type="button" class="close" data-dismiss="alert">&times;</button>
//  <strong>You need to login first!</strong> 
//</div>';  
       echo "You need to login first";
    }
}

if(isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item'){
    $stmt = $con->prepare("SELECT * FROM cart WHERE uid=?");
    $stmt->bind_param('i',$uid);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    echo $rows;
}
if(isset($_GET['remove'])){
    $id = $_GET['remove'];
    $stmt = $con->prepare("DELETE FROM cart WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    
    $_SESSION['showAlert'] = 'block';
    $_SESSION['message']='Item removed from the cart!';
    header('location:cart.php');
    
}
if(isset($_GET['clear'])){
    $stmt = $con->prepare("DELETE FROM cart where uid = ?");
    $stmt->bind_param("i",$uid);
    $stmt->execute();
    $_SESSION['showAlert'] = 'block';
    $_SESSION['message']=' All Item removed from the cart!';
    header('location:cart.php');
}

if(isset($_POST['qty'])){
    $qty = $_POST['qty'];
    $pid = $_POST['pid'];
    $pprice = $_POST['pprice'];
        $tprice = $qty*$pprice;
        $stmt = $con->prepare("UPDATE cart SET qty=?, total_price=? WHERE id=?");
    $stmt->bind_param("isi",$qty,$tprice,$pid);
    $stmt->execute();
    
}
if(isset($_POST['actiono'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $products = $_POST['products'];
    $address = $_POST['address'];
    $grand_total = $_POST['grand_total'];
    $pmode = $_POST['pmode'];
    $data = "";
    $stmt = $con->prepare("INSERT INTO orders(name,email,phone,address,pmode,products,amount_paid)VALUES(?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss",$name,$email,$phone,$address,$pmode,$products,$grand_total);
    $stmt->execute();
    $data .= '<div class="text-center" style="margin-top:100px">
            <h1 class="display-4 mt-2 text-danger">THANK YOU!</h1>
            <h2>Your Order Placed Successfully</h2>
            <h4 class="bg-danger text-light rounded p-2" style="height:200px">Items Purchased : '.$products. '</h4>
            <h4>Your Name : '.$name.'</h4>
            <h4>Your Table Number : '.$address.'</h4>
            <h4>Your E-Mail : '.$email.'</h4>
            <h4>Your Phone : '.$phone.'</h4>
            <h4>Total Amount Paid : '.number_format($grand_total,2).'</h4>
            <h4>Payment Mode : '.$pmode.'</h4>
            
    </div>';
    echo $data;   
}

if(isset($_POST['actionf'])){
    
    $sql = "SELECT * FROM product WHERE brand!=''";
    if(isset($_POST['brand'])){
        $brand = implode("','",$_POST['brand']);
        $sql .="AND brand IN('".$brand."')";
    }
    if(isset($_POST['product_price'])){
        $product_price = implode("','",$_POST['product_price']);
        $sql .="AND product_price IN('".$product_price."')";
    }
    $result = $con->query($sql);
    $output = '';
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            $output .='<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 " style="margin-top:50px">
                    <div class="card text-center border-success" >

                        <img class="card-img-top bg-light img-fluid" src="'.$row['product_image'].'" style="height:350px">
                        <div class="card-body">
                            <h4>'.$row['product_name'].'</h4>
                            <p>Rs.&nbsp;'. number_format($row['product_price']).'/-</p>
                            <form action="" class="form-submit">
                                <input type="hidden" class="pid" value="'.$row['p_id'].'">
                                <input type="hidden" class="pname" value="'.$row['product_name'].'">
                                <input type="hidden" class="pprice" value="'.$row['product_price'].'">
                                <input type="hidden" class="pimage" value="'.$row['product_image'].'">
                                <input type="hidden" class="pcode" value="'.$row['product_code'].'">
                                <button class="btn btn-primary btn-block addItemBtn" onclick="addItem(this,event)"><i class="fa fa-cart-plus"></i>&nbsp;Add To Cart</button>
                            </form>
                                
                        

                        </div>
                    </div>
              
                </div>';
        }
    }
    else{
        $output = "<h3> NO PRODUCTS FOUND!</h3>";
    }
    echo $output;
}
?>
