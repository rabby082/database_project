<?php
     include 'connection.php';

     if(isset($_POST['submit-btn'])){
        $filter_nid = filter_var($_POST['nid'], FILTER_SANITIZE_STRING);
        $nid= mysqli_real_escape_string($conn, $filter_nid);

        $filter_fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
        $fname= mysqli_real_escape_string($conn, $filter_fname);

        $filter_lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
        $lname= mysqli_real_escape_string($conn, $filter_lname);

        $filter_pnumber = filter_var($_POST['pnumber'], FILTER_SANITIZE_STRING);
        $pnumber= mysqli_real_escape_string($conn, $filter_pnumber);

        $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $email= mysqli_real_escape_string($conn, $filter_email);

        $filter_dob = filter_var($_POST['dob'], FILTER_SANITIZE_STRING);
        $dob= mysqli_real_escape_string($conn, $filter_dob);

        $filter_gender = filter_var($_POST['gender'], FILTER_SANITIZE_STRING);
        $gender= mysqli_real_escape_string($conn, $filter_gender);

        $filter_address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
        $address= mysqli_real_escape_string($conn, $filter_address);

        $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $password= mysqli_real_escape_string($conn, $filter_password);


        $filter_cpassword = filter_var($_POST['cpassword'], FILTER_SANITIZE_STRING);
        $cpassword= mysqli_real_escape_string($conn, $filter_cpassword);

        /*$select_user = mysqli_query($conn, "SELECT * FROM 'users' WHERE email = '$email'") or die('die Asik');*/
        $select_user = mysqli_query($conn, "SELECT * FROM `employee` WHERE email = '$email'") or die('die Asik1');

        if(mysqli_num_rows($select_user)>0){
            $message[] = 'Employee already exist';
        }else{
            if($password != $cpassword){
                $message[] = 'password and re-password are not same';
            }else{
                /*mysqli_query($conn, "INSERT INTO 'users'('name','email','password')VALUES('$name','$email','$password')") or die('query failed');*/
                
                mysqli_query($conn, "INSERT INTO `employee`(`nidNumber`,`firstName`,`lastName`,`phoneNumber`,`email`,`dob`,`gender`,`address`,`password`)
                VALUES('$nid','$fname','$lname','$pnumber','$email','$dob','$gender','$address','$password')") or die('query failed');
                $message[] ='registed successfully';
                header('location:login.php');
            }
        }
     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!---box icon link--->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>Register Page</title>
</head>
<body>
    

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
        <form method="post">
            <h1>register now</h1>
            <input type="text" name="fname" placeholder="enter your first name" required>
            <input type="text" name="lname" placeholder="enter your last name" required>
            <input type="text" name="pnumber" placeholder="enter your phone number" required>
            <input type="text" name="nid" placeholder="enter your nid number" required>
            <input type="email" name="email" placeholder="enter your email" required>
            <input type="date" name="dob" placeholder="Enter your date of birth" required>
            <select class="form-container9" name="gender" required>
                <option value="" disabled selected hidden>Select your gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <input type="text" name="address" placeholder="enter your address" required>
            <input type="password" name="password" placeholder="enter your password" required>
            <input type="password" name="cpassword" placeholder="confirm your password" required>
            <input type="submit" name="submit-btn" value="register now" class="btn">
            <p>already have an account ? <a href="login.php">login now</p>
        </form>

    </section>
</body>
</html>