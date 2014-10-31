<?php
session_start();
$correction_required=false;
$wrong_password=false;
$missing = array ();
$user_name=$_SESSION['user_name'];
if((isset($_SESSION['teacher_login']) and isset($_POST['newpasssubm']))){
	
	$user_name=$_SESSION['user_name'];
	$db = mysql_connect ( 'localhost', 'root', '' );
	mysql_select_db ( 'teacher' );
	
	$d = 'SELECT * FROM account_info WHERE UserName="'.$_SESSION['user_name'].'"';
	//echo $d;
	$res = mysql_query ( $d );
	$row = mysql_fetch_array ( $res );
	
	
	$name=$row[0];
	
	foreach ( $_POST as $key => $value ) {
		// echo $key;
		$tmp = is_array ( $value ) ? $value : trim ( $value );
		if (empty ( $tmp )) {
			$missing [] = $key;
			$$key = '';
				
			$correction_required = true;
		} else {
			$$key = $tmp;
		}
	}
	
	if (! empty ( $new_password ) && ! empty ( $retype_password ) && (strcmp ( $new_password, $retype_password ) == 0)) {
	} else {
		$correction_required = true;
		$missing [] = 'new_password';
		$missing [] = 'retype_password';
	}
	
	if (! $correction_required) {
		// echo "ss";
		// echo "use name is ",$user_name;
		// echo "password is ",$password;
		$db = mysql_connect ( 'localhost', 'root', '' );
		mysql_select_db ( 'teacher' );
	
		if (authenticate_teacher ( $user_name, $current_password )) {
			
			
			$salt = openssl_random_pseudo_bytes ( 6 );
			$new_password1 = $new_password . $salt;
			$salted_password = md5 ( $new_password1 );
				
			
			mysql_select_db ( 'teacher' );
			
			$q = sprintf ( "UPDATE account_info SET Password='%s',Salt='%s' WHERE UserName='%s'", $salted_password,$salt,$_SESSION['user_name']);
			
			//echo $q;
			
			$t=mysql_query ( $q );
			
			mysql_close();
			
			$_SESSION['account_password_reseted']=true;
			$_SESSION['reset_acc_name']=$name;
			
			header ( 'Location: ' . 'teacher_home.php' );
				
			
		}
		else{
			$wrong_password=true;
			$correction_required=true;
		}
	}
	
}

elseif((isset($_SESSION['teacher_login']) and isset($_POST['change_teach_passwd'])) ){
	$user_name=$_SESSION['user_name'];
	$db = mysql_connect ( 'localhost', 'root', '' );
	mysql_select_db ( 'teacher' );
	
	$d = 'SELECT * FROM account_info WHERE UserName="'.$_SESSION['user_name'].'"';
	//echo $d;
	$res = mysql_query ( $d );
	$row = mysql_fetch_array ( $res );
	
	
	$name=$row[0];
	
}

else {

	header ( 'Location: ' . 'home.php' );

}

?>


<html>


<script type="text/javascript">

function confirmPassword() {

	//alert("dfsfdfd");
	var a = document.getElementById("new_password");
	var b = document.getElementById("retype_password");

	//alert(b.value);

	if(a.value === b.value){
		//document.passForm.submit();
	}
	else{
		//alert("You must reenter new password twice to confirm it.")
	}
		
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


		
<div align="left" style="font-size: 15pt;margin-right: 40px">
	<a href="<?php if(isset($_SESSION['student_login'])){ echo "student_home.php"; } else {echo "teacher_home.php";} ?>"> Home </a>
</div>

	


<div align="right" style="font-size: 15pt;margin-right: 40px">
<a href="home.php?action=logout"> Log Out </a>
</div>

<table align="center">

<tr><td colspan="2">

<b><div style="font-size: 30pt; color: red; text-align: center;">Welcome <?php echo $name; ?></div></b>

</td></tr>

</table>

<table align="center" style="background-color: beige; border: 5px groove white; width: 18cm;" >

<tr><td colspan="2" style="background-color:gray;padding:5px;">

<b><div style="font-size: 40pt; color: blue; text-align: center;">Change Your Password</div></b>

</td></tr>


<tr><td><form method="post" id="passForm" action=<?php echo $_SERVER['PHP_SELF'] ?>><table align="center" >
<tr/><tr/><tr/><tr/>

</table><table align="center" >

<tr>
<td />
<td id="tmp" style="font-size: 12pt; color: red; padding: 2px;"><?php if($correction_required and $wrong_password){ ?>Please enter your correct current password.<?php } elseif ($correction_required){ if((in_array('new_password', $missing)) or (in_array('retype_password', $missing) )) { ?> You must re-enter new password twice to confirm it.<?php } } ?> </td>
</tr>

</table><table align="center" >

<tr/><tr/><tr/><tr/>
<tr><td>Current Password :</td><td><input type="password" name="current_password" required="required"></td></tr>

<tr><td>New Password :</td><td><input type="password" id="new_password"  name="new_password" required="required"></td></tr>


<tr><td>Re-type Password :</td><td><input type="password" id="retype_password" name="retype_password" required="required" ></td></tr>
<tr/><tr/><tr/><tr/>


</table>

<table align="center" >

<tr><td><input type="submit" style="width: 240px; height: 25px" value="Submit" name="newpasssubm" onClick="confirmPassword();"></td></tr>


</table>
 </form>
 </td></tr>


</table>


</body>


</html>




<?php 




function authenticate_teacher($user_name, $password) {
	$d = 'SELECT * FROM account_info';
	$res = mysql_query ( $d );
	// $exist = 'false';
	// echo $res;
	while ( $row = mysql_fetch_array ( $res ) ) {
		// echo $row[7];
		// echo $user_name;
		// if ((strcmp($user_name, htmlspecialchars ( $row[7])==0))) {
		// echo strcmp($user_name, $row[7]);
		if (strcmp ( $user_name, $row [7] ) == 0) {
			$new_password = $password . $row [9];
			$tmp = md5 ( $new_password );
			if (strcmp ( $tmp, $row [8] ) == 0) {
				$_SESSION ['logedin_teacher'] = $user_name;
				return true;
			}
		}
	}
	return false;
}



?>
	
