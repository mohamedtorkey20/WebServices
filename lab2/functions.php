<?php
require 'vendor/autoload.php';
 

//------------------------Get informaiton about Path--------------------------------
function Get_Info_Path()
{
    $pathInfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    if($pathInfo!==''){
        
        $segments = explode('/', trim($pathInfo, '/'));

        if(count($segments)>=1){
            return $segments;
        }else{
            return null;
        }

    }


}


//--------------------------------Get Method Handler--------------------------------------
function Get_Method()
{
    $DB = new MySQLHandler();

    $resurces=Get_Info_Path();
    $productId =is_numeric($resurces[1])?  $resurces[1] : null;
     if($productId)
     {
    
        $product = $DB->get_record_by_id("id", $productId);
              
            if (count($product)>0) {
                echo json_encode($product);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Resource doesn't exist"]);
            }

          
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Invalid request"]);
        }
}


//------------------------Post Method Handler-----------------------------------------
function Post_Method()
{
    $DB = new MySQLHandler();
    $data = json_decode(file_get_contents('php://input'), true);
    if(!$data) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid request"]);
       
    }
    
    $fields = ['PRODUCT_code', 'product_name', 'Photo', 'list_price', 'reorder_level', 'Units_In_Stock', 'category', 'CouNtry', 'Rating', 'discontinued', 'date'];
    $missing_fields = [];

    foreach ($fields as $field) {
        if (!isset($data[0][$field])) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        http_response_code(400);
        echo json_encode(["error" => "Missing fields: " . implode(', ', $missing_fields)]);
        
    }

    $success = $DB->add_glass($data);
    if (!$success) {
        http_response_code(201);
        echo json_encode(["message" => "Product created successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to create product"]);
    }
}



function ConvertPageJson()
{
    header('Content-Type: application/json');
}

?>

