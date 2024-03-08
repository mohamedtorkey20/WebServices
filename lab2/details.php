<?php

require_once 'vendor/autoload.php';


$DB = new MySQLHandler();

 $users=$DB->get_record_by_id('id',$_GET['id']);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
    <link rel="stylesheet" href="views/bootstrap-5.3.3-dist/css/bootstrap.css">
    <style>
        body {
            font-family: "Poppins", Arial, sans-serif;
            font-size: 16px;
            line-height: 1.8;
            font-weight: normal;
            background: #2b3035; /* Background color */
            color: gray;
        }
        
    </style>
</head>
<body>
    <div class="container">
    <div class="row justify-content-center">
                <div class="col-md-6 mt-5 offset-3">
                    <h3 class="heading-section">item Details</h3>
                </div>
            </div>
        <div class="row">
            <div class="col-md-12 col-lg-9 offset-1 mt-5">
                <div class="card item-details  text-center w-lg-40 p-3">
                         <h4>Type:<?=$users[0]->product_name?></h4>
                         <div class="row">
                            <div class="col-12 col-lg-6">
                             <img  src="Database/images/<?=$users[0]->Photo?>" alt="imag" width="300">
                            </div>
                            <div class="col-12 col-lg-6 mt-5">
                                <h5>Details</h5>
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <p>Code:<?=$users[0]->PRODUCT_code?></p>
                                        <p>Item ID:<?=$users[0]->id?></p>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <p>Price:<?=$users[0]->list_price?></p>
                                        <p>Rating:<?=$users[0]->Rating?></p>
                                    </div>
                                </div>
                            </div>
                            
                         </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

