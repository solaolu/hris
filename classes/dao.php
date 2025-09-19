<?php

class DAO
{
    
    public $connection;
    public $result;
    
    public function __construct(){
        $this->connection = mysqli_connect("127.0.0.1:54294", "root", "C0mplex!tyiskey", "hrisdb");
        $this->result=3;
    }
    
    public function connect(){
        return $this->connection;
    }
    
    public function connectPublic(){
        $this->connection = mysqli_connect("127.0.0.1:54294", "root", "C0mplex!tyiskey", "hrisdb");
    }
    
    public function execute($sql){
        $cn = $this->connection;
        $result = mysqli_query($cn, $sql); //or die(mysqli_error($cn)); 
        return $result;
    }
    
    public function getData($sql){
        $res = $this->execute($sql);
        $result = $res->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    
    public function executeJSON($sql){
        $res = $this->execute($sql);
        $json_array = array();
        while ($row = mysqli_fetch_assoc($res)){
            $json_array[] = $row; 
        }

        return json_encode($json_array);
    }
    
    public function insert($table, $obj){
        
        $sourceReflection = new ReflectionObject($obj);
        $sourceProperties = $sourceReflection->getProperties();
        $sql="";
        $sqlvalues="";
            foreach ($sourceProperties as $sourceProperty) {
                $sourceProperty->setAccessible(true);
                $name = $sourceProperty->getName();
                $value = $sourceProperty->getValue($obj);
                
                if (is_array($value)) {
                    $value = implode(",", addslashes($value));
                }
                //$$name=$value;

                $sql.="`$name`, ";
                $sqlvalues .="'".addslashes($value)."', ";
            }
        
        $sql=trim($sql, ", ");
        $sqlvalues=trim($sqlvalues, ", ");

        $query = "insert into $table ($sql) values ($sqlvalues)";
        $res = $this->execute($query);
        $id = mysqli_insert_id($this->connection);
        return $id;
    }
    
    public function update($table, $obj, $key){
        //$val = $obj->{$key};
        //unset($obj->{$key}); //remove primaryKey from update details
        
        $sourceReflection = new ReflectionObject($obj);
        $sourceProperties = $sourceReflection->getProperties();
        $sql="";
        $sqlvalues="";
            foreach ($sourceProperties as $sourceProperty) {
                $sourceProperty->setAccessible(true);
                $name = $sourceProperty->getName();
                $value = $sourceProperty->getValue($obj);
                
                if (is_array($value)) {
                    $value = implode(",", addslashes($value));
                }
                //$$name=$value;

                //$sql.="`$name`, ";
                $sqlvalues .="$name='".addslashes($value)."', ";
            }
        
        //$sql=trim($sql, ", ");
        $sqlvalues=trim($sqlvalues, ", ");

        $query = "update $table set $sqlvalues where $key";
        $res = $this->execute($query);
        return $res;
    }
    
    public function getLastInsertID(){
        return mysqli_insert_id($this->connection);
    }
}


?>