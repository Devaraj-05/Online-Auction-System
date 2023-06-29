<?php
session_start();
ini_set('display_errors', 0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online Auction System</title>
    <link rel="stylesheet" type="text/css" href="./resources/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./resources/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
		integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="./index.php">
            <strong>Online Auction System</strong>
        </a>
        <div>
            <a href="./auction.php" class="text-white mx-1 font-weight-bold">Post an auction</a>
            <?php if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true):?>
            <a href="./profile.php" class="text-white mx-1 font-weight-bold">Profile</a>
            <a href="./logout.php" class="text-white mx-1 font-weight-bold">Logout</a>
            <?php else:?>
            <a href="./login.php" class="text-white mx-1 font-weight-bold">Signin</a>
            <a href="./register.php" class="text-white mx-1 font-weight-bold">Signup</a>
            <?php endif?>
            
        </div>
    </nav>
