<?php
session_start();

if(isset($_SESSION['teacher_login'])){
	
	$user_name=$_SESSION['user_name'];
	
	$db = mysql_connect ( 'localhost', 'root', '' );
	mysql_select_db ( 'teacher' );
	
	$d = 'SELECT * FROM account_info WHERE UserName="'.$_SESSION['user_name'].'"';
	//echo $d;
	$res = mysql_query ( $d );
	$row = mysql_fetch_array ( $res );
	
	
	$name=$row[0];
	
	mysql_select_db ( 'student' );
	
	$d='SELECT * FROM account_info';
	
	$res=mysql_query($d);
	
	$students=array();
	
	while($row=mysql_fetch_array($res)){
		array_push($students, $row);
	}
	
	//echo $students[1][0]
	
	
	
	
	
?>


<html>

<script type="text/javascript">


function redirfun(stud_user_name){

	var a = document.getElementById("stud_user_name");

	a.value=stud_user_name;
	//alert(a.value);
	document.myform.submit();
	


}




function funn(){
	document.getElementById('gh').style.visibility = "hidden";
	document.getElementById('hg').style.visibility = "visible";
	
}


setTimeout(funn,4000);






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
	display : block;
}
</style>


<style>
h1 {
	color: blue
}
</style>
<style>
h2 {
	color: blue
}
</style>
<h1 align="center">
	<a href="http://gecskp.ac.in"> <img src="./Resources/gec.jpg" width=820 height=250
		style="border: 20px groove white;">
	</a>
</h1>
<body style="background-color: #aba">


	<form name="myform" method="post" action="student_profile.php">


		<input type="hidden" id="stud_user_name" name="stude_user_name">

	</form>

<form name="myform1" method="post" action="change_teacher_password.php">


<input type="hidden" id="semesterform" name="user_name" value="<?php echo $user_name; ?>">

<input type="hidden" id="semesterform1" name="change_teach_passwd" value="<?php echo "true"; ?>">

</form>
	
	

<div align="left" style="font-size: 15pt;margin-right: 40px">
<a href="#" onClick="document.myform1.submit();"> Change  Password </a>
</div>


	
	
	
	
<div align="right" style="font-size: 15pt;margin-right: 40px">
<a href="home.php?action=logout"> Log Out </a>
</div>



<?php if((isset($_SESSION['account_password_reseted'])) and $_SESSION['account_password_reseted']){ ?>


<table align="center" id="gh">
		<tr>
			<td colspan="2"  bgcolor="#99ff33"><div align="center"
					style="font-size: 18pt; color: red; border: 1px dashed white;"><?php echo $_SESSION['reset_acc_name'];?>, Your Password changed successfully.</div></td>
		</tr>
</table>

<?php unset($_SESSION['account_password_reseted']); unset($_SESSION['reset_acc_name']);  ?>




<table align="center" id="hg" style="visibility: hidden;" >

<tr><td colspan="2">

<b><div style="font-size: 30pt; color: red; text-align: center;">Welcome <?php echo $name; ?></div></b>

</td></tr><tr/> <tr/> <tr/> <tr/> <tr/> 

</table>




<?php } elseif((isset($_SESSION['new_data_entry'])) and $_SESSION['new_data_entry']){ ?>


<table align="center" id="gh">
		<tr>
			<td colspan="2"  bgcolor="#99ff33"><div align="center"
					style="font-size: 18pt; color: red; border: 1px dashed white;"><?php echo $name;?>, Data record updated successfully.</div></td>
		</tr>
</table>

<?php unset($_SESSION['new_data_entry']);   ?>






<table align="center" id="hg" style="visibility: hidden;" >

<tr><td colspan="2">

<b><div style="font-size: 30pt; color: red; text-align: center;">Welcome <?php echo $name; ?></div></b>

</td></tr><tr/> <tr/> <tr/> <tr/> <tr/> 

</table>


<?php }  else { ?>



<table align="center"  >

<tr><td colspan="2">

<b><div style="font-size: 30pt; color: red; text-align: center;">Welcome <?php echo $name; ?></div></b>

</td></tr><tr/> <tr/> <tr/> <tr/> <tr/> 

</table>


<?php } ?>





<table align="center" style="background-color: #bbe; border: 5px groove white; width: 20cm;" >

<tr><td colspan="2" style="background-color:gray;padding:5px;">

<b><div style="font-size: 40pt; color: blue; text-align: center;">Student Details</div></b>

</td></tr>


<tr><td><table align="center" >



<?php 

print_student_details($students);


?>




</table></td></tr>


</table>


</body>


</html>
<?php 
}
else {

header ( 'Location: ' . 'home.php' );

}


function print_student_details($students){

	$r='';
	
	$r.='<tr><td style="padding:5px;background-color:gray">Register Number</td><td style="padding:5px;background-color:gray">Name</td><td style="padding:5px;background-color:gray">Department</td><td style="padding:5px;background-color:gray"></td></tr>';
	
	foreach ($students as $student){
		
		$r.='<tr><td style="padding:5px;background-color:beige">'.$student[1].'</td><td style="padding:5px;background-color:beige">'.$student[0].'</td><td style="padding:5px;background-color:beige">'.$student[7].'</td><td style="padding:5px;background-color:beige"><input type="button" value="View Profile" onClick=redirfun("'.$student[8].'")></td></tr>';
		
	}

	echo $r;

}






?>