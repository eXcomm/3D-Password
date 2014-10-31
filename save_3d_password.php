<?php
session_start();
$user_name=$_SESSION['user_name'];

$name=$_SESSION['name'];

//echo $_POST['password'];

$password1=$_POST['password'];

//echo $password1;

//$password="";

//$i=0;

//$password = explode("+",$password1);


/*
foreach ($password as $i){
	echo $i;
	echo "<br/>";
}

*/
/*
foreach($password1 as $i){
	
	echo $i;
	
	$password=$password.$i;
	
	//$i=$i+1;
	
	
}
*/


//$d=UPDATE account_info SET 3D_Password="DD",Salt="ff" WHERE UserName="ss";

$salt = openssl_random_pseudo_bytes ( 6 );
$new_password = $password1 . $salt;
$password = md5 ( $new_password );



$db = mysql_connect ( 'localhost', 'root', '' );
mysql_select_db ( 'student' );

$q = sprintf ( "UPDATE account_info SET 3D_Password='%s',Salt='%s' WHERE UserName='%s'", $password,$salt,$user_name);

//echo $q;

$t=mysql_query ( $q );


mysql_close ();
unset($_SESSION['name']);
if(!isset($_SESSION['student_login'])){
	unset($_SESSION['user_name']);
}



if(isset($_SESSION['can_reset_password'])){
	

	$db = mysql_connect ( 'localhost', 'root', '' );
	mysql_select_db ( 'student' );
	
	$q = sprintf ( "SELECT Name FROM account_info WHERE UserName='%s'", $user_name);
	
	$t=mysql_query ( $q );
	
	$row = mysql_fetch_array ( $t );
	$_SESSION['account_password_reseted']=true;
	$_SESSION['reset_acc_name']=$row[0];
	unset($_SESSION['can_reset_password']);
	
	if(isset($_SESSION['student_login'])){
		header ( 'Location: ' . 'student_home.php' );
	}
	else{
	
		header ( 'Location: ' . 'home.php' );
	}
	
	
	
}else{
	
	$db = mysql_connect ( 'localhost', 'root', '' );
	
//	$q = sprintf ( "CREATE DATABASE %s", $user_name);
	
//	$t=mysql_query ( $q );
	
	mysql_select_db ( 'student' );
	
	$q = sprintf ( "SELECT Department FROM account_info WHERE UserName='%s'", $user_name);
	
	$t=mysql_query ( $q );
	
	$row = mysql_fetch_array ( $t );
	$department=$row[0];
	mysql_close ();
	
	create_student_database($user_name,$department);	
	
	
	
	
	
	$_SESSION['student_acc_created']=true;
	$_SESSION['new_student_name']=$name;
	header ( 'Location: ' . 'home.php' );

}




//echo $password;

//$user_name=$_SESSION['user_name'];
//$user_name="tmpss";

/*

$db = mysql_connect ( 'localhost', 'root', '' );

$d = 'CREATE DATABASE '.$user_name;
$res = mysql_query ( $d );
//$res="ddddd";
//echo $d;
*/

