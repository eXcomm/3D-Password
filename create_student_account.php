<?php
session_start ();
$already_selected_user_name = false;
$all_clear = false;
$correction_required = false;
$missing = array ();

if (isset ( $_POST ['send'] )) {
	
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
	
	if(!empty($gender) && (strcmp($gender,'Select') == 0)){
		$correction_required = true;
		$missing [] = 'gender';
	}
	if(!empty($department) && (strcmp($department,'Select Option') == 0)){
		$correction_required = true;
		$missing [] = 'department';
	}
	
	if (! $correction_required && isset ( $_POST ['accept_all'] )) {
		$db = mysql_connect ( 'localhost', 'root', '' );
		mysql_select_db ( 'student' );
		if (insert ( $db, $name, $reg_number, $address, $email, $phone, $dob, $gender, $department, $user_name, $seq_ques, $seq_ans )) {
			$_SESSION['name']=$name;
			$_SESSION['user_name']=$user_name;
			header ( 'Location: ' . 'set_your_password.php' );
		}
		mysql_close ();
	} else {
		$correction_required = true;
	}
}
function insert($db, $name, $reg_number, $address, $email, $phone, $dob, $gender, $department, $user_name, $seq_ques, $seq_ans) {
	global $all_clear;
	global $correction_required;
	global $missing;
	global $already_selected_user_name;
	$d = 'SELECT * FROM account_info';
	$res = mysql_query ( $d );
	$exist = 'false';
	
	while ( $row = mysql_fetch_array ( $res ) ) {
		
		if (strcmp ( $user_name, $row [8] ) == 0) {
			
			$exist = 'true';
		}
	}
	
	if ($exist == 'true') {
		$correction_required = true;
		//echo "sds";
		$already_selected_user_name = true;
	} else {
		//echo "qwe";
		$q = sprintf ( "INSERT INTO account_info VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','null','null')", $name, $reg_number, $address, $email, $phone, $dob, $gender, $department, $user_name, $seq_ques, $seq_ans );
		$t=mysql_query ( $q );
		//echo $q;
		//echo $t;
		$all_clear = true;
		return true;
	}
}

?>


<html>
<style type="text/css">
<!--
input.largerCheckbox {
	width: 20px;
	height: 20px;
}
//
-->
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


	<form method="post" action=<?php echo $_SERVER['PHP_SELF'] ?>>
		<table align="center"
			style="background-color: #bbe; border: 5px groove white; width: 22.5cm;">
			<tr>
				<td colspan="2"><b>
						<div style="font-size: 40pt; color: Green; text-align: center;">Create
							New Student Account</div>
				</b></td>

			</tr>


			<tr>
				<td colspan="2"><hr color="white"></hr></td>
			</tr>
			<tr>
				<td>
					<table align="center">
<?php if($all_clear){ ?>
<tr>
							<td colspan="2" bgcolor="#99ff33"><div align="center"
									style="font-size: 18pt; color: red; border: 1px dashed white;">Your
									account has been created.</div></td>
						</tr>
<?php } ?>

<?php if($correction_required){ ?>
<tr>
							<td colspan="2" bgcolor="#99ff33"><div align="center"
									style="font-size: 18pt; color: red; border: 1px dotted white;">Please
									make corrections on your form.</div></td>
						</tr>
<?php } ?>
<tr></tr>
						<tr></tr>
						<tr></tr>
						<tr>
							<td style="font-size: 20px;">Name :</td>
							<td><input type="text" name="name" size="40px"
								<?php
								if ($correction_required) {
									echo 'value="' . $name . '"';
								}
								?> /></td>
						</tr>
<?php if(in_array('name', $missing)){ ?>
<tr>
							<td />
							<td style="font-size: 12pt; color: red; padding: 2px;">Please
								fill your Name.</td>
						</tr>
<?php } ?>





						<tr>
							<td style="font-size: 20px;">Register Number :</td>
							<td><input type="text" name="reg_number" size="40px"
								<?php
								if ($correction_required) {
									echo 'value="' . $reg_number . '"';
								}
								?> /></td>
						</tr>
<?php if(in_array('reg_number', $missing)){ ?>
<tr>
							<td />
							<td style="font-size: 12pt; color: red; padding: 2px;">Please
								fill your Register Number.</td>
						</tr>
<?php } ?>


<tr>
							<td style="font-size: 20px;">Address :</td>
							<td><textarea name="address" style="width: 275px; height: 80px"><?php
							
							if ($correction_required) {
								echo $address;
							}
							?></textarea></td>
						</tr>
<?php if(in_array('address', $missing)){ ?>
<tr>
							<td />
							<td style="font-size: 12pt; color: red; padding: 2px;">Please
								fill your Address.</td>
						</tr>
<?php } ?>
<tr>
							<td style="font-size: 20px;">Email :</td>
							<td><input type="email" name="email" size="40px"
								<?php
								if ($correction_required) {
									echo 'value="' . $email . '"';
								}
								?> /></td>
						</tr>
