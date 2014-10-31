<?php

/*
 * session_start (); //echo $_SESSION['logedin_teacher']; $name=$_SESSION['student_name']; echo '<h1>'. $name. ' Successfully LoggedIn ' . '</h1>';
 */
session_start ();

$set_sem = false;

if ((isset ( $_SESSION ['student_login'] ) and isset ( $_POST ['semester'] )) or (isset ( $_SESSION ['teacher_login'] ) and isset ( $_POST ['semester'] ))) {
	
	foreach ( $_POST as $key => $value ) {
		$tmp = is_array ( $value ) ? $value : trim ( $value );
		if (empty ( $tmp )) {
			$missing [] = $key;
			$$key = '';
			$correction_required = true;
		} else {
			$$key = $tmp;
		}
	}
	
	// echo $_POST['semester'];
	
	
	

	$user_name = $_SESSION ['user_name'];
		
	$db = mysql_connect ( 'localhost', 'root', '' );
		
		
	if(isset($_SESSION['teacher_login'])){
		mysql_select_db ( 'teacher' );
	}
	else{
		mysql_select_db ( 'student' );
	}
	
		
	$d = 'SELECT * FROM account_info WHERE UserName="' . $_SESSION ['user_name'] . '"';
		// echo $d;
	$res = mysql_query ( $d );
	$row = mysql_fetch_array ( $res );
		
	$name = $row [0];
	
	

	if(isset($_SESSION['teacher_login'])){
		mysql_select_db ( 'student' );
		$stude_user_name=$_SESSION['stude_user_name'];
		$d = 'SELECT * FROM account_info WHERE UserName="' . $stude_user_name . '"';
		// echo $d;
		$res = mysql_query ( $d );
		$row = mysql_fetch_array ( $res );
	
		$student_name = $row [0];
	
	}
	
	
	
	if(isset($_SESSION['student_login'])){
	
		mysql_select_db ( $user_name );
	}
	else{
		mysql_select_db ( $stude_user_name );
	}
	
	
	//print $stude_user_name;
	
	
	
	$d = 'SELECT * FROM s1s2';
	$res = mysql_query ( $d );
	$s [0] = mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s3';
	$res = mysql_query ( $d );
	$s [1] = mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s4';
	$res = mysql_query ( $d );
	$s [2] = mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s5';
	$res = mysql_query ( $d );
	$s [3] = mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s6';
	$res = mysql_query ( $d );
	$s [4] = mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s7';
	$res = mysql_query ( $d );
	$s [5] = mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s8';
	$res = mysql_query ( $d );
	$s [6] = mysql_fetch_array ( $res );
	
		
	if($semester != "--- Select Semester --"){
	
		$set_sem = true;
	
		if(isset($_SESSION['student_login'])){
	
			mysql_select_db ( $user_name );
		}
		else{
			mysql_select_db ( $stude_user_name );
		}
	
		
		if($semester == 'One and Two Semesters'){
			$d = 'SELECT * FROM s1s2';
		}
		
		if($semester == 'Third Semester'){
			$d = 'SELECT * FROM s3';
		}
		
		if($semester == 'Fourth Semester'){
			$d = 'SELECT * FROM s4';
		}
		
		if($semester == 'Fifth Semester'){
			$d = 'SELECT * FROM s5';
		}
	
		if($semester == 'Sixth Semester'){
			$d = 'SELECT * FROM s6';
		}
		
		if($semester == 'Seventh Semester'){
			$d = 'SELECT * FROM s7';
		}
		
		if($semester == 'Eighth Semester'){
			$d = 'SELECT * FROM s8';
		}
		
		$res = mysql_query ( $d );
		/*
		$row = mysql_fetch_array ( $res );
		
		echo $row[0];
		
		$row = mysql_fetch_array ( $res );
		
		echo $row[0];
		*/
		
		/*
		
		$g=1;
		$f='ddd';
		$b=$f.$g;
		echo $b;
		
		*/
		
	}
	
}

