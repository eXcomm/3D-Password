<?php
session_start ();

$values = array ();

if ((isset ( $_SESSION ['student_login'] ) and isset ( $_SERVER ['HTTP_REFERER'] )) or (isset ( $_SESSION ['teacher_login'] ) and isset ( $_SERVER ['HTTP_REFERER'] ))) {
	
	foreach ( $_POST as $key => $value ) {
		$tmp = is_array ( $value ) ? $value : trim ( $value );
		if (empty ( $tmp )) {
			$missing [] = $key;
			$$key = '';
			$correction_required = true;
		} else {
			$$key = $tmp;
			array_push ( $values, $tmp );
		}
	}
	array_pop ( $values ); /*
	                     * foreach ($values as $value){ echo $value; }
	                     */
	
	$semester = $_SESSION ['semester'];
	unset ( $_SESSION ['semester'] );
	
	$user_name = $_SESSION ['user_name'];
	
	if (isset ( $_SESSION ['stude_user_name'] )) {
		
		$stude_user_name = $_SESSION ['stude_user_name'];
	}
	
	$db = mysql_connect ( 'localhost', 'root', '' );
	
	if (isset ( $_SESSION ['teacher_login'] )) {
		mysql_select_db ( $stude_user_name );
	} else {
		mysql_select_db ( $user_name );
	}
	
	if ($semester == 'One and Two Semesters') {
		$d = 's1s2';
	}
	
	if ($semester == 'Third Semester') {
		$d = 's3';
	}
	
	if ($semester == 'Fourth Semester') {
		$d = 's4';
	}
	
	if ($semester == 'Fifth Semester') {
		$d = 's5';
	}
	
	if ($semester == 'Sixth Semester') {
		$d = 's6';
	}
	
	if ($semester == 'Seventh Semester') {
		$d = 's7';
	}
	
	if ($semester == 'Eighth Semester') {
		$d = 's8';
	}
	
	$qu = 'SELECT * FROM ' . $d;
	
	// echo $qu;
	
	$res = mysql_query ( $qu );
	
	$i = 0;
	
	while ( $row = mysql_fetch_array ( $res ) ) {
		
		$tt = '';
		
		if (! isset ( $values [$i] )) {
			$values [$i] = 0;
		}
		
		$tt .= 'UPDATE ' . $d . ' SET yourMark=' . $values [$i] . ' WHERE subjCode="' . $row [0] . '"';
		
		// echo $tt;
		
		// echo $values[$i];
		
		mysql_query ( $tt );
		
		$i = $i + 1;
	}
	mysql_close ();
	
	if (isset ( $_SESSION ['teacher_login'] )) {
		header ( 'Location: ' . 'teacher_home.php' );
	} else {
		$_SESSION ['new_data_entry'] = True;
		header ( 'Location: ' . 'student_home.php' );
	}
} 

else {
	
	header ( 'Location: ' . 'student_home.php' );
}
?>