<?php if(in_array('email', $missing)){ ?>
<tr>
							<td />
							<td style="font-size: 12pt; color: red; padding: 2px;">Please
								fill your Email.</td>
						</tr>
<?php } ?>
<tr>
							<td style="font-size: 20px;">Phone :</td>
							<td><input type="number" name="phone" size="40px"
								<?php
								if ($correction_required) {
									echo 'value="' . $phone . '"';
								}
								?> /></td>
						
						
						<tr>
<?php if(in_array('phone', $missing)){ ?>					
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						<tr>
							<td />
							<td style="font-size: 12pt; color: red; padding: 2px;">Please
								fill your Phone.</td>
						</tr>
<?php } ?>
<tr>
							<td style="font-size: 20px;">Birthday :</td>
							<td><input type="date" name="dob" size="40px"
								<?php
								if ($correction_required) {
									echo 'value="' . $dob . '"';
								}
								?> /></td>
						</tr>
<?php if(in_array('dob', $missing)){ ?>
<tr>
							<td />
							<td style="font-size: 12pt; color: red; padding: 2px;">Please
								fill your Birthday.</td>
						</tr>
<?php } ?>
<tr>
							<td style="font-size: 20px;">Gender :</td>
							<td><select name="gender">
									<option
										<?php if($correction_required && $gender=='Select'){echo 'selected="selected"';  $missing[]='gender'; } ?>>Select</option>
									<option
										<?php if($correction_required && $gender=='Male'){echo 'selected="selected"'; } ?>>Male</option>
									<option
										<?php if($correction_required && $gender=='Female'){echo 'selected="selected"'; } ?>>Female</option>
							</select></td>
						</tr>
<?php if(in_array('gender', $missing)){ ?>
<tr>
							<td />
							<td style="font-size: 12pt; color: red; padding: 2px;">Please
								select your Gender.</td>
						</tr>
<?php } ?>
<tr>
							<td style="font-size: 20px;">Department :</td>
							<td><select name="department">
									<option
										<?php if($correction_required && $department=='Select Option.'){echo 'selected="selected"'; $missing[]='department'; } ?>>Select
										Option.</option>
									<option
										<?php if($correction_required && $department=='Department of Electronics and Communication'){echo 'selected="selected"'; } ?>>Department
										of Electronics and Communication</option>
									<option
										<?php if($correction_required && $department=='Department of Information Technology'){echo 'selected="selected"'; } ?>>Department
										of Information Technology</option>
									<option
										<?php if($correction_required && $department=='Department of Computer Science'){echo 'selected="selected"'; } ?>>Department
										of Computer Science</option>
									<option
										<?php if($correction_required && $department=='Department of Mechanical Engineering'){echo 'selected="selected"'; } ?>>Department
										of Mechanical Engineering</option>
							</select></td>
						</tr>
<?php if(in_array('department', $missing)){ ?>
<tr>
							<td />
							<td style="font-size: 12pt; color: red; padding: 2px;">Please
								select your Department.</td>
						</tr>
<?php } ?>
<tr>
							<td style="font-size: 20px;">Select User Name :</td>
							<td><input type="text" name="user_name" size="40px"
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
								fill User name.</td>
						</tr>
<?php } ?>
<?php if($already_selected_user_name){ ?>
<tr>
							<td />
							<td style="font-size: 12pt; color: red; padding: 2px;">User name
								already exsists,Please Select another one.</td>
						</tr>

<?php } ?>


						<tr>
							<td style="font-size: 20px;">Security Question :</td>
							<td><textarea name="seq_ques" style="width: 275px; height: 80px"><?php
							
							if ($correction_required) {
								echo $seq_ques;
							}
							?></textarea></td>
						</tr>
						<?php if(in_array('seq_ques', $missing)){ ?>
						<tr>
							<td />
							<td style="font-size: 12pt; color: red; padding: 2px;">Please
								Enter a sequirity Question.</td>
						</tr>
						<?php } ?>
						<tr>
							<td style="font-size: 20px;">Answer :</td>
							<td><input type="text" name="seq_ans" size="40px"
								<?php
								if ($correction_required) {
									echo 'value="' . $seq_ans . '"';
								}
								?> />
						
						</tr>
						<?php if(in_array('seq_ans', $missing)){ ?>
						<tr>
							<td />
							<td style="font-size: 12pt; color: red; padding: 2px;">Please
								provide an Answer.</td>
						</tr>
						<?php } ?>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td colspan="2" style="font-size: 14pt"><input type="checkbox"
								class="largerCheckbox" name="accept_all"
								style="margin-left: 50px; align: right" /> Accept all terms and
								conditions of this website.</td>
						</tr>

						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td><input type='button'
								onClick="window.location='create_student_account.php'"
								value='Reset' style="width: 100px; height: 30px"></td>
							<td><input type="submit"
								onclick="if(!this.form.accept_all.checked){alert('You must accept your terms and condition first.')}"
								name='send' value='Submit' style="width: 280px; height: 30px"></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>



