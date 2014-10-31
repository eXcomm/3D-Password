<?php


session_start();
if(!isset($_SESSION['student_login']) or !isset ( $_SERVER ['HTTP_REFERER'])) {
	
	header ( 'Location: ' . 'student_home.php' );
}


else{
	$user_name=$_SESSION['user_name'];
	
	$user_name=$_SESSION['user_name'];
	
	$db = mysql_connect ( 'localhost', 'root', '' );
	mysql_select_db ( 'student' );
	
	$d = 'SELECT * FROM account_info WHERE UserName="'.$_SESSION['user_name'].'"';
	//echo $d;
	$res = mysql_query ( $d );
	$row = mysql_fetch_array ( $res );
	
	
	$name=$row[0];
	
	mysql_select_db ( $user_name );
	
	$semester=$_POST['semester'];
	
	//echo $semester;
	
	$d = 'SELECT * FROM '.$semester;
	$res = mysql_query ( $d );
	
	
	
}


?>