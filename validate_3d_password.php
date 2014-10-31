<?php
session_start();
$user_name=$_SESSION['user_name'];


$password1=$_POST['password'];

echo $password1;



$db = mysql_connect ( 'localhost', 'root', '' );
mysql_select_db ( 'student' );

$d = 'SELECT * FROM account_info';
$res = mysql_query ( $d );




while ( $row = mysql_fetch_array ( $res ) ) {

	if (strcmp ( $user_name, $row [8] ) == 0) {
		$name=$row[0];
		$salt=$row[12];
		$original_password=$row[11];
	}
}

$new_password = $password1 . $salt;
$password = md5 ( $new_password );

if(strcmp ( $password, $original_password ) == 0){
	
	if(isset($_SESSION['can_change_passwd'])){
		unset($_SESSION['can_change_passwd']);
		$_SESSION['can_reset_password'] = true;
	
		header ( 'Location: ' . 'change_student_password.php' );
	}
	
	else{
	
		session_destroy();
		session_start();
		$_SESSION['student_login']=true;
		
		$_SESSION['user_name']=$user_name;
		
		header ( 'Location: ' . 'student_home.php' );
	}
}

//else{
	
//}

else{

	if(isset($_SESSION['attempt_count'])&&$_SESSION['attempt_count']==3){
		unset($_SESSION['attempt_count']);
		if(isset($_SESSION['user_name_correction'])){
			unset($_SESSION['user_name_correction']);
		}
		if(isset($_SESSION['user_name'])){
			if(isset($_SESSION['student_login'])){
				unset($_SESSION['can_change_passwd']);
			}
			else{
				unset($_SESSION['user_name']);
			}
			
		}
		header ( 'Location: ' . 'home.php' );
	}
	else{
		if(isset($_SESSION['user_name_correction'])){
			unset($_SESSION['user_name_correction']);
		}
		if(!isset($_SESSION['attempt_count'])){
			$_SESSION['attempt_count']=1;
		}
		else {
			$_SESSION['attempt_count']=$_SESSION['attempt_count']+1;
		}
		header ( 'Location: ' . 'check_student_login.php' );
	}
	

}



?>