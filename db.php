<?php
class db{
    private $sql;
    private $connection;
    public function __construct($db_server, $db_username, $db_pass, $db_name){
        $this->connection = mysqli_connect($db_server, $db_username, $db_pass, $db_name);
    }
    public function insert($table,$data){
        $keys = array_keys($data);
        $keys = implode(',',$keys);
        $values = array_values($data);
        $values = implode(',',$values);
        $values = '';
        foreach($data as $value){ $values .= "'$value',"; }
        $values = rtrim($values,',');
        $this->sql = "INSERT INTO `$table` ($keys) VALUES ($values)";
        return $this;
    }
    public function select($table, $columns){
        $this->sql = "SELECT $columns FROM `$table`";
        return $this;
    }
    public function update($table,$data){
        $updateData = "";
        foreach($data as $key => $value){
            $updateData .= "`$key` = '$value',";
        }
        $updateData = rtrim($updateData,',');
        $this->sql = "UPDATE `$table` SET $updateData";
        return $this;
    }
    public function delete($table){
        $this->sql = "DELETE FROM `$table`";
        return $this;
    }
    public function where($column, $operator, $value){
        $this->sql .= " WHERE `$column` $operator '$value'";
        return $this;
    }
    public function join($join,$table,$pk,$fk){
        $this->sql .= " $join join `$table` ON $pk = $fk";
        return $this;
    }
    public function andWhere($column, $operator, $value){
        $this->sql .= " AND `$column` $operator '$value'";
        return $this;
    }
    public function orWhere($column, $operator, $value){
        $this->sql .= " OR `$column` $operator '$value'";
        return $this;
    }
    public function first(){
        $query = mysqli_query($this->connection,$this->sql);
        return mysqli_fetch_assoc($query);
    }
    public function all(){
        $query = mysqli_query($this->connection,$this->sql);
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
    public function excute(){
        mysqli_query($this->connection, $this->sql);
        return mysqli_affected_rows($this->connection);
    }
}
