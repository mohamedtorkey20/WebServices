<?php


require 'vendor/autoload.php';
$DB = new MySQLHandler();

$productCodeErr = $productNameErr = $listPriceErr = $reorderLevelErr = $unitsInStockErr = $countryErr = $ratingErr = $dateErr = $discontinuedErr = $categoryErr = $photoErr = "";

$productCode = $productName = $listPrice = $reorderLevel = $unitsInStock = $country = $rating = $date = $discontinued = $category = "";
$count_vaild_feilds=0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate ID
    

    // Validate Product Code
    if (empty($_POST["PRODUCT_code"])) {
        $productCodeErr = "Product Code is required";
    } else {
        $productCode = test_input($_POST["PRODUCT_code"]);
        $count_vaild_feilds+=1;
    }

    // Validate Product Name
    if (empty($_POST["product_name"])) {
        $productNameErr = "Product Name is required";
    } else {
        $productName = test_input($_POST["product_name"]);
        $count_vaild_feilds+=1;
    }

    // Validate List Price
    if (empty($_POST["list_price"])) {
        $listPriceErr = "List Price is required";
    } else {
        $listPrice = test_input($_POST["list_price"]);
        // Check if List Price is numeric
        if (!is_numeric($listPrice)) {
            $listPriceErr = "List Price must be a number";
        }else{
            $count_vaild_feilds+=1;
        }
    }

    // Validate Reorder Level
    if (empty($_POST["reorder_level"])) {
        $reorderLevelErr = "Reorder Level is required";
    } else {
        $reorderLevel = test_input($_POST["reorder_level"]);
        // Check if Reorder Level is numeric
        if (!is_numeric($reorderLevel)) {
            $reorderLevelErr = "Reorder Level must be a number";
        }else{
            $count_vaild_feilds+=1;
        }
    }

    // Validate Units in Stock
    if (empty($_POST["units_in_stock"])) {
        $unitsInStockErr = "Units in Stock is required";
    } else {
        $unitsInStock = test_input($_POST["units_in_stock"]);
        // Check if Units in Stock is numeric
        if (!is_numeric($unitsInStock)) {
            $unitsInStockErr = "Units in Stock must be a number";
        }else{
            $count_vaild_feilds+=1;
        }
    }

    // Validate Country
    if (empty($_POST["country"])) {
        $countryErr = "Country is required";
    } else {
        $country = test_input($_POST["country"]);
        $count_vaild_feilds+=1;
    }

    // Validate Rating
    if (empty($_POST["rating"])) {
        $ratingErr = "Rating is required";
    } else {
        $rating = test_input($_POST["rating"]);
        $count_vaild_feilds+=1;
    }

    // Validate Date
    if (empty($_POST["date"])) {
        $dateErr = "Date is required";
    } else {
        $date = test_input($_POST["date"]);
        $count_vaild_feilds+=1;
    }

    // Validate Discontinued
    if (empty($_POST["discontinued"])) {
        $discontinuedErr = "Discontinued is required";
    } else {
        
        $count_vaild_feilds+=1;
    }

    // Validate Category
    if (empty($_POST["category"])) {
        $categoryErr = "Category is required";
    } else {
        $category = test_input($_POST["category"]);
        $count_vaild_feilds+=1;

    }

    // Handle file upload
if (!empty($_FILES["photo"]["name"])) {
    $target_dir = "Database/images/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
   
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    
    if ($check === false) {
        $photoErr = "File is not an image.";
    } elseif ($_FILES["photo"]["size"] > 500000) { // Check file size (500KB)
        $photoErr = "Sorry, your file is too large.";
    } elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $photoErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    } elseif (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        // File uploaded successfully
        $photo = basename($_FILES["photo"]["name"]);
       
        $count_vaild_feilds+=1;

    } else {
        $photoErr = "Sorry, there was an error uploading your file.";
    }
}
}

// Function to sanitize input data
function test_input($data) {
       $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



if($count_vaild_feilds==11)
{
    $valid_input = array(
       'PRODUCT_code'=>$productCode,
       'product_name'=>$productName,
        'Photo'=>$photo,
        'list_price'=> $listPrice,
      'reorder_level'=>$reorderLevel,
       'Units_In_Stock'=> $unitsInStock,
       'category'=>$category,
       'CouNtry'=>$country,
      'Rating'=>$rating,
       'discontinued'=>$discontinued,
       'date'=>$date,
        
    );
    
    $result=$DB->add_glass($valid_input);
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data items</title>
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
            <div class="col-md-6 text-center mt-5 mb-5">
                <h2 class="heading-section">Data item</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mt-5 ">
                <h2 class="heading-section"><?= isset($result)?  $result: '' ?></h2>
            </div>
        </div>
        <div class="row bg-dark">
            <div class="col-12 col-md-6 col-lg-3 offset-2 mb-5">
                <form  method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="PRODUCT_code">Product Code</label>
                        <input type="text" class="form-control" id="PRODUCT_code" name="PRODUCT_code" placeholder="Product Code">
                        <?php if (!empty($productCodeErr)) echo "<p class='text-danger'>$productCodeErr</p>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name">
                        <?php if (!empty($productNameErr)) echo "<p class='text-danger'>$productNameErr</p>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo (e.g., img.png)</label>
                        <input type="file" class="form-control" id="photo" name="photo" placeholder="Photo">
                        <?php if (!empty($photoErr)) echo "<p class='text-danger'>$photoErr</p>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="list_price">List Price</label>
                        <input type="text" class="form-control" id="list_price" name="list_price" placeholder="List Price">
                        <?php if (!empty($listPriceErr)) echo "<p class='text-danger'>$listPriceErr</p>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="reorder_level">Reorder Level</label>
                        <input type="text" class="form-control" id="reorder_level" name="reorder_level" placeholder="Reorder Level">
                        <?php if (!empty($reorderLevelErr)) echo "<p class='text-danger'>$reorderLevelErr</p>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="units_in_stock">Units in Stock</label>
                        <input type="text" class="form-control" id="units_in_stock" name="units_in_stock" placeholder="Units in Stock">
                        <?php if (!empty($unitsInStockErr)) echo "<p class='text-danger'>$unitsInStockErr</p>"; ?>
                    </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 offset-2">
                    
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" class="form-control" id="country" name="country" placeholder="Country">
                        <?php if (!empty($countryErr)) echo "<p class='text-danger'>$countryErr</p>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <input type="text" class="form-control" id="rating" name="rating" placeholder="Rating">
                        <?php if (!empty($ratingErr)) echo "<p class='text-danger'>$ratingErr</p>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="text" class="form-control" id="date" name="date" placeholder="Date">
                        <?php if (!empty($dateErr)) echo "<p class='text-danger'>$dateErr</p>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="discontinued">Discontinued</label>
                        <input type="text" class="form-control" id="discontinued" name="discontinued" placeholder="Discontinued">
                        <?php if (!empty($discontinuedErr)) echo "<p class='text-danger'>$discontinuedErr</p>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category">
                            <option value="sunglasses">Sunglasses</option>
                            <option value="Kontrollkästchen einzuschließen">Kontrollkästchen einzuschließen</option>
                            <?php if (!empty($categoryErr)) echo "<p class='text-danger'>$categoryErr</p>"; ?>
                    </select>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary"  name="submit_add" value="Add Now">
                    </div>
                </div>
            </div>
            </form>
        </div>
   </div>
</div>

</body>
</html>
