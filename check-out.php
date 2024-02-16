
<?php
  include 'config.php';


  if(isset($_POST['order_btn'])){
    $user_name = $_POST['user_name'];
    $user_number = $_POST['user_number'];
    $user_email = $_POST['user_E-mail'];
    $pyment_method = $_POST['pyment_method'];
    $user_flat = $_POST['user_Address_1'];
    $user_street = $_POST['user_Address_2'];
    $user_city = $_POST['user_city'];
    $user_state = $_POST['user_state'];
    $user_country = $_POST['user_country'];
    $user_pin= $_POST['user_pin'];

    //select from cart 
    $select_sql = mysqli_query($conn ,"SELECT * FROM `cart` ");
    $total =0;
    $grand_total  =0;
    if(mysqli_num_rows($select_sql) > 0){
        while($row = mysqli_fetch_assoc($select_sql)){
            $product_name[] = $row['name'];
            $total = number_format($row['price'] * $row['quntity']);
            $grand_total +=$total;
           
        };
    };
    //insert into order table
    $product_name_str = implode(',', $product_name );
    $insert_sql =mysqli_query($conn ,"INSERT INTO `order` (name , number ,email ,method ,flat ,street,
    city ,state ,country ,pin , totalPrice ,product_name) VALUES ('$user_name' ,'$user_number' ,'$user_email' ,
    '$pyment_method' ,'$user_flat' ,'$user_street' ,'$user_city','$user_state' ,'$user_country' ,'$user_pin' ,'$grand_total' ,' $product_name_str')");
    
    if($select_sql && $insert_sql){
     echo "<div class='order-message'>
      <div class='message-order-container'>
      <h1 class='title plus'>Thanks for your shopping</h1>
        <div class='order-detail'>
          <span class='name-str'>". $product_name_str ."</span>
          <span class='total'> Total : $ ". $grand_total."  /- </span>
        </div>
      <div class='custmer-detail'>
          <p>your name:<span> ". $user_name  ."</span></p>
          <p>your number:<span> ".  $user_number  ."</span></p>
          <p>your Email:<span> ". $user_email   ."</span></p>
          <p>your address:<span> ". $user_flat ." ,  ".$user_street.", ".$user_city.", ".$user_state.", ".$user_country."</span></p>
          <p>your payment mode:<span> ".$pyment_method."</span></p>
          <p>(*pay when products arrives*)</p>
      </div>
  <a href='product.php' class='btn'>continue shopping</a>
      </div>
  </div>" ;


    }else{
        echo 'error';
    }

  }
?>






  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check out</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   
</head>
<body>
    
<?php
include 'header.php';
?>


<section class='check-section'>
<h1 class="title">complete your order</h1>


<div class="check-container">
    <form action="" method='post' class='check-form'>

    <div class="display-order">
    <?php 
    $sql= mysqli_query($conn , "SELECT * FROM `cart`");
    $total=0;
    $grand_total =0;
    if(mysqli_num_rows($sql)>0){
           while( $row=mysqli_fetch_assoc($sql)){
            $total = number_format($row['price'] * $row['quntity']);
            $grand_total += $total;
        ?>

<span class='display-name'><?= $row['name'] ?>(<?= $row['quntity']  ?>)</span>
<?php
 };
    };

 ?>
 
<div class="display-total">
    <p> grand total :$ <?= $grand_total   ?>/-</p>
    </div>

</div>

        <div class="flex">
        <div class="check-box">
            <span>Your name</span>
            <input type="text" placeholder='enter your name' name='user_name' required>
        </div>

        <div class="check-box">
            <span>Your number</span>
            <input type="number" placeholder='enter your number' name='user_number' required>
        </div>

        <div class="check-box">
            <span>Your E-mail</span>
            <input type="text" placeholder='enter your E-mail' name='user_E-mail'required>
        </div>


            <div class="check-box">
            <span>payment method</span>
                <select name="pyment_method" id="">
                    <option value="cash on delivery" selected>cash on delivery</option>
                    <option value="credit cart">credit cart</option>
                    <option value="paypal">pay pal</option>
                </select>
            </div>


        <div class="check-box">
            <span>Your Address line 1</span>
            <input type="text" placeholder='eg.flat no.' name='user_Address_1' required>
        </div> 

        <div class="check-box">
            <span>Your Address line 2</span>
            <input type="text" placeholder='eg.street name' name='user_Address_2' required>
        </div> 

        <div class="check-box">
            <span> city</span>
            <input type="text" placeholder='eg. hannover' name='user_city'required>
        </div> 

        <div class="check-box">
            <span>state</span>
            <input type="text" placeholder='eg. hannover' name='user_state' required>
        </div> 

        <div class="check-box">
            <span>country</span>
            <input type="text" placeholder='eg. Deutschland' name='user_country'required>
        </div> 

        <div class="check-box">
            <span>Pin code </span>
            <input type="text" placeholder='eg. 12345' name='user_pin' required>
        </div> 
        </div>

        <input type="submit" value='order now' class='btn order-btn' name='order_btn'>
      
    </form> 
</div>
</section>





    
</body>
</html>