<?php
interface DbHandler {
    public function connect();
    public function disconnect();   
    public function get_data($start = 0 , $take=0,$fields = array());
    public function get_record_by_id($id, $primary_key);
    public function search_by_column($name_column, $value);
    public function add_glass($details=[]);

}