
<?php
session_start ();

//session_destroy();

//session_start ();

$correction_required = false;
$missing = array ();


if(isset($_GET['action'])){
	
	if(strcmp($_GET['action'],'logout')==0){
		//echo "DD";
		session_destroy();
		session_start();
	}/*
	else{
		echo "SSs";
	}*/
}




if(isset($_SESSION['student_login'])){
	header ( 'Location: student_home.php' );
}


if(isset($_SESSION['teacher_login'])){
	header ( 'Location: teacher_home.php' );
}




if (isset ( $_POST ['teacher_login'] )) {
	
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
	if (! $correction_required) {
		// echo "ss";
		// echo "use name is ",$user_name;
		// echo "password is ",$password;
		$db = mysql_connect ( 'localhost', 'root', '' );
		mysql_select_db ( 'teacher' );
		
		if (authenticate_teacher ( $user_name, $password )) {
			session_destroy();
			session_start();
			$_SESSION['teacher_login']=true;
			
			$_SESSION['user_name']=$user_name;
			
				
			header ( 'Location: ' . 'teacher_home.php' );
		} else {
			$missing [] = 'user_name';
			$missing [] = 'password';
			
			$correction_required = true;
			// header ( 'Location: ' . 'home.php' );
		}
		
		mysql_close ();
	} else {
		// echo "dd";
		$missing [] = 'password';
		$correction_required = true;
	}
}
/*else{
	if(isset($_SESSION['user_name'])){
		unset($_SESSION['user_name']);
	}

}*/
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


<html>

<script type="text/javascript">

function funn(){
	document.getElementById('gh').style.visibility = "hidden";
	
}


setTimeout(funn,4000);



</script>


<style>
h1 {
	color: blue
}

