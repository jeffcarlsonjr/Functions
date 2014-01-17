<?php
class CRUD{


    
    public function select($table, $where)
    {
        $sql = "SELECT * FROM $table WHERE $where ";
        $result = mysql_query($sql) or die(mysql_error());
        if(mysql_num_rows($result) === 1)
          $row = mysql_fetch_assoc ($result);
        
        return $row;
    }
    public function multiSelectNoWhere($table)
    {
        $sql = "SELECT * FROM $table";
        $result = mysql_query($sql);
        
        return $result;
    }

    public function multiSelect($table, $where)
    {
        $sql = "SELECT * FROM $table WHERE $where ";
        $result = mysql_query($sql);
        
        return $result;
    }
    public function selectOrderBy($table, $order)
    {
        $sql = "SELECT * FROM $table $order ";
        $result = mysql_query($sql);
        
        return $result;
    }
    
    public function update($data, $table, $where) {
        foreach ($data as $column => $value) {
            $sql = "UPDATE $table SET $column = $value WHERE $where";
 
            mysql_query($sql) or die(mysql_error()); 
        }
       
        return true;
    }
    
    public function insert($data, $table)
    {
           
        $columns = "";
        $value = "";
        
        foreach ($data as $column => $value)
        {
            $columns .= ($columns == "") ? "" : ", ";
            $columns .= $column;
            $values .= ($values == "") ? "" : ", ";
            $values .= $value;
        }
        
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        
        //echo $sql; die;
        mysql_query($sql) or die (mysql_error());
        
        $id = mysql_insert_id();
        $this->id = $id;
        
        return $this->id;
    }
    
    public function delete($table, $where)
    {
        $sql = "DELETE FROM $table WHERE $where";
        
        echo $sql;
        mysql_query($sql) or die(mysql_error());
        
        return true;
    }
}
?>
