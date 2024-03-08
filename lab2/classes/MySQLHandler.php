<?php

use Illuminate\Database\Capsule\Manager as Capsule;


class MySQLHandler implements DbHandler {

     private $capsule; 
     

     function  __construct()
     {
        $this->capsule = new Capsule;
           $this->connect();
     }

    public function connect(){
     
        try {
          
            $this->capsule->addConnection([
                "driver" => "mysql",
                "host" => __HOST__,
                "database" => __DB__,
                "username" => __USERNAME__,
                "password" => __PASSWORD__
            ]);
            $this->capsule->setAsGlobal();
            $this->capsule->bootEloquent();
        } catch (Exception $ex) {
            error_log("connection of database error" . $ex->getMessage());
        }
    }

    public function disconnect(){
        try {
                $this->capsule->getConnection()->disconnect();
          }catch(Exception $ex)
          {
            error_log("diconnection of database error" . $ex->getMessage());
          }
    }
    
    public function get_data($start = 0,$take=5,$fields = array() ){

    
         if(empty($fields) & $start===0 & $take===5)
         {
            return Items::take($take)->get();
         }elseif(empty($fields) & $take===0){
            return Items::get();
         }else
         {
         return Items::skip($start)->take($take)->get();
         }
    }


    public function get_record_by_id($id, $primary_key){

       return Items::where($id,$primary_key)->get();
    }


    public function search_by_column($name_column, $value){

       return  Items::where($name_column, 'LIKE', '%' . $value . '%')->get();
    }


    public function add_glass($details = [])
    {
       
    // Insert the user data into the 'users' table
      $success = Items::insert($details);
    
    if ($success) {
        return "User added successfully";
    } else {
        return false;
    }
    }



    
}




?>