elseif((isset ( $_SESSION ['student_login'] ) and isset ( $_SERVER ['HTTP_REFERER'] )) or (isset ( $_SESSION ['teacher_login'] ) and isset ( $_SERVER ['HTTP_REFERER'] ))) {
	
	$user_name = $_SESSION ['user_name'];
	
	$db = mysql_connect ( 'localhost', 'root', '' );
	
	if(isset($_SESSION['teacher_login'])){
		mysql_select_db ( 'teacher' );
	}
	else{
		mysql_select_db ( 'student' );
	}
	
	
	
	$d = 'SELECT * FROM account_info WHERE UserName="' . $_SESSION ['user_name'] . '"';
	// echo $d;
	$res = mysql_query ( $d );
	$row = mysql_fetch_array ( $res );
	
	$name = $row [0];
	
	
	if(isset($_SESSION['teacher_login'])){
		mysql_select_db ( 'student' );
		$stude_user_name=$_SESSION['stude_user_name'];
		$d = 'SELECT * FROM account_info WHERE UserName="' . $stude_user_name . '"';
		// echo $d;
		$res = mysql_query ( $d );
		$row = mysql_fetch_array ( $res );
	
		$student_name = $row [0];
	
	}
	
	

	if(isset($_SESSION['student_login'])){
	
		mysql_select_db ( $user_name );
	}
	else{
		mysql_select_db ( $stude_user_name );
	}
	
	$d = 'SELECT * FROM s1s2';
	$res = mysql_query ( $d );
	$s [0] = mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s3';
	$res = mysql_query ( $d );
	$s [1] = mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s4';
	$res = mysql_query ( $d );
	$s [2] = mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s5';
	$res = mysql_query ( $d );
	$s [3] = mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s6';
	$res = mysql_query ( $d );
	$s [4] = mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s7';
	$res = mysql_query ( $d );
	$s [5] = mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s8';
	$res = mysql_query ( $d );
	$s [6] = mysql_fetch_array ( $res );
	
}

else {

	header ( 'Location: ' . 'home.php' );

}
	
?>




<script type="text/javascript">

function redirfun() {

	var a = document.getElementById("semesterform");

	var b = document.getElementById("semester");

	var c = b.options[b.selectedIndex].value;

	//a.value=s;

	if( c === "--- Select Semester --" ){
		a.value="--- Select Semester --";
		document.myform.submit();
	}
	

	if( c === "One and Two Semesters" ){
		a.value="One and Two Semesters";
		document.myform.submit();
	}

	if( c === "Third Semester" ){
		a.value="Third Semester";
		document.myform.submit();
	}

	if( c === "Fourth Semester" ){
		a.value="Fourth Semester";
		document.myform.submit();
	}

	if( c === "Fifth Semester" ){
		a.value="Fifth Semester";
		document.myform.submit();
	}

	if( c === "Sixth Semester" ){
		a.value="Sixth Semester";
		document.myform.submit();
	}

	if( c === "Seventh Semester" ){
		a.value="Seventh Semester";
		document.myform.submit();
	}

	if( c === "Eighth Semester" ){
		a.value="Eighth Semester";
		document.myform.submit();
	}
	

	//document.getElementById('ycord').innerHTML=s;
	
	
	
	
	

}



</script>


<html>





<style type="text/css">
<!--
input.largerCheckbox {
	width: 20px;
	height: 20px;
}

//
-->
.block {
	display: block;
}
</style>


<style>
h1 {
	color: blue
}

select.opt {
	font-size: 12pt;
	text-align: center;
}
</style>
<style>
h2 {
	color: blue
}
</style>





<h1 align="center">
	<a href="http://gecskp.ac.in"> <img src="./Resources/gec.jpg" width=820
		height=250 style="border: 20px groove white;">
	</a>
</h1>
<body style="background-color: #aba">
	<form name="myform" method="post" action="new_data_entry.php">


		<input type="hidden" id="semesterform" name="semester">

	</form>
	
	
	
	
<div align="left" style="font-size: 15pt;margin-right: 40px">
	<a href="<?php if(isset($_SESSION['student_login'])){ echo "student_home.php"; } else {echo "teacher_home.php";} ?>"> Home </a>
