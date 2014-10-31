<?php



session_start();

if(isset($_SESSION['student_login'])){
	
	$user_name=$_SESSION['user_name'];
	
	$db = mysql_connect ( 'localhost', 'root', '' );
	mysql_select_db ( 'student' );
	
	$d = 'SELECT * FROM account_info WHERE UserName="'.$_SESSION['user_name'].'"';
	//echo $d;
	$res = mysql_query ( $d );
	$row = mysql_fetch_array ( $res );
	
	
	$name=$row[0];
	
	mysql_select_db ( $user_name );
	
	$d = 'SELECT * FROM s1s2';
	$res = mysql_query ( $d );
	$s[0]=mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s3';
	$res = mysql_query ( $d );
	$s[1]=mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s4';
	$res = mysql_query ( $d );
	$s[2]=mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s5';
	$res = mysql_query ( $d );
	$s[3]=mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s6';
	$res = mysql_query ( $d );
	$s[4]=mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s7';
	$res = mysql_query ( $d );
	$s[5]=mysql_fetch_array ( $res );
	
	$d = 'SELECT * FROM s8';
	$res = mysql_query ( $d );
	$s[6]=mysql_fetch_array ( $res );
	
	
	
	
	
	
	

?>

<html>





<script type="text/javascript">

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


<form name="myform" method="post" action="check_student_login.php">


<input type="hidden" id="semesterform" name="user_name" value="<?php echo $user_name; ?>">

<input type="hidden" id="semesterform1" name="can_change_passwd" value="<?php echo "true"; ?>">

</form>


<div align="left" style="font-size: 15pt;margin-right: 40px">
<a href="#" onClick="document.myform.submit();"> Change  Password </a>
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

<table align="center" style="background-color: #bbe; border: 5px groove white; width: 15cm;" >

<tr/> <tr><td colspan="2" style="background-color:gray;padding:5px;">

<b><div style="font-size: 40pt; color: blue; text-align: center;">Your Data</div></b>

</td></tr>


<tr><td><table align="center" >

<?php 

	$full=true;

	
	//for($i=0;$i<=6;$i=$i+1){
		/*
		if(!is_null($s[$i][3])){
	
			echo '<tr><td>'.$s[$i][2].'</td></tr>';
		}
		*/
		if(!is_null($s[0][3])){
			$e = sprintf ( "<form method=\"post\" action=\"view_student_data.php\"><input type=\"hidden\" name=\"no\" value=\"s1s2\"><input type='submit' value='View'/></form>" );
			echo '<tr><td style="background-color:#eef;padding:5px;width:8cm;text-align: center;font-size:18pt;">One and Two Semesters</td><td style="background-color:#eef;padding:5px">'.$e.'</td></tr>';
		}
		else {

			$full=false;
			
		}

		if(!is_null($s[1][3])){
			$e = sprintf ( "<form method=\"post\" action=\"view_student_data.php\"><input type=\"hidden\" name=\"no\" value=\"s3\"><input type='submit' value='View'/></form>" );
			echo '<tr><td style="background-color:#eef;padding:5px;width:8cm;text-align: center;font-size:18pt;">Third Semesters</td><td style="background-color:#eef;padding:5px">'.$e.'</td></tr>';
		}
		else {
		
			$full=false;
				
		}
		
		if(!is_null($s[2][3])){
			$e = sprintf ( "<form method=\"post\" action=\"view_student_data.php\"><input type=\"hidden\" name=\"no\" value=\"s4\"><input type='submit' value='View'/></form>" );
			echo '<tr><td style="background-color:#eef;padding:5px;width:8cm;text-align: center;font-size:18pt;">Fourth Semesters</td><td style="background-color:#eef;padding:5px">'.$e.'</td></tr>';
		}
		else {
		
			$full=false;
		
		}
		
		
		if(!is_null($s[3][3])){
			$e = sprintf ( "<form method=\"post\" action=\"view_student_data.php\"><input type=\"hidden\" name=\"no\" value=\"s5\"><input type='submit' value='View'/></form>" );
			echo '<tr><td style="background-color:#eef;padding:5px;width:8cm;text-align: center;font-size:18pt;">Fifth Semesters</td><td style="background-color:#eef;padding:5px">'.$e.'</td></tr>';
		}
		else {
		
			$full=false;
		
		}
		
		
		if(!is_null($s[4][3])){
			$e = sprintf ( "<form method=\"post\" action=\"view_student_data.php\"><input type=\"hidden\" name=\"no\" value=\"s6\"><input type='submit' value='View'/></form>" );
			echo '<tr><td style="background-color:#eef;padding:5px;width:8cm;text-align: center;font-size:18pt;">Sixth Semesters</td><td style="background-color:#eef;padding:5px">'.$e.'</td></tr>';
		}
		else {
		
			$full=false;
		
		}
		
		
		if(!is_null($s[5][3])){
			$e = sprintf ( "<form method=\"post\" action=\"view_student_data.php\"><input type=\"hidden\" name=\"no\" value=\"s7\"><input type='submit' value='View'/></form>" );
			echo '<tr><td style="background-color:#eef;padding:5px;width:8cm;text-align: center;font-size:18pt;">Seventh Semesters</td><td style="background-color:#eef;padding:5px">'.$e.'</td></tr>';
		}
		else {
		
			$full=false;
		
		}
		
		if(!is_null($s[6][3])){
			$e = sprintf ( "<form method=\"post\" action=\"view_student_data.php\"><input type=\"hidden\" name=\"no\" value=\"s8\"><input type='submit' value='View'/></form>" );
			echo '<tr><td style="background-color:#eef;padding:5px;width:8cm;text-align: center;font-size:18pt;">Eighth Semesters</td><td style="background-color:#eef;padding:5px">'.$e.'</td></tr>';
		}
		else {
		
			$full=false;
		
		}
		
		if(!$full){

			$e = sprintf ( "<form method=\"post\" action=\"new_data_entry.php\"><input type=\"hidden\" name=\"no\" value=\"new\"><input type='submit' value='New Data Entry' style=\"width: 240px; height: 25px\" /></form>" );
			echo '<tr><td colspan="2" style="background-color:#eef;padding:5px;width:8cm;text-align: center;font-size:18pt;">'.$e.'</td></tr>';

		}
		
		
	//}

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
?>