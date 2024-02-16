<?php
include('config.php');

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])){
    $pname = $_POST['pname'];
    $pprice = $_POST['pprice'];
    $pimage = $_FILES['pimage']['name'];
    $pimage_tmp = $_FILES['pimage']['tmp_name'];
    $pimage_folder = 'upload/'.$pimage;

   $insert_query = mysqli_query($conn,"INSERT into `products` (name ,price,image) values('$pname' ,'$pprice','$pimage')") or die('query failed');
  

   if($insert_query){
    move_uploaded_file($pimage_tmp ,$pimage_folder);
    $message[]="the product added succesfuly";
   }else{
    $message[]="couldn't add the product";
   }

} 

//delete operation 
if(isset($_GET['delete'])){
    $delet_id = $_GET['delete'];
    $delet_query = mysqli_query ($conn, "DELETE FROM products WHERE id = $delet_id");
    if($delet_query){
        $message[]=" product deleted successfuly ";
        header('location:admin.php');
}else{
    $message[]=" product couldn't be deleted ";
};
};


//update operation
if(isset($_POST['update_btn'])){
    $id =$_POST['pro_id'];
    $newname =$_POST['edit_name'];
    $newprice =$_POST['edit_price'];
    $newfile = $_FILES['edit_file']['name'];
    $newfolder =$_FILES['edit_file']['tmp_name'];
    $newdic = "upload/".$newfile;

    $update_query =mysqli_query($conn,"UPDATE `products` SET name='$newname' ,price= '$newprice' ,image ='$newfile' where id ='$id' ");
    if($update_query){
        move_uploaded_file($newfolder , $newdic);
        header('location:admin.php');
        $message[]="product  updated succesfully";
     
       
    }else{
        header('location:admin.php');
        $message[]="couldn't  update product";
       
    }
};





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   
</head>
<body>

<?php
if(isset($message)){
    foreach($message as $msg){
        echo '<div class="message">
        <span>'.$msg.'</span>
        <i class="fas fa-times" onclick= "this.parentElement.style.display = `none`"></i>
        </div>';
    }
}
?>

<?php
include 'header.php';
?>

<section id='admin'>
    <div class="container">
        <form method='POST' class="add-product-form" enctype='multipart/form-data'>
            <h2 >ADD A NEW PRODUCKT</h2>
            <input type="text" name='pname' placeholder='enter the product name' required>
            <input type="number" name='pprice' placeholder='enter the product price' required>
            <input type="file" name='pimage' accept='images/jpg , images/png , images/jpng' required>
            <input type="submit" name ='add_product' value="Add The Product" class='add-product-btn'>
</form>
    </div>

</section>


<section id='display-table'>

   <table  class="table-show">
    <thead>
        <tr>
        <th>PRODUCT IMAGE</th>
        <th>PRODUCT NAME</th>
        <th>product price</th>
        <th>action</th>
        </tr>
    </thead>

    <tbody>
      
   <?php
      $select_query = mysqli_query($conn, "SELECT * FROM `products` ;");
      if(mysqli_num_rows($select_query)  > 0){
        while($row = mysqli_fetch_assoc($select_query)){
            ?>
            <tr>
                <td><img src="upload/<?php echo $row['image']; ?>" height ='100px' alt=""></td>
                <td><?php echo $row['name'] ?></td>
                <td>$<?php echo $row['price'] ?>/-</td>
                <td>
                <a href="admin.php?delete=<?= $row['id']; ?>" class='delete-btn btn'  onclick='return confirm("Are you sure you want to delete this?!")'>
                <i class="fas fa-trash"></i>
                delete</a>
                <a href="admin.php?edit=<?= $row['id'] ; ?>"  class='option-btn  btn'>
                <i class="fas fa-edit"></i>
                update</a>
                </td>
              
            </tr>
<?php
 }
      }else{
        echo "<div class='empty' style='background-color: var(--bg-color);
        text-align: center;
        margin: 5px auto;
        padding: 1rem;
        width: 50%;'>no product added </div>";
      }

?>
    </tbody>
  </table> 
  
</section>



<section id="edit-form-section" >
<?php
if(isset($_GET['edit'])) { 
  $edit_id= $_GET['edit'];
   $select_query = mysqli_query($conn,"SELECT * FROM `products` WHERE id = $edit_id");
   if(mysqli_num_rows($select_query) > 0){
    while($edit_row = mysqli_fetch_assoc($select_query)){

?>

<form action="" method="POST" enctype='multipart/form-data' class="edit_form">
   <img src="upload/<?php echo $edit_row['image'];  ?>"  style="width: 200px;
    margin: auto;"   height="200px" alt="">
    <input type="hidden" name="pro_id" value="<?php echo $edit_row['id']; ?>">
  <input type="text" name="edit_name" value="<?php echo $edit_row['name']; ?>">
  <input type="number" name="edit_price" value="<?php  echo $edit_row['price']; ?>">
  <input type="file" name="edit_file"  accept='images/jpg , images/png , images/jpng' required>
  <input type="submit" class="btn" name='update_btn' id="update-btn" value="Update product" >
  <input type="submit" class="btn" value="cancel" id="cancel-btn" name='cancel_btn'>

</form>

<?php
    };
   };
   echo "<script>document.querySelector('#edit-form-section').style.display = 'flex';</script>";
};

?>

</section>


<script src='main.js'></script>
</body>

</html>