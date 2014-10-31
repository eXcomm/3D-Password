<?php
session_start ();
if (! isset ( $_SERVER ['HTTP_REFERER'] )) {
	echo '<h1>Sorry You have no rights to view this page.</h1>';
}

else{
	
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
	
	//echo $no;
	
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
	
	$d = 'SELECT * FROM '.$no;
	$res = mysql_query ( $d );
	
	if ($no=='s1s2'){
		$semester='One and Two Semesters';
	}
	
	if ($no=='s3'){
		$semester='Third Semester';
	}
	
	if ($no=='s4'){
		$semester='Fourth Semester';
	}
	
	if ($no=='s5'){
		$semester='Fifth Semester';
	}
	
	if ($no=='s6'){
		$semester='Sixth Semester';
	}
	
	if ($no=='s7'){
		$semester='Seventh Semester';
	}
	
	if ($no=='s8'){
		$semester='Eighth Semester';
	}
	
?>


<html>

<script type="text/javascript">

function editFun(){

	var a = document.getElementById("semesterform");

	var b = document.getElementById("sem");

	var c = b.innerHTML;

	//a.value=c;
	//alert(c);
	document.myform.submit();
	
	

}



</script>



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


		<input type="hidden" id="semesterform" name="semester" value="<?php echo $semester; ?>">

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
						style="font-size: 30pt; color: red; text-align: center;">Welcome <?php echo $name; ?></div></b>

			</td>
		</tr>

	</table>
	
		<table align="center"
		style="background-color: #bbe; border: 5px groove white; width: 20cm;">



		<tr>
			<td><table align="center">

					<tr>
						<td>
						
						<div style="font-size: 20pt;text-align: center; color: blue" id="sem" ><?php if(isset($_SESSION['teacher_login'])){ echo $student_name . "'s mark record of " . $semester; } else { echo $semester; }?></div>
						
						</td>
						
						</tr></table>
			</td></tr></table>
	

			
			
			

	
		<table align="center"
		style="background-color: #bbe; border: 5px groove white; width: 20cm;">



		<tr>
			<td><table align="center">
			
				<?php  print_entry($res); ?>

				</table>
			</td></tr></table>
			
			
			
			
			
			
			

</body>


</html>


<?php 
	
}



function print_entry($res){

	$num=0;
	$subj='subj';
	$r='';
	
	$r=$r.'<table align="center">';


	$r=$r.'<td style="padding:5px;background-color:gray">Code Number</td><td style="padding:5px;background-color:gray">Subject Name</td><td style="padding:5px;background-color:gray">Maximum Mark</td><td style="padding:5px;background-color:gray">Your Mark</td>';



	while($row = mysql_fetch_array ( $res )){
		$num=$num+1;
		$tmpp=$subj.$num;
		$r=$r.'<tr>';
		$r=$r.'<td style="padding:5px;background-color:beige">'.$row[0].'</td><td style="padding:5px;background-color:beige">'.$row[1].'</td><td style="padding:5px;background-color:beige">'.$row[2].'</td><td style="padding:5px;background-color:beige">'.$row[3].'</td>';
		$r=$r.'</tr>';
	}
	$r.='</table><table align="center"><tr><td><input type="button" value="Home" style="width: 200px; height: 30px" onClick="window.location=';
	if(isset($_SESSION['student_login'])){
		$r.="'student_home.php'";
	}
	else {
		$r.="'teacher_home.php'";
	}
	$r.='"></td><td><input type="submit" name="edit" id="edit" value="Edit" style="width: 200px; height: 30px" onClick="editFun();"></td></tr>';
	$r=$r.'</table>';
	

	echo	$r;
}



?>