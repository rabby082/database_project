<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!---box icon link--->
        <link rel="stylesheet": href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Document</title>
</head>
<body>
    <header class="header">
        <div class="flex">
            <a href="employee_panel.php" class="logo"><img src="img/c6.png"></a>
            <!--<a href="admin_panel.php" class="logo"><img src="img/9.png"></a>-->
            <nav class="navbar">
                <a href="employee_panel.php">home</a>
                <a href="client.php">create client</a>
                <a href="deals.php">deals</a>
                <a href="product_info.php">product info</a>
                <a href="order_status.php">order status</a>
                <a href="payment.php">payment</a>
            </nav>
            <div class="icons">
                <i class="bi bi-person" id="user-btn"></i>
                <i class="bi bi-list" id="menu-btn"></i>
            </div>
            <div class="user-box">
                <p>Username : <span><?php echo $_SESSION['employee_name']; ?></span></p>
                <p>Email : <span><?php echo $_SESSION['employee_email']; ?></span></p>
                <form method="post">
                    <button type="submit" name="logout" class="logout-btn">log out</button>
                </form>
            </div>
        </div>
    </header>
    <div class="banner">
        <div class="detail">
            <h1>employee dashboard</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed eiusmod tempor.</p>
        </div>
    </div>
    <div class="line"></div>

    <script type="text/javascript" src="script1.js"></script>

</body>
</html>