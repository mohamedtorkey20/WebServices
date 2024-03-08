
<?php
require 'vendor/autoload.php';

$DB = new MySQLHandler();

$page = isset($_GET['page']) ? $_GET['page'] : 1; 

$limit = 5; 

$offset = ($page - 1) * $limit; 
 

if (isset($_POST['show_all'])) {
    $users=$DB->get_data(0,0);

} elseif (isset($_POST["search"])) {
    $value = $_POST["search_term"];
      $users=$DB->search_by_column('product_name', $value);
} else {
  
    $users=$DB->get_data($offset,$limit);

}

$totalPages = ceil(Items::count() / $limit); 

//-------------------REST API--------------------------------------

// Check on the method of HTTP
$method = $_SERVER['REQUEST_METHOD'];

if(Get_Info_Path())
{
    ConvertPageJson();

    if($method=== 'GET')
    {
            Get_Method();
    }elseif($method === 'POST')
    {
        Post_Method();
    }
    
    
  
}


?>

