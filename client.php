<?php

    include 'connection.php';
    session_start();
    $employee_id = $_SESSION['employee_name'];

    

    if(isset($_POST['logout'])) {
        session_destroy();
        header('location:login.php');
    }
    //adding products to database
    if(isset($_POST['add_product']) && isset($_FILES['image']) ){
        //echo 'hello';
        $product_fname= mysqli_real_escape_string($conn, $_POST['fname']);
        $product_lname= mysqli_real_escape_string($conn, $_POST['lname']);
        $product_pnumber= mysqli_real_escape_string($conn, $_POST['pnumber']);
        $product_email= mysqli_real_escape_string($conn, $_POST['email']);
        $product_gender= mysqli_real_escape_string($conn, $_POST['gender']);
        $product_address= mysqli_real_escape_string($conn, $_POST['address']);
        //fname, lname, pnumber, email, gender, address, image
        //$image= mysqli_real_escape_string($conn, $_POST['image']);
        $image= $_FILES['image']['name'];
        $image_size= $_FILES['image']['size'];
        $image_tmp_name= $_FILES['image']['tmp_name'];
        $image_folder= 'img/'.$image;

        $select_product_phoneNumber= mysqli_query($conn, "SELECT phoneNumber FROM `client` WHERE phoneNumber = '$product_pnumber'")
        or die('query failed2');
        if(mysqli_num_rows($select_product_phoneNumber)>0){
            $message[]= 'client already exist';
        }else{
            $insert_product = mysqli_query($conn, "INSERT INTO `client` (`firstName`,`lastName`,`phoneNumber`, `email`,`gender`,`address`, `image`)
                VALUES('$product_fname','$product_lname','$product_pnumber','$product_email','$product_gender','$product_address','$image')") or die('query failed1');
            if($insert_product){
                //echo 'hello1';
                if($image_size>2000000){
                    $message[]='image size is too large';
                }else{
                    //echo 'hello';
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $message[]='create client successfully';
                }
            }
        }
    }

    //delete products from database
    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $select_delete_image = mysqli_query($conn, "SELECT * FROM `client` WHERE clientID = '$delete_id'") or die('query failed5');
        $feteh_delete_image = mysqli_fetch_assoc($select_delete_image);
        unlink('image/'.$feteh_delete_image['image']);

        mysqli_query($conn, "DELETE FROM `client` WHERE clientID = '$delete_id'") or die('query failed6');
        //mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
        //mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');

        header('location:client.php');
    }

    //update product
    if(isset($_POST['updte_product'])){
        $update_id = $_POST['update_id'];
        $update_fname = $_POST['update_fname'];
        $update_lname = $_POST['update_lname'];
        $update_pnumber = $_POST['update_pnumber'];
        $update_email = $_POST['update_email'];
        $update_gender = $_POST['update_gender'];
        $update_address = $_POST['update_address'];
        $update_image = $_FILES['update_image']['name'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
        $update_image_folder = 'img/'.$update_image;

        

        if($update_image!=NULL){
            $update_query = mysqli_query($conn, "UPDATE `client` SET `clientID`='$update_id',`firstName`='$update_fname',`lastName`='$update_lname',`phoneNumber`='$update_pnumber',
            `email`='$update_email',`gender`='$update_gender',`address`='$update_address',`image`='$update_image' WHERE clientID='$update_id'")or die('query failed4');
        }else{

        

            $update_query = mysqli_query($conn, "UPDATE `client` SET `clientID`='$update_id',`firstName`='$update_fname',`lastName`='$update_lname',`phoneNumber`='$update_pnumber',
            `email`='$update_email',`gender`='$update_gender',`address`='$update_address' WHERE clientID='$update_id'")or die('query failed4');
        }
        if($update_query){
            move_uploaded_file($update_image_tmp_name,$update_image_folder);
            header('location:client.php');
        }
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!---box icon link--->
    <link rel="stylesheet": href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style2.css">
    <title>admin panel</title>
</head>
<body>
    <?php include 'employee_header.php'; ?>
        

        <!--<div class="line2"></div>
        <section class="add-products from-container">
            <from method="POST" action="" enctype="multipart/form-data">
                <div class="input-field">
                    <label>product name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="input-field">
                    <label>product price</label>
                    <input type="text" name="price" required>
                </div>
                <div class="input-field">
                    <label>product detail</label>
                    <textarea name="detail" required></textarea>
                </div>
                <div class="input-field">
                    <label>product image</label>
                    <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" required>
                </div>
                <input type="submit" name="add_product" value="add product">

            </form>

        </section>-->

        <section class="form-container1">
        <a href="employee_panel.php" class="logo"><img class="transparent-logo" src="img/client11.png"></a>
        <!--<a href="employee_panel.php" class="logo"><img class="transparent-logo1" src="img/client11.png"></a>-->

        <?php
        if(isset($message)){
            foreach($message as $message) {
                echo '
                    <div class="message">
                        <span>'.$message.'</span>
                        <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                    </div>
                ';

            }
        }

        ?>
        <form method="post" action="" enctype="multipart/form-data">
        

            <h1>create client</h1>
            <div class="input-field">
                        <label>first name</label>
                        <input type="text" name="fname" required>
                    </div>
                    <div class="input-field">
                        <label>last name</label>
                        <input type="text" name="lname" required>
                    </div>
                    <div class="input-field">
                        <label>phone number</label>
                        <input type="text" name="pnumber" required>
                    </div>
                    <div class="input-field">
                        <label>email</label>
                        <input type="text" name="email" required>
                        <label>gender</label>
                    </div>

                    <select  name="gender" required>
                        <option value="" disabled selected hidden>Select your gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    <div class="input-field">
                        <label>address</label>
                        <textarea name="address" required></textarea>
                    </div>
                    <div class="input-field">
                        <label>Addition</label>
                        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" required>
                    </div>
                    <input type="submit" name="add_product" value="add product" class="btn">

            </form>

    </section>
    <div class="line3"></div>
    <div class="line4"></div>
    <section class="form-container1">
        <div class="box-container">
            <?php
                $select_products=mysqli_query($conn,"SELECT * FROM `client`") or die('query failed3');
                if(mysqli_num_rows($select_products)>0){
                    while($fetch_products= mysqli_fetch_assoc($select_products)){

                    //}

                //}

            ?>
            <div class="box">
                <img src="img/<?php echo $fetch_products['image']; 
                ?>
                ">
                <p>Client ID: <?php echo $fetch_products['clientID']; ?></p>
                <h4>name: <?php echo $fetch_products['firstName']; ?> <?php echo $fetch_products['lastName']; ?></h4>
                <p>phone number: <?php echo $fetch_products['phoneNumber']; ?></p>
                <details>email: <?php echo $fetch_products['email']; ?>
                <br>gender: <?php echo $fetch_products['gender']; ?>
                <br>address: <?php echo $fetch_products['address']; ?> </details>
                
                <a href="client.php?edit=<?php echo $fetch_products['clientID']; ?>"class="edit">edit</a>
                <a href="client.php?delete=<?php echo $fetch_products['clientID']; ?>"class="delete" onclick="
                    return confirm('want to delete this client');">delete</a>
                <a href="clientdeals.php?deals=<?php echo $fetch_products['clientID']; ?>"class="deals">create deals</a>
                
            </div>
            <?php
                    }
                }else{
                    echo '
                        <div class="empty">
                            <p>no products added yet!</p>
                        </div>
                    ';

                }
            ?>
            

        </div>
    </section>

    <div class="line"></div>
    <section class="update-container">
        <?php
            if(isset($_GET['edit'])) {
                $edit_id = $_GET['edit'];
                $edit_query = mysqli_query($conn, "SELECT * FROM `client` WHERE clientID='$edit_id'")or die('query failed');
                if(mysqli_num_rows($edit_query)>0){
                    while($fetch_edit = mysqli_fetch_assoc($edit_query)){

                    
                //}
           // }
        ?>
        <form method="POST" enctype="multipart/form-data">
            <img src="img/<?php echo $fetch_edit['image'];?>">
            <input type="hidden" name="update_id" value="<?php echo $fetch_edit['clientID'];?>">
            <input type="text" name="update_fname" value="<?php echo $fetch_edit['firstName'];?>">
            <input type="text" name="update_lname" value="<?php echo $fetch_edit['lastName'];?>">
            <input type="text" name="update_pnumber" value="<?php echo $fetch_edit['phoneNumber'];?>">
            <input type="text" name="update_email" value="<?php echo $fetch_edit['email'];?>">
            <input type="text" name="update_gender" value="<?php echo $fetch_edit['gender'];?>">
            <select  name="gender" required>
                        <option value="" disabled selected hidden><?php echo $fetch_edit['gender'];?></option>
                        
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
            <textarea name="update_address"><?php echo $fetch_edit['address'];?></textarea>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png, image/webp"
            value="img/<?php echo $fetch_edit['image'];?>">
            <input type="submit" name="updte_product" value="update" class="edit">
            <input type="reset" name="" value="cancel" class="option-btn btn" id="close-form">
        </form>
        <?php 
                    }
                }
                echo "<script>document.querySelector('.update-container').style.display='block'</script>";
            }
        ?> 

    </section>





    





    























    <script type="text/javascript" src="script1.js"></script>
</body>
</html>