</div>


	
	
	
	

	<div align="right" style="font-size: 15pt; margin-right: 40px">
		<a href="home.php?action=logout"> Log Out </a>
	</div>

	<table align="center">

		<tr>
			<td colspan="2"><b><div
						style="font-size: 30pt; color: red; text-align: center;"><?php //Welcome ?><?php// echo $name; ?>Add or Edit an Entry.</div></b>

			</td>
		</tr>

	</table>

	<table align="center"
		style="background-color: #bbe; border: 5px groove white; width: 20cm;">



		<tr>
			<td><table align="center">

					<tr>
						<td><select class="opt" name="semester" id="semester"
							onchange="redirfun();">
								<option
									<?php if(isset($semester) and $semester=='--- Select Semester --' ){echo 'selected="selected"'; } ?>>---
									Select Semester --</option>
                          <?php if(is_null($s[0][3])) { ?> <option
									<?php if(isset($semester) and $semester=='One and Two Semesters' ){echo 'selected="selected"'; } ?>>One
									and Two Semesters</option><?php } ?>
						  <?php if(is_null($s[1][3])) { ?> <option
									<?php if(isset($semester) and $semester=='Third Semester' ){echo 'selected="selected"'; } ?>>Third
									Semester</option><?php } ?>
						  <?php if(is_null($s[2][3])) { ?> <option
									<?php if(isset($semester) and $semester=='Fourth Semester' ){echo 'selected="selected"'; } ?>>Fourth
									Semester</option><?php } ?>
						  <?php if(is_null($s[3][3])) { ?> <option
									<?php if(isset($semester) and $semester=='Fifth Semester' ){echo 'selected="selected"'; } ?>>Fifth
									Semester</option><?php } ?>
						  <?php if(is_null($s[4][3])) { ?> <option
									<?php if(isset($semester) and $semester=='Sixth Semester' ){echo 'selected="selected"'; } ?>>Sixth
									Semester</option><?php } ?>
						  <?php if(is_null($s[5][3])) { ?> <option
									<?php if(isset($semester) and $semester=='Seventh Semester' ){echo 'selected="selected"'; } ?>>Seventh
									Semester</option><?php } ?>
						  <?php if(is_null($s[6][3])) { ?> <option
									<?php if(isset($semester) and $semester=='Eighth Semester' ){echo 'selected="selected"'; } ?>>Eighth
									Semester</option><?php } ?>





						</select></td>

					</tr>

				</table></td>
		</tr>


		<tr>
			<td><?php if($set_sem) { $_SESSION['semester']=$semester; print_entry($res); } ?></td>
		</tr>
		
		


	</table>


</body>


</html>
<?php



function print_entry($res){

	$num=0;
	$subj='subj';
	$r='';
	$r.='<form name="studform" method="post" action="save_student_data.php">';
	$r=$r.'<table align="center">';
	
	
	$r=$r.'<td style="padding:5px;background-color:gray">Code Number</td><td style="padding:5px;background-color:gray">Subject Name</td><td style="padding:5px;background-color:gray">Maximum Mark</td><td style="padding:5px;background-color:gray">Your Mark</td>';
	
	
	
	while($row = mysql_fetch_array ( $res )){
				$num=$num+1;
		$tmpp=$subj.$num;
		$r=$r.'<tr>';
		$r=$r.'<td style="padding:5px;background-color:beige">'.$row[0].'</td><td style="padding:5px;background-color:beige">'.$row[1].'</td><td style="padding:5px;background-color:beige">'.$row[2].'</td><td style="padding:5px;background-color:beige">'.'<input type="number" name="'.$tmpp.'" min="0.0" max="100.0" style="width :50px" required="required"value="';
		$r.=$row[3];
		$r.='"></td>';
		$r=$r.'</tr>';
	}
	$r.='</table><table align="center"><tr><td><input type="button" value="Home" style="width: 200px; height: 30px" onClick="window.location=';
	if(isset($_SESSION['student_login'])){
		$r.="'student_home.php'";
	}
	else {
		$r.="'teacher_home.php'";
	}
	$r.='"></td><td><input type="submit" name="stud_det" value="Submit" style="width: 200px; height: 30px"></td></tr>';
	
	$r=$r.'</table>';
	$r.='</form>';
	
	echo	$r;
}
?>