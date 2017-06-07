<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


class Database{
	private $server = 'localhost';
	private $username = 'root';	
	private $password = 'root';
	private $dbname = 'nodejs-crud';
	public $conn;

	private $result = "";
	private $numRows = "";
	private $query = "";

	function __construct(){
		$this->conn = new mysqli($this->server , $this->username , $this->password , $this->dbname);
		if($this->conn->connect_error){
			//echo 'fail';
			die("connection failed" . $this->conn->connect_error);
		}else{
			//echo "connect success";
		}
	}

	public function commit(){
		mysqli_commit($this->conn);
	}

	public function rollback(){
		mysqli_rollback($this->conn);
	}

	public function sql($query , $result = false){
		$this->query = $query;
		$result = $this->conn->query($query); 
		$this->result = $result;
		return true;
	}

	public function select($table , $arrRows = '*' , $where = null , $order = null , $limit = null){
		if($this->tableExists($table)){
			if($arrRows != '*'){
				$rows = implode (", ", $arrRows);
				$query = "SELECT $rows FROM $table";
			}else{
				$query = "SELECT $arrRows FROM $table";
			}

			if($where != null){
				$query .= ' WHERE ' . $where; 
			}		

			if($order != null){
				$query .= ' ORDER BY ' . $order;
			}

			if($limit != null){
				$query .= ' LIMIT ' . $limit;
			}

			$this->query = $query;
			$result = $this->conn->query($query); 
			$this->result = $result;
			return true;		
		}else{
			return false; // Table does not exist
		}
		
	}

	public function insert($table , $arrToInsert){
		if($this->tableExists($table)){
			$this->query = $query = "INSERT INTO $table (`".implode("`, `" , array_keys($arrToInsert))."`) VALUES ('".implode("', '" , $arrToInsert)."')";
			if($this->conn->query($query) == TRUE){
				$this->result = true;
				return true;
			}else{
				$this->result = false;
				return false;
				die();
			}
		}else{
			return false; // Table does not exist
		}
	}

	public function update($table , $arrToUpdate , $where){
		if($this->tableExists($table)){
			$pairValue = array();
			foreach($arrToUpdate as $field => $value){
				$pairValue[] = "`$field`" . ' = '. "'$value'";
			}

			$this->query = $query = "UPDATE $table  SET ".implode(", " , $pairValue)." WHERE $where";
			$this->conn->query($query);
			if(mysqli_affected_rows($this->conn) >= 0){
				$this->result = true;
				return true;
			}else{
				$this->result = false;
				return false;
			}
		}else{
			return false; // Table does not exist
		}
	}

	public function delete($table , $where){
		if($this->tableExists($table)){
				$this->query = $query = 'DELETE FROM '.$table.' WHERE '.$where;
				if($this->conn->query($query) == true){
					$this->result = true;
					return true;
				}else{
					$this->result = false;
					return false;
				}	
		}else{
			return false; // Table does not exist
		}
	}

	private function tableExists($table){
		$sql = 'SHOW TABLES FROM `'.$this->dbname.'` LIKE "'.$table.'"';
		$tablesInDb = $this->conn->query($sql);
        if($tablesInDb){
        	if($tablesInDb->num_rows == 1){
                return true; // The table exists
            }else{
            	$this->result = $table." does not exist in this database";
                return false; // The table does not exist
            }
        }
    }

    public function numRows(){
    	if(is_array($this->result)){ //if result having array result
	    	return $this->result->num_rows;
    	}else{
	    	return false;
    	}
    }

    public function getQuery(){ // for check query
    	print_r($this->query);
    	return $this->query;
    }

    public function getResult(){
       return $this->result;
    }
}


$mydb = new Database();

$arrInsert = array('name'=>'test' , 'address'=>'123' , 'email'=>'test@gmail.com');
$arrSelect = array('field1','field2');
$arrUpdate = array('name'=>'9999' , 'address'=>'999');


//$mydb -> insert('customer' , $arrInsert);
//$mydb -> select('customer');
// $mydb -> sql('select * from customer' ,true);

//$mydb -> update('customer' , $arrUpdate , 'id=11');
$mydb -> delete('customer' , 'id=14');

$mydb -> getQuery();
$mydb -> numRows();
$rs = $mydb -> getResult();
print_r($rs);

?>