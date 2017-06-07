<?

	require_once('class.db.php');

	$mydb = new Database();

	$mydb -> delete('customer' , 'id=14');

	$mydb -> getQuery(); // get back the query for debug
	$mydb -> numRows(); // get numrows if have for select statement
	$rs = $mydb -> getResult(); // get result from query

	print_r($rs);

?>