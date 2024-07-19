<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" type="text/css" href="../../css/footer.css" />
</head>

<body class="footer--body">
    <section class="whole--wrapper">
        <div class="newsletter">
            <h1 class="subscribe-head">Subscribe to our Newsletter</h1>
            <h4>Receive email updates on new products, offers,news and services.</h4>
             <!-- <div class="subs"> -->
            <input type="text" value="" placeholder="Enter your email here" id="email--input"/>
            <input type="submit"value="SUBSCRIBE" id="subscribe" />
             <!-- </div> -->
        </div>
        <div class="container">
    
        <div class="left">
            <h1 class="left-head">About Us</h1>
            <ul>
                <li class="left--list"><i class="fa fa-map-marker"></i> Address</li>
                <li class="left--list"><i class="fa fa-phone"></i> 9860946365</li>
                <li class="left--list"><i class="fa fa-envelope"></i> prajwalbhattarai80@gmail.com</li>
            <ul>
        </div>
        <div class="middle">
            <img src="../../images/cips_logo.png" alt="cips" />
            <img src="../../images/khalti_logo_1.png" alt="khalti" />
            <img src="../../images/esewa1.png" />
            <img src="../../images/cod.jpg" class="cod" />
            <br />
            <p> Copyright ©2024 All rights reserved </p>

        </div>

        <div class="right">
            <h1 class="right-head">Categories</h1>
            <?php require_once("../../database/database_connection.php");
            $sql="SELECT *FROM category";
            $result=mysqli_query($conn,$sql);
            while($row=mysqli_fetch_array($result)){
                $catname=$row['cat_name'];
                echo"
                <li><a href='../../pages/index/all_cat.php?id=$row[cat_id]'>$catname</a></li>";
            }
            ?>
        </div>
    </section>
    </body>

</html>