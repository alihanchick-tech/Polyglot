<?php
    
    require_once("database/connect.php");
    require_once("functions.php");
    
    class DataClass
    {
        
        public function sanitize($data)
        {
            global $database;
            
            return htmlentities(strip_tags(mysqli_real_escape_string($database->db_connect, $data)));
        }
        
        public function data_exists($table, $data_key, $data_val)
        {
            global $database;
            
            $data_val = $this->sanitize($data_val);
            
            $query = "SELECT * FROM $table WHERE $data_key='$data_val'";
            
            if($query_run = mysqli_query($database->db_connect, $query))
            {
                if(mysqli_num_rows($query_run) == NULL)
                {
                    return false;
                } else
                {
                    return true;
                }
            }
        }
        
        public function add_data($table, $add_data)
        {
            global $database;
            
            foreach($add_data as $key => $val)
            {
                // $array_data[$key] = $this->sanitize($val);
                $array_data[$key] = $val;
            }
            
            $fields = implode(', ', array_keys($array_data));
            $values = "'" . implode("', '", array_values($array_data)) . "'";
            die($query);
            $query = "INSERT INTO $table ($fields) VALUES ($values)";
            
            mysqli_query($database->db_connect, $query);
        }
        
        function get_last_data_id()
        {
            global $database;
            
            return mysqli_insert_id($database->db_connect);
        }
        
        public function get_data($table, $data_key = null, $data_val = null)
        {
            global $database;
            $array_data = array();
            
            $query = "SELECT * FROM $table";
            
            if(!empty($data_key) && !empty($data_val))
            {
                $query .= " WHERE $data_key='$data_val'";
            }

            if($query_run = mysqli_query($database->db_connect, $query))
            {
                while($data = mysqli_fetch_assoc($query_run))
                {
                    $array_data[] = $data;
                }
            }
            
            return $array_data;
            
        }
        
        public function get_data_2_key($table, $data_key1, $data_val1, $data_key2, $data_val2)
        {
            global $database;
            $array_data = array();
            
            $data_val1 = $this->sanitize($data_val1);
            $data_val2 = $this->sanitize($data_val2);
            
            $query = "SELECT * FROM $table WHERE $data_key1='$data_val1' AND $data_key2='$data_val2'";
            
            if($query_run = mysqli_query($database->db_connect, $query))
            {
                while($data = mysqli_fetch_assoc($query_run))
                {
                    $array_data[] = $data;
                }
            }
            
            return $array_data;
        }
        
        public function get_data_2_val($table, $data_key, $data_val1, $data_val2)
        {
            global $database;
            $array_data = array();
            
            $query = "SELECT * FROM $table WHERE $data_key BETWEEN '$data_val1' AND '$data_val2'";
            
            if($query_run = mysqli_query($database->db_connect, $query))
            {
                while($data = mysqli_fetch_assoc($query_run))
                {
                    $array_data[] = $data;
                }
            }
            
            return $array_data;
        }
        
        public function sort_data($table, $data_key, $sort_type)
        {
            global $database;
            $array_data = array();
            
            $query = "SELECT * FROM $table ORDER BY $data_key $sort_type";
            
            if($query_run = mysqli_query($database->db_connect, $query))
            {
                while($data = mysqli_fetch_assoc($query_run))
                {
                    $array_data[] = $data;
                }
            }
            
            return $array_data;
            
        }
        
        public function search_data($table, $data_key, $data_val)
        {
            global $database;
            $array_data = array();
            
            $query = "SELECT * FROM $table WHERE $data_key LIKE '%$data_val%'";
            
            if($query_run = mysqli_query($database->db_connect, $query))
            {
                while($data = mysqli_fetch_assoc($query_run))
                {
                    $array_data[] = $data;
                }
            }
            
            return $array_data;
            
        }
        
        public function delete_data($table, $data_key, $data_val)
        {
            global $database;
            
            $data_val = $this->sanitize($data_val);
            
            $query = "DELETE FROM $table WHERE $data_key='$data_val'";
            
            mysqli_query($database->db_connect, $query);
        }
        
        public function update_data($table, $upd_data, $data_key, $data_val)
        {
            global $database;
            
            $data_val = $this->sanitize($data_val);
            
            foreach($upd_data as $key=>$val)
            {
                // $array_data[] = $key . "='" . $this->sanitize($val) . "'";
                $array_data[] = $key . "='" . $val . "'";
            }
            
            $query = "UPDATE $table SET " . implode(', ', $array_data) . " WHERE $data_key='$data_val'";
            
            mysqli_query($database->db_connect, $query);
        }
        
    }
    
    $data_class = new DataClass();
    
?>