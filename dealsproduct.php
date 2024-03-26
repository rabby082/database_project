<?php

    include 'connection.php';
    session_start();
    //$employee_id = $_SESSION['employee_email'];

    

    if(isset($_POST['logout'])) {
        session_destroy();
        header('location:login.php');
    }
    //adding products to database
    if(isset($_POST['add_product']) && isset($_FILES['image']) ){
        //echo 'hello'; 
        

        
        $product_dealid= mysqli_real_escape_string($conn, $_POST['dealid']);
        $product_title= mysqli_real_escape_string($conn, $_POST['title']);
        $product_description= mysqli_real_escape_string($conn, $_POST['description']);
        $product_amount= mysqli_real_escape_string($conn, $_POST['amount']);
        $product_issuedate= mysqli_real_escape_string($conn, $_POST['issuedate']);
        $product_deliverydate= mysqli_real_escape_string($conn, $_POST['deliverydate']);
        $product_domain= mysqli_real_escape_string($conn, $_POST['domain']);
        $product_teammember= mysqli_real_escape_string($conn, $_POST['teammember']);
        //fname, lname, pnumber, email, gender, address, image
        //$image= mysqli_real_escape_string($conn, $_POST['image']);
        $image= $_FILES['image']['name'];
        $image_size= $_FILES['image']['size'];
        $image_tmp_name= $_FILES['image']['tmp_name'];
        $image_folder= 'img/'.$image;

        /*$select_product_phoneNumber= mysqli_query($conn, "SELECT phoneNumber FROM `client` WHERE phoneNumber = '$product_pnumber'")
        or die('query failed2');
        if(mysqli_num_rows($select_product_phoneNumber)>0){
            $message[]= 'client already exist';
        }else{*/
             
            $insert_product = mysqli_query($conn, "INSERT INTO `product` (`dealsID`,`title`,`description`,`amount`,`issueDate`,`deliveryDate`,`domainName`,`teamMember`,`image`)
            VALUES('$product_dealid','$product_title','$product_description','$product_amount','$product_issuedate','$product_deliverydate','$product_domain','$product_teammember','$image')") or die('query failed1');

                
            if($insert_product){
                //echo 'hello1';
                if($image_size>2000000){
                    $message[]='image size is too large';
                }else{
                    //echo 'hello';
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $message[]='create client successfully';
                }
            //}
        }
    }

    //delete products from database
    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $select_delete_image = mysqli_query($conn, "SELECT * FROM `deals` WHERE dealsID = '$delete_id'") or die('query failed5');
        $feteh_delete_image = mysqli_fetch_assoc($select_delete_image);
        unlink('img/'.$feteh_delete_image['image']);

        mysqli_query($conn, "DELETE FROM `deals` WHERE dealsID = '$delete_id'") or die('query failed6');
        //mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
        //mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');

        header('location:deals.php');
    }

    //update product
    if(isset($_POST['updte_product'])){
        echo "a";
        $update_id = $_POST['update_id'];
        $update_clientid = $_POST['update_cid'];
        $update_title = $_POST['update_title'];
        $update_analysis = $_POST['update_analysis'];
        $update_proposal = $_POST['update_proposal'];
        $update_negotiation = $_POST['update_negotiation'];
        $update_dealwon = $_POST['update_dealwon'];
        $update_deallost = $_POST['update_deallost'];
        $update_image = $_FILES['update_image']['name'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
        $update_image_folder = 'img/'.$update_image;
        


        

        if($update_image!=NULL){
            $update_query = mysqli_query($conn, "UPDATE `deals` SET `dealsID`='$update_id',`clientID`='$update_clientid',`title`='$update_title',`analysis`='$update_analysis',`proposal`='$update_proposal',
            `negotiation`='$update_negotiation',`dealWon`='$update_dealwon',`deallost`='$update_dealLost',`dateAndTime`=NOW(),`image1`='$update_image' WHERE dealsID='$update_id'")or die('query failed4');
        }else{

        

            $update_query = mysqli_query($conn, "UPDATE `deals` SET `dealsID`='$update_id',`clientID`='$update_clientid',`title`='$update_title',`analysis`='$update_analysis',`proposal`='$update_proposal',
            `negotiation`='$update_negotiation',`dealWon`='$update_dealwon',`deallost`='$update_dealLost',`dateAndTime`=NOW() WHERE dealsID='$update_id'")or die('query failed4');
        }
        if($update_query){
            move_uploaded_file($update_image_tmp_name,$update_image_folder);
            header('location:deals.php');
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

        <section class="form-container">
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
        <h1>insert product info</h1>
                        <?php
                            $edit_id = (isset($_GET['product'])) ? $_GET['product'] : 0; // Set a default value if 'deals' is not set
                            $edit_query = mysqli_query($conn, "SELECT * FROM `deals` WHERE dealsID ='$edit_id'")or die('query failed');
                            $fetch_edit = mysqli_fetch_assoc($edit_query);
                        ?>


                    <div class="input-field1">
                        
                        <label>deal id</label><br>
                        <input type="text" readonly value="<?php echo $edit_id; ?>" name="dealid" required>
                    </div> 
                    <!--<input type="submit" name="search" value="search deals" class="btn">
                    placeholder="Enter Deal ID"-->
                    










                    <div class="input-field">
                        <label>title</label><br>
                        <input type="text" value="<?php echo $fetch_edit['title'];?>" name="title" required>
                    </div>
                    <div class="input-field">
                        <label>description</label>
                        <textarea name="description" required><?php echo $fetch_edit['analysis']; ?></textarea>

                    </div>

                    <div class="input-field">
                        <label>Addition</label><br>
                        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" required>
                    </div>
                    

                    <div class="input-field">
                        <label>amount</label><br>
                        <input type="number" value="<?php echo $fetch_edit['dealWon'];?>" min="0" name="amount" step="10000" required>

                        
                    </div>
                    <div class="input-field">
                        <label>issue date and time</label><br>
                        <input type="text" readonly value="<?php echo $fetch_edit['dateAndTime'];?>" name="issuedate" required>
                    </div>

                    </div>
                    <div class="input-field">
                        <label>delivery date</label>
                        <input type="date" name="deliverydate" required>
                    </div>

                    <div class="input-field">
                        <label>domain name</label>
                        <input type="text" name="domain" required>
                    </div>

                    <div class="input-field">
                        <label>team member</label>
                        <textarea name="teammember" required></textarea>
                    </div>

                    <input type="submit" name="add_product" value="insert" class="btn">


            </form>

    </section>
    <div class="line3"></div>
    <div class="line4"></div>
    
    <section class="form-container1">
        <div class="box-container">
            <?php
                $edit_id = (isset($_GET['deals'])) ? $_GET['deals'] : 0;
                /*$select_products=mysqli_query($conn,"SELECT * FROM `deals`") or die('query failed3');*/
                $select_products=mysqli_query($conn,"SELECT * FROM `deals` 
                LEFT JOIN `client` ON deals.clientID = client.clientID where deals.clientID='$edit_id '
                ") or die('query failed31');
                if(mysqli_num_rows($select_products)>0){
                    while($fetch_products= mysqli_fetch_assoc($select_products)){

                    //}

                //}

            ?>
            <div class="box">
                <img src="img/<?php echo $fetch_products['image1']; ?>">
                <p>deal id: <?php echo $fetch_products['dealsID']; ?></p>
                <h4>title: <?php echo $fetch_products['title']; ?></h4>
                <h4>name: <?php echo $fetch_products['firstName']; ?> <?php echo $fetch_products['lastName']; ?></h4>
                <p>phone number: <?php echo $fetch_products['phoneNumber']; ?></p>
                
                <details>description: <?php echo $fetch_products['analysis']; ?>
                <br>proposal amount: <?php echo $fetch_products['proposal']; ?> Taka
                <br>negotiation amount: <?php echo $fetch_products['negotiation']; ?> Taka
                <br>deal won amount: <?php echo $fetch_products['dealWon']; ?> Taka
                <br>deal lost amount: <?php echo $fetch_products['dealLost']; ?> Taka
                <br>date & time: <?php echo $fetch_products['dateAndTime']; ?>
                <br>received by: <?php echo $fetch_products['receivedBy']; ?></details>
                
                <a href="deals.php?edit=<?php echo $fetch_products['dealsID']; ?>"class="edit">edit</a>
                <a href="deals.php?delete=<?php echo $fetch_products['dealsID']; ?>"class="delete" onclick="
                    return confirm('want to delete this deal');">delete</a>
                <a href="deals.php?client=<?php echo $fetch_products['dealsID']; ?>"class="deals">client profile</a>
                
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
                $edit_query = mysqli_query($conn, "SELECT * FROM `deals` WHERE dealsID='$edit_id'")or die('query failed');
                if(mysqli_num_rows($edit_query)>0){
                    while($fetch_edit = mysqli_fetch_assoc($edit_query)){

                    
                //}
           // }
        ?>
        <form method="POST" enctype="multipart/form-data">
            <img src="img/<?php echo $fetch_edit['image1'];?>">
            <input type="hidden" name="update_id" value="<?php echo $fetch_edit['dealsID'];?>">
            <input type="number" name="update_cid" value="<?php echo $fetch_edit['clientID'];?>">
            <input type="text" name="update_title" value="<?php echo $fetch_edit['title'];?>">
            <textarea name="update_analysis"><?php echo $fetch_edit['analysis'];?></textarea>
            <input type="number" name="update_proposal" min="0" step="10000" value="<?php echo $fetch_edit['proposal'];?>">
            <input type="number" name="update_negotiation" min="0" step="10000" value="<?php echo $fetch_edit['negotiation'];?>">
            <input type="number" name="update_dealwon" min="0" step="10000" value="<?php echo $fetch_edit['dealWon'];?>">
            <input type="number" name="update_deallost" min="0" step="10000" value="<?php echo $fetch_edit['dealLost'];?>">
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png, image/webp"
            value="img/<?php echo $fetch_edit['image1'];?>">
            <input type="submit" name="updte_product" value="update" class="edit">
            <input type="reset" value="Go Back" class="option-btn btn" id="go-back" onclick="window.history.back();">

        </form>
        <?php 
                    }
                }
                echo "<script>document.querySelector('.update-container').style.display='block'</script>";
            }
        ?> 

    </section>





    





    <!--<div class="line"></div>
    <section class="update-container1">
        <?php
            if(isset($_GET['deals'])) {
                $deals_id = $_GET['deals'];
                $deals_query = mysqli_query($conn, "SELECT * FROM `client` WHERE clientID='$deals_id'")or die('query failed10');
                if(mysqli_num_rows($deals_query)>0){
                    while($fetch_deals = mysqli_fetch_assoc($deals_query)){

                    
                //}
           // }
        ?>
        <form method="POST" enctype="multipart/form-data">
            <p>deals</p>
            <img src="img/<?php echo $fetch_deals['image'];?>">
            <input type="hidden" name="deals_id" value="<?php echo $fetch_deals['clientID'];?>">
            <input type="text" name="deals_fname" value="<?php echo $fetch_deals['firstName'];?>">
            <input type="text" name="deals_lname" value="<?php echo $fetch_deals['lastName'];?>">
            <input type="text" name="deals_pnumber" value="<?php echo $fetch_deals['phoneNumber'];?>">
            <input type="text" name="deals_email" value="<?php echo $fetch_deals['email'];?>">
            <input type="text" name="deals_gender" value="<?php echo $fetch_deals['gender'];?>">
            <select  name="gender" required>
                        <option value="" disabled selected hidden><?php echo $fetch_deals['gender'];?></option>
                        
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
            <textarea name="update_address"><?php echo $fetch_deals['address'];?></textarea>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png, image/webp"
            value="img/<?php echo $fetch_deals['image'];?>">
            <input type="submit" name="updte_product" value="update" class="deals">
            <input type="reset" name="" value="cancel" class="option-btn btn" id="close-form">
        </form>
        <?php 
                    }
                }
                echo "<script>document.querySelector('.update-container1').style.display='block'</script>";
            }
        ?> 

    </section>-->


    <div class="line"></div>
    <section class="update-container1">
        
        <?php
            if(isset($_GET['client'])) {
                $edit_id = $_GET['client'];
                $edit_query = mysqli_query($conn, "SELECT * FROM `client` WHERE clientID='$edit_id'")or die('query failed');
                if(mysqli_num_rows($edit_query)>0){
                    while($fetch_edit = mysqli_fetch_assoc($edit_query)){

                    
                //}
           // }
        ?>
        
        <form method="POST" enctype="multipart/form-data">
        
            <img src="img/<?php echo $fetch_edit['image']; 
                ?>
                ">
                <p>Client ID: <?php echo $fetch_edit['clientID']; ?></p>
                <h4>name: <?php echo $fetch_edit['firstName']; ?> <?php echo $fetch_edit['lastName']; ?></h4>
                <p>phone number: <?php echo $fetch_edit['phoneNumber']; ?></p>
                <details>email: <?php echo $fetch_edit['email']; ?>
                <br>gender: <?php echo $fetch_edit['gender']; ?>
                <br>address: <?php echo $fetch_edit['address']; ?> </details>
                
                <input type="reset" value="Go Back" class="option-btn btn" id="go-back" onclick="window.history.back();">

        </form>
        <?php 
                    }
                }
                echo "<script>document.querySelector('.update-container1').style.display='block'</script>";
            }
        ?> 

    </section>























    <script type="text/javascript" src="script1.js"></script>
</body>
</html>