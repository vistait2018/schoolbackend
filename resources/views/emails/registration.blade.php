<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
    <style>
        .logo {
            display: block;
            margin: 0px auto 10px;
            width: 100px;
        }

        .logo-container {
            background-color: #F9A602;
            padding: 20px 0px;
        }

        .heading {
            font-size: 24px;
            text-align: center;
            color: #ffffff;
            margin-bottom: 0px;
        }

        .container {
            position: relative;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
            border-radius: .25rem;
            max-width: 700px;
            margin: 20px auto 10px;
            width: 90%;
        }

        .content {
            padding: 2rem 0px;
            text-align: center;
            min-height: 200px;
        }

        .footer {
            border-top: 1px #dddddd solid;
            text-align: center;
            padding: 1.4rem 0px;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="logo-container">
        <img src="https://freepngimg.com/download/car%20logo/25-nissan-car-logo-png-brand-image.png" class="logo">
        <h2 class="heading">{{ $info->getTitle()}}</h2>
    </div>
    <div class="content">
        Your registered email-id is {{$user['email']}}<br>
        Your Password is {{$user['password']}}<br>
        <p>Please login and change the password.Thank you</p>

    </div>
    <div class="footer">
        Powered By Netron IT<?php date("YY") ?>
    </div>
</div>

</body>

</html>