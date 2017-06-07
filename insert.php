<?

require_once('class.db.php');

$mydb = new Database();

$arrInsert = array('name'=>'test' , 'address'=>'123' , 'email'=>'test@gmail.com');

$mydb -> insert('customer' , $arrInsert);

$mydb -> getQuery(); // get back the query for debug
$mydb -> numRows(); // get numrows if have for select statement
$rs = $mydb -> getResult(); // get result from query

print_r($rs);

?>