.container {
	padding: 10px;
	margin: 0 0 10px;
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

<?php /* if(isset($_SESSION['teacher_acc_created'])){ */?>

<table align="center">
		<tr>
			<td colspan="2" id="gh" bgcolor="#99ff33"><div align="center"
					style="font-size: 18pt; color: red; border: 1px dashed white;"><?php if(isset($_SESSION['teacher_acc_created'])){ echo $_SESSION['new_teacher_name'];echo ", " ?>Your
				account has been created. <?php unset($_SESSION['teacher_acc_created']); unset($_SESSION['new_teacher_name']); } ?></div></td>
		</tr>
	</table>

<?php /* unset($_SESSION['teacher_acc_created']); unset($_SESSION['new_teacher_name']); } */?>





<?php if(isset($_SESSION['student_acc_created'])){ ?>

<table align="center">
		<tr>
			<td colspan="2" id="gh" bgcolor="#99ff33"><div align="center"
					style="font-size: 18pt; color: red; border: 1px dashed white;"><?php echo $_SESSION['new_student_name'];echo ", " ?>Your
				account has been created.</div></td>
		</tr>
	</table>

<?php unset($_SESSION['student_acc_created']); unset($_SESSION['new_student_name']); } ?>





<?php if(isset($_SESSION['account_password_reseted'])){ ?>

<table align="center">
		<tr>
			<td colspan="2" id="gh" bgcolor="#99ff33"><div align="center"
					style="font-size: 18pt; color: red; border: 1px dashed white;"><?php echo $_SESSION['reset_acc_name'];echo ", " ?>Your
				Password has been resetted.</div></td>
		</tr>
	</table>

<?php unset($_SESSION['account_password_reseted']); unset($_SESSION['reset_acc_name']); session_destroy(); session_start(); } ?>



	<table>
		<tr>
			<td>

				<form method="post" action="check_student_login.php">
					<table
						style="align: left; background-color: #bbe; margin: 90px; border: 5px groove white; width: 10cm; height: 8.2cm">
						<tr>
							<td colspan="2"><div
									style="font-size: 29; color: red; text-align: center;">Student
									LogIn</div>
						
						</tr>
						<tr>
							<td colspan="2"><hr color="white"></hr></td>
						</tr>
						<tr>
							<td>
								<table style="margin: 52px; margin-top: 25px">
									<tr>
										<td>User Name :</td>
										<td><input type="text" name="user_name"
											<?php
											// echo $_SESSION['student_user_name'];
											if (isset ( $_SESSION ['user_name_correction'] ) && $_SESSION ['user_name_correction'] == true && isset ( $_SESSION ['student_user_name'] )) {
												echo 'value="' . $_SESSION ['student_user_name'] . '"';
											}
											unset ( $_SESSION ['student_user_name'] );
											?> /></td>
									</tr>
									
								<?php if(isset($_SESSION['user_name_correction']) && $_SESSION['user_name_correction']==true){ ?>
								<tr>
										<td />
										<td style="font-size: 12pt; color: red; padding: 2px;">Please
											fill your User Name.</td>
									</tr>
								<?php } unset($_SESSION['user_name_correction']);	 ?>
									
									<tr>
										<td></td>
									</tr>
									<tr>
										<td></td>
									</tr>
									<tr>
										<td colspan="2"><input type="submit" value="Log In"
											style="width: 240px; height: 25px" /></td>
									</tr>
									<tr></tr>
									<tr></tr>
									<tr></tr>
									<tr></tr>
									<tr></tr>
									<tr></tr>
									<tr></tr>
									<tr></tr>
									<tr>
										<td colspan="2">
											<div style="font-size: 18; color: blue; text-align: center;">
												<a href="forgot_password.php"> Forgot Password? </a>
											</div>
										</td>
									</tr>
									<tr />
									<tr />
									<tr>
										<td colspan="2">
											<div style="font-size: 20; color: blue; text-align: center;">
												<a href="create_student_account.php"> Create new Student
													account. </a>
											</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</form>
			
			<td>
				<form method="post" action=<?php echo $_SERVER['PHP_SELF'] ?>>
					<table
						style="align: right; background-color: #ffcf99; border: 5px groove white; width: 10cm; height: 5cm; margin-left: 6cm">
						<tr>
							<td colspan="2">
								<div style="font-size: 29; color: red; text-align: center;">Teacher
									LogIn</div>
						
						</tr>
						<tr>
							<td colspan="2"><hr color="white"></hr></td>
						</tr>
						<tr>
							<td>
								<table style="margin: 52px; margin-top: 25px">

									<tr>
										<td>User Name :</td>
										<td><input type="text" name="user_name"
											<?php
											if ($correction_required) {
												echo 'value="' . $user_name . '"';
											}
											?> /></td>
									</tr>
									
								<?php if(in_array('user_name', $missing)){ ?>
							<tr>
										<td />
										<td style="font-size: 12pt; color: red; padding: 2px;">Please
											fill your User Name.</td>
									</tr>
								<?php } ?>

									<tr>
										<td>Password :</td>
										<td><input type="password" name="password" /></td>
									</tr>
								<?php if(in_array('password', $missing)){ ?><tr>
										<td />
										<td style="font-size: 12pt; color: red; padding: 2px;">Please
											fill your Password.</td>
									</tr>
								<?php } ?>
									<tr>
										<td></td>
									</tr>
									<tr>
										<td></td>
									</tr>
									<tr>
										<td colspan="2"><input type="submit" value="Log In"
											name="teacher_login" style="width: 240px; height: 25px" /></td>
									</tr>
									<tr></tr>
									<tr></tr>
									<tr></tr>
									<tr></tr>
									<tr></tr>
									<tr></tr>
									<tr></tr>
									<tr></tr>

									<tr>
										<td colspan="2">
											<div style="font-size: 18; color: blue; text-align: center;">
												<a href="forgot_password.php"> Forgot Password? </a>
											</div>
										</td>
									</tr>
									<tr />
									<tr />
									<tr>
										<td colspan="2">
											<div style="font-size: 20; color: blue; text-align: center;">
												<a href="create_teacher_account.php"> Create new Teacher
													account. </a>
											</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>

</body>


</html>