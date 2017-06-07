<?

	require_once('class.db.php');

	$mydb = new Database();

	$arrUpdate = array('name'=>'9999' , 'address'=>'999');

	$mydb -> update('customer' , $arrUpdate , 'id=11');
	$mydb -> getQuery(); // get back the query for debug
	$mydb -> numRows(); // get numrows if have for select statement
	$rs = $mydb -> getResult(); // get result from query

	print_r($rs);

?>