function create_student_database($user_name,$department){
	
	$db = mysql_connect ( 'localhost', 'root', '' );
	
	$q = sprintf ( "CREATE DATABASE %s", $user_name);
	$t=mysql_query ( $q );
	
	mysql_close();
	
	$db = mysql_connect ( 'localhost', 'root', '' );
	mysql_select_db ($user_name);
	
	//if(strcmp($department, 'Department of Information Technology')==0){
	//}
	$query="CREATE TABLE s1s2 (subjCode VARCHAR(15) NOT NULL ,subjName VARCHAR(100),totalMark INT(3),yourMark INT(3), PRIMARY KEY(subjCode) )";
	$t=mysql_query ( $query );
	
	//echo $t;
	$query="CREATE TABLE s3 (subjCode VARCHAR(15) NOT NULL ,subjName VARCHAR(100),totalMark INT(3),yourMark INT(3), PRIMARY KEY(subjCode) )";
	$t=mysql_query ( $query );
	
	$query="CREATE TABLE s4 (subjCode VARCHAR(15) NOT NULL ,subjName VARCHAR(100),totalMark INT(3),yourMark INT(3), PRIMARY KEY(subjCode) )";
	$t=mysql_query ( $query );
	
	$query="CREATE TABLE s5 (subjCode VARCHAR(15) NOT NULL ,subjName VARCHAR(100),totalMark INT(3),yourMark INT(3), PRIMARY KEY(subjCode) )";
	$t=mysql_query ( $query );
	
	$query="CREATE TABLE s6 (subjCode VARCHAR(15) NOT NULL ,subjName VARCHAR(100),totalMark INT(3),yourMark INT(3), PRIMARY KEY(subjCode) )";
	$t=mysql_query ( $query );
	
	$query="CREATE TABLE s7 (subjCode VARCHAR(15) NOT NULL ,subjName VARCHAR(100),totalMark INT(3),yourMark INT(3), PRIMARY KEY(subjCode) )";
	$t=mysql_query ( $query );
	
	$query="CREATE TABLE s8 (subjCode VARCHAR(15) NOT NULL ,subjName VARCHAR(100),totalMark INT(3),yourMark INT(3), PRIMARY KEY(subjCode) )";
	$t=mysql_query ( $query );
	
	$query="INSERT INTO s1s2 (subjCode,subjName,totalMark) VALUES
			('EN09 101','Engineering Mathematics 1',100),
			('EN09 102','Engineering Mathematics 2',100),
			('EN09 103','Engineering Physics',100),
			('EN09 103(P)','Physics Lab',100),
			('EN09 104','Engineering Chemistry',100),
			('EN09 104(P)','Chemistry Lab',100),
			('EN09 105','Engineering Mechanics',100),
			('EN09 106','Basics of Civil and Mechanical Engineering',100),
			('EN09 107','Basics of Electrical,Electronics and Communication Engineering',100),
			('EN09 108','Engineering Graphics',100),
			('EN09 109(P)','Computer Programming in C',100),
			('EN09 110(P)','Mechanical Workshops',100),
			('EN09 111(P)','Electrical and Civil Workshops',100)";
	
	$t=mysql_query ( $query );
	
	if(strcmp($department, 'Department of Information Technology')==0){
		
		$query="INSERT INTO s3 (subjCode,subjName,totalMark) VALUES
			('IT09 301','Engineering Mathematics 3',100),
			('IT09 302','Humanities and Communication Skills',100),
			('IT09 303','Data Structures',100),
			('IT09 304','Descrete Computational Structures',100),
			('IT09 305','Electronic Circuits',100),
			('IT09 306','Switching Theory and Logic Design',100),
			('IT09 307(P)','Digital Electronics Lab',100),
			('IT09 308(P)','Programming Lab',100)";
		
		$t=mysql_query ( $query );
		
		$query="INSERT INTO s4 (subjCode,subjName,totalMark) VALUES
			('IT09 401','Engineering Mathematics 4',100),
			('IT09 402','Environmental Studies',100),
			('IT09 403','Computer Organization and Design',100),
			('IT09 404','Priciples of Communication Engineering',100),
			('IT09 405','Data Modeling And Design',100),
			('IT09 406','Microprocessor Based Design',100),
			('IT09 407(P)','Data Structures Lab',100),
			('IT09 408(P)','Programming Environments Lab',100)";
		
		$t=mysql_query ( $query );
		
		$query="INSERT INTO s5 (subjCode,subjName,totalMark) VALUES
			('IT09 501','Software Architecture and Project Management',100),
			('IT09 502','Industrial Economics and Principles of management',100),
			('IT09 503','Embedded systems',100),
			('IT09 504','Operating Systems',100),
			('IT09 505','Digital data Communication',100),
			('IT09 506','Theory of Communication',100),
			('IT09 507(P)','Systems Lab',100),
			('IT09 508(P)','Hardware Lab',100)";
		
		$t=mysql_query ( $query );
		
		
		$query="INSERT INTO s6 (subjCode,subjName,totalMark) VALUES
			('IT09 601','Software Quality Management',100),
			('IT09 602','Compiler Design',100),
			('IT09 603','Computer Networks',100),
			('IT09 604','Database Management systems',100),
			('IT09 605','Human Computer Interaction',100),
			('IT09 606','Elective-1',100),
			('IT09 607(P)','Database Management Lab',100),
			('IT09 608(P)','Mini Project',100)";
		
		$t=mysql_query ( $query );
		
		
		
		$query="INSERT INTO s7 (subjCode,subjName,totalMark) VALUES
			('IT09 701','Computer Graphics',100),
			('IT09 702','Natural Language Processing and Knowledge Based Systems',100),
			('IT09 703','Internet Technology',100),
			('IT09 704','Cryptography and Network security',100),
			('IT09 705','Elective-2',100),
			('IT09 706','Elective-3',100),
			('IT09 707(P)','Network Programming Lab',100),
			('IT09 708(P)','Computer Graphics and Multimedia Lab',100),
			('IT09 709(P)','Project',100)";
		
		$t=mysql_query ( $query );
		
		
		$query="INSERT INTO s8 (subjCode,subjName,totalMark) VALUES
			('IT09 801','Mobile Communication Systems',100),
			('IT09 802','High Speed Networks',100),
			('IT09 803','Elective-4',100),
			('IT09 804','Elective-5',100),
			('IT09 805(P)','Seminar',100),
			('IT09 806(P)','Project',100),
			('IT09 807(P)','Viva Voce',100)";		
		$t=mysql_query ( $query );
		
		
	}
	
	elseif (strcmp($department, 'Department of Computer Science')==0){
	
		$query="INSERT INTO s3 (subjCode,subjName,totalMark) VALUES
			('CS09 301','Engineering Mathematics 3',100),
			('CS09 302','Humanities and Communication Skills',100),
			('CS09 303','Data Structures',100),
			('CS09 304','Descrete Computational Structures',100),
			('CS09 305','Electronic Circuits',100),
			('CS09 306','Switching Theory and Logic Design',100),
			('CS09 307(P)','Electronic Circuits Lab',100),
			('CS09 308(P)','Programming Lab',100)";
	
		$t=mysql_query ( $query );
	
		$query="INSERT INTO s4 (subjCode,subjName,totalMark) VALUES
			('CS09 401','Engineering Mathematics 4',100),
			('CS09 402','Environmental Studies',100),
			('CS09 403','Computer Organization and Design',100),
			('CS09 404','Programming paradigms',100),
			('CS09 405','Systems Programming',100),
			('CS09 406','Microprocessor Based Design',100),
			('CS09 407(P)','Data Structures Lab',100),
			('CS09 408(P)','Digital Systems Lab',100)";
	
		$t=mysql_query ( $query );
	
		$query="INSERT INTO s5 (subjCode,subjName,totalMark) VALUES
			('CS09 501','Software Architecture and Project Management',100),
			('CS09 502','Industrial Economics and Principles of management',100),
			('CS09 503','Signal Processing',100),
			('CS09 504','Operating Systems',100),
			('CS09 505','Digital Data Communication',100),
			('CS09 506','Theory of Communication',100),
			('CS09 507(P)','Programming Paradigm Lab',100),
			('CS09 508(P)','Hardware Lab',100)";
	
		$t=mysql_query ( $query );
	
	
		$query="INSERT INTO s6 (subjCode,subjName,totalMark) VALUES
			('CS09 601','Embedded Systems',100),
			('CS09 602','Compiler Design',100),
			('CS09 603','Computer Networks',100),
			('CS09 604','Database Management Systems',100),
			('CS09 605','Computer Graphics',100),
			('CS09 606','Elective-1',100),
			('CS09 607(P)','Systems Lab',100),
			('CS09 608(P)','Mini Project',100)";
	
		$t=mysql_query ( $query );
	
	
	
		$query="INSERT INTO s7 (subjCode,subjName,totalMark) VALUES
			('CS09 701','Wireless Networks and Mobile Communication Systems',100),
			('CS09 702','Design and Analysis of Algorithms',100),
			('CS09 703','Internet Technology',100),
			('CS09 704','Cryptography and Network Security',100),
			('CS09 705','Elective-2',100),
			('CS09 706','Elective-3',100),
			('CS09 707(P)','Compiler Lab',100),
			('CS09 708(P)','Network Programming Lab',100),
			('CS09 709(P)','Project',100)";
	
		$t=mysql_query ( $query );
	
	
		$query="INSERT INTO s8 (subjCode,subjName,totalMark) VALUES
			('CS09 801','Computer Architecture and Parallel Processing',100),
			('CS09 802','Data mining and Warehousing',100),
			('CS09 803','Elective-4',100),
			('CS09 804','Elective-5',100),
			('CS09 805(P)','Project',100),
			('CS09 806(P)','Seminar',100),
			('CS09 807(P)','Viva Voce',100)";
		$t=mysql_query ( $query );
	
	
	}
	
	
	elseif (strcmp($department, 'Department of Electronics and Communication')==0){
	
		$query="INSERT INTO s3 (subjCode,subjName,totalMark) VALUES
			('EC09 301','Engineering Mathematics 3',100),
			('EC09 302','Humanities and Communication Skills',100),
			('EC09 303','Network Analysis & Synthesis',100),
			('EC09 304','Signals and Systems',100),
			('EC09 305','Digital Electronics',100),
			('EC09 306','Electrical Engineering',100),
			('EC09 307(P)','Digital Electronics Lab',100),
			('EC09 308(P)','Electrical Engineering Lab',100)";
	
		$t=mysql_query ( $query );
	
		$query="INSERT INTO s4 (subjCode,subjName,totalMark) VALUES
			('EC09 401','Engineering Mathematics 4',100),
			('EC09 402','Environmental Science',100),
			('EC09 403','Electronic Circuits',100),
			('EC09 404','Analog Communication',100),
			('EC09 405','Computer Organization & Architecture',100),
			('EC09 406','Solid State Devices',100),
			('EC09 407(P)','Electronic Circuits Lab',100),
			('EC09 408(P)','Analog Communication Lab',100)";
	
		$t=mysql_query ( $query );
	
		$query="INSERT INTO s5 (subjCode,subjName,totalMark) VALUES
			('EC09 501','Digital Signal Processing',100),
			('EC09 502','Quantitative Techniques For Managerial Decisions',100),
			('EC09 503','Electromagnetic Field Theory',100),
			('EC09 504','Digital Communication',100),
			('EC09 505','Microprocessors & Microcontrollers',100),
			('EC09 506','Linear Integrated Circuits',100),
			('EC09 507(P)','Microprocessors & Microcontrollers Lab',100),
			('EC09 508(P)','Linear Integrated Circuits Lab',100)";
	
		$t=mysql_query ( $query );
	
	
		$query="INSERT INTO s6 (subjCode,subjName,totalMark) VALUES
			('EC09 601','Basics of VLSI Design',100),
			('EC09 602','Engineering Economics and Principles of Management',100),
			('EC09 603','Radiation and Propagation',100),
			('EC09 604','Control Systems',100),
			('EC09 605','Optical communication',100),
			('EC09 606','Elective-1',100),
			('EC09 607(P)','Digital Communication & DSP Lab',100),
			('EC09 608(P)','Mini Project',100)";
	
		$t=mysql_query ( $query );
	
	
	
		$query="INSERT INTO s7 (subjCode,subjName,totalMark) VALUES
			('EC09 701','Information Theory and Coding',100),
			('EC09 702','Microwave Engineering',100),
			('EC09 703','Analog & Mixed MOS Circuits',100),
			('EC09 704','Digital System Design',100),
			('EC09 705','Elective-2',100),
			('EC09 706','Elective-3',100),
			('EC09 707(P)','Communication systems Lab',100),
			('EC09 708(P)','VLSI Design Lab',100),
			('EC09 709(P)','Project',100)";
	
		$t=mysql_query ( $query );
	
	
		$query="INSERT INTO s8 (subjCode,subjName,totalMark) VALUES
			('EC09 801','Data & Communication Network',100),
			('EC09 802','Wireless Mobile communication',100),
			('EC09 803','Elective-4',100),
			('EC09 804','Elective-5',100),
			('EC09 805(P)','Seminar',100),
			('EC09 806(P)','Project',100),
			('EC09 807(P)','Viva Voce',100)";
		$t=mysql_query ( $query );
	
	
	}
	
	
	
	
	mysql_close();
	
}



?>