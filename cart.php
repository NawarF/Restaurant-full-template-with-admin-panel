<?php

include 'config.php';

//update quantity
if(isset($_POST['update_qun'])){
  $new_qun = $_POST['quntity_num'];
  $id =$_POST['qun_id'];
  $sql =mysqli_query($conn ,"UPDATE `cart` SET quntity ='$new_qun' WHERE id='$id'") or die("sql error");
  if($sql){
    header('location: cart.php');
  };
};

//delete item
if(isset($_GET['delete'])){
    $id =$_GET['delete'];
    $sql = mysqli_query($conn ," DELETE FROM `cart` WHERE id='$id'");
    header('location: cart.php');
};

//delete all items

if(isset($_GET['delete_all'])){
    $id =$_GET['delete_all'];
    $sql =mysqli_query($conn," DELETE FROM `cart`");
    header('location: cart.php');
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping cart</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   
</head>
<body>
<?php
include 'header.php';
?>

<section class="shopping-section">
<h1 class="title"> shopping cart</h1>

<div class="shopping-container">
    <table class="shopping-table" >
        <thead>
            <th>image</th>
            <th>name</th>
            <th>price</th>
            <th>quantity</th>
            <th>total price</th>
            <th>action</th>
        </thead>
                
        <tbody>
            <?php
            $select_query = mysqli_query($conn ,"SELECT * FROM `cart`");
            $grand_total=0;
            if(mysqli_num_rows($select_query) > 0 ){
                while($row = mysqli_fetch_assoc($select_query)){
                ?>

          <tr>
            <td><img src="upload/<?php echo $row['image']; ?>" height="100px" alt=""></td>
            <td> <?php echo  $row['name']; ?></td>
            <td>$<?php echo  number_format($row['price']);?>/-</td>
            <td>
            <form action="" method='POST' class="update-form">
                <input type="hidden" name ='qun_id' value="<?php echo $row['id'];?>">
                <input type="number" min='1' name='quntity_num'  value="<?php echo $row['quntity'];  ?>">
                <input type="submit" value="update" name="update_qun" > 
            </form>
            </td>

            <td> 
                $<?php echo $sub_total = number_format( $row['price'] * $row['quntity'] )  ;?>/-
            </td>
         <td>
         <a href="cart.php?delete=<?php echo $row['id']; ?>" class='delete-btn btn'  name='delete_item' onclick='return confirm("delete item?")'>
                <i class="fas fa-trash"></i>
                delete</a>
         </td>
          </tr>
        <?php
         $grand_total += $sub_total;
                };
            };
           
            ?>

        <tr style=' background-color: var(--bg-color);'>
            <td colspan=2><a href="product.php" class='cont_shop'>continue shopping</a></td>
            <td colspan=2 style= 'color: var(--black) ; font-size:18px';> Grand total</td>
            <td>$<?php echo  $grand_total ?>/-</td>
            <td>
         <a href="cart.php?delete_all" name='delete_all' class='delete-btn btn'  onclick='return confirm("delete all item?")'>
                <i class="fas fa-trash"></i>
                delete all</a>
         </td>
        </tr>
        </tbody>
           </table>

           
        </div>
     
    <div class="checkout">
        <a href="check-out.php" class="btn <?=  ($grand_total > 1) ? '': 'disabled'; ?>">procced to cheak out </a>
    </div>

</section>

<script src='main.js'></script> 
</body>
</html>