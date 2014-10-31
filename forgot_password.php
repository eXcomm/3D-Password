


<?php

require './Resources/SupportLibraries/PHPMailerAutoload.php';

session_start ();
$already_selected_user_name = false;
$all_clear = false;
$form1_correction_required = false;
$form2_correction_required = false;
$form3_correction_required = false;
$form4_correction_required = false;
$accountType="tmp";
$can_send_mail=false;
$mailID="tmp";
$name="tmp";
$missing = array ();

if(!isset($_SESSION['accountType'])){

	$_SESSION['accountType']="tmp";
}

if(!isset($_SESSION['can_reset_password'])){
	$_SESSION['can_reset_password']=false;
}

if (isset ( $_POST ['form1'] )) {
	
	foreach ( $_POST as $key => $value ) {
		$tmp = is_array ( $value ) ? $value : trim ( $value );
		if (empty ( $tmp )) {
			$missing [] = $key;
			$$key = '';
			$form1_correction_required = true;
		} else {
			$$key = $tmp;
		}
	}
	$_SESSION['user_name']=$user_name;
}


if (isset ( $_POST ['form2'] )) {

	foreach ( $_POST as $key => $value ) {
		$tmp = is_array ( $value ) ? $value : trim ( $value );
		if (empty ( $tmp )) {
			$missing [] = $key;
			$$key = '';
			$form2_correction_required = true;
		} else {
			$$key = $tmp;
		}
	}
}

if (isset ( $_POST ['form3'] )) {

	foreach ( $_POST as $key => $value ) {
		$tmp = is_array ( $value ) ? $value : trim ( $value );
		if (empty ( $tmp )) {
			$missing [] = $key;
			$$key = '';
			$form3_correction_required = true;
		} else {
			$$key = $tmp;
		}
	}
}


if (isset ( $_POST ['form4'] )) {

	foreach ( $_POST as $key => $value ) {
		$tmp = is_array ( $value ) ? $value : trim ( $value );
		if (empty ( $tmp )) {
			$missing [] = $key;
			$$key = '';
			$form4_correction_required = true;
		} else {
			$$key = $tmp;
		}
	}
}

if(!$form1_correction_required and isset ( $_POST ['form1'] ) and isset ( $_POST ['acc_type'] ) ){
	if(strcmp($acc_type,"Student")==0){
		$db = mysql_connect ( 'localhost', 'root', '' );
		mysql_select_db ( 'student' );
		$d = 'SELECT * FROM account_info';
		$res = mysql_query ( $d );
		
		while ( $row = mysql_fetch_array ( $res ) ) {
		
			if (strcmp ( $user_name, $row [8] ) == 0) {
					
				$seq_ques=$row [9];
				
				$_SESSION['seq_ques']=$seq_ques;
			}
		}
		if(!isset($seq_ques)){
			$missing [] = "user_name";
			$form1_correction_required=true;
		}
	}
	else{
		$db = mysql_connect ( 'localhost', 'root', '' );
		mysql_select_db ( 'teacher' );
		$d = 'SELECT * FROM account_info';
		$res = mysql_query ( $d );
		$correct=false;
		while ( $row = mysql_fetch_array ( $res ) ) {
		
			if (strcmp ( $user_name, $row [7] ) == 0) {
				$mailID=$row[2];
				$name=$row[0];
				$can_send_mail=true;
				$accountType="Teacher";
				
				$_SESSION['accountType']="Teacher";
				
				$correct=true;
				
			}
		}
		
		if(!$correct){
			$missing [] = "user_name";
			$form1_correction_required=true;
		}
		
		
	}
}

if(!$form2_correction_required and isset ( $_POST ['form2'] ) and isset ( $_POST ['seq_ans'] )  ){
	
	$db = mysql_connect ( 'localhost', 'root', '' );
	mysql_select_db ( 'student' );
	$d = 'SELECT * FROM account_info';
	$res = mysql_query ( $d );
	
	$correct=false;
	
	while ( $row = mysql_fetch_array ( $res ) ) {
	
		if (strcmp ( $_SESSION['user_name'], $row [8] ) == 0) {
			if (strcmp ( $seq_ans, $row [10] ) == 0){
				$correct=true;
				$mailID=$row [3];
				$name=$row[0];
			}
		}
	}
	if(!$correct){
		$form2_correction_required=true;
		$missing[]="seq_ans";
	}
	else{
		$can_send_mail=true;
		$accountType="Student";
		
		$_SESSION['accountType']="Student";
	}
}

if($can_send_mail){
	

	$random_string=get_random_string();
	
	$_SESSION['random_string'] = $random_string;
	
	//echo $random_string;
	
	//echo '<br/>';
	
	//echo $mailID;
	
	

	$mail = new PHPMailer;
	
	$mail->isSMTP();                                      
	$mail->Host = 'smtp.gmail.com';                       
	$mail->SMTPAuth = true;                               
	$mail->Username = 'authenticationd@gmail.com';                  
	$mail->Password = '9961719738';               
	$mail->SMTPSecure = 'tls';                            
	$mail->Port = 587;                                    
	$mail->setFrom('authenticationd@gmail.com', '3D Password Authentication');     
	$mail->addAddress($mailID);  
	$mail->WordWrap = 50;                                 
	$mail->isHTML(true);                                  
	
	$mail->Subject = 'Security Code For Password Resetting';
	$mail->Body    = 'Hai <b>' . $name . ' ,</b> <br/><br/> Here we are sending the security code for Password Resetting... <br/> <br/> <b>Security Code :  <i>  ' . $random_string . '</i></b> <br/> <br/> <br/>             ----  <b>The 3D-Password Team(<i>Nithin,Harish,Arjun</i>). </b>';

	
	
	if(!$mail->send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
		exit;
	}
	
	
	
}

if(isset($_POST['form3']) and !$form3_correction_required ){
	
	if( strcmp($_POST['key'],$_SESSION['random_string']) == 0 ){
		
		if ((strcmp($_SESSION['accountType'], "Student"))==0){
			
			$_SESSION['can_reset_password'] = true;
			
			header ( 'Location: ' . 'reset_student_password.php' );
		}
		
		elseif ((strcmp($_SESSION['accountType'], "Teacher"))==0){
				
			$_SESSION['can_reset_password'] = true;
				
			//header ( 'Location: ' . 'reset_teacher_password.php' );
		}
		
	}
	
}


if(!$form4_correction_required and isset($_POST['form4'])){
	
	if (! empty ( $password1 ) && ! empty ( $password2 ) && (strcmp ( $password1, $password2 ) == 0)) {
		
		$salt = openssl_random_pseudo_bytes ( 6 );
		$new_password = $password1 . $salt;
		$salted_password = md5 ( $new_password );
		
		
		$db = mysql_connect ( 'localhost', 'root', '' );
		mysql_select_db ( 'teacher' );
		
		$q = sprintf ( "UPDATE account_info SET Password='%s',Salt='%s' WHERE UserName='%s'", $salted_password,$salt,$_SESSION['user_name']);
		
		//echo $q;
		
		$t=mysql_query ( $q );
		
		$q = sprintf ( "SELECT Name FROM account_info WHERE UserName='%s'", $_SESSION['user_name']);
		
		echo $q;
		
		$t=mysql_query ( $q );
		
		$row = mysql_fetch_array ( $t );
		$_SESSION['account_password_reseted']=true;
		$_SESSION['reset_acc_name']=$row[0];
		unset($_SESSION['can_reset_password']);
		
		header ( 'Location: ' . 'home.php' );
		
		
		
		
		
	} else {
		$correction_required = true;
		$missing [] = 'password1';
		$missing [] = 'password2';
	}
	
}


function get_random_string(){
	$alphabet=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	$str='';
	for($i=0;$i<10;$i++){
		$j=mt_rand(0,25);
		$str=$str . $alphabet[$j];
	}
	return $str;
	
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

	<form method="post" action=<?php echo $_SERVER['PHP_SELF'] ?>>

		<table align="center"
			style="background-color: #ffbf48; border: 5px groove white; width: 22.5cm;">
			<tr>
				<td colspan="2"><b>
						<div style="font-size: 40pt; color: Green; text-align: center;"> Forgot Your Password...??? </div>
				</b></td>

			</tr>


			<tr>
				<td colspan="2"><hr color="white"></hr></td>
			</tr>
			
			
<?php 

		if(isset($_SESSION['accountType']) and isset($_SESSION['can_reset_password'])) {
			if ((((strcmp($_SESSION['accountType'], "Teacher")) == 0 ) and $_SESSION['can_reset_password'] and !$form3_correction_required and isset($_POST['form3']) ) )   {?>
		
		
		
				<tr><td>
			<table align="center">
			
			<tr><td colspan="2"><div style="font-size: 20pt; color: blue; text-align: center;" > Please Set Your Password. </div></td></tr>
			
			<tr><td colspan="2"><hr/></td></tr>
			
			</table>

			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
	

			<tr><td>
			<table align="center">
			<tr>
			<td style="font-size: 20px;">Enter a Password :</td>
			<td><input type="password" name="password1" size="40px" /></td>
						
			</tr>
			<?php if(in_array('password1', $missing)){ ?>
			<tr>
			<td />
			<td style="font-size: 12pt; color: red; padding: 2px;">Please Enter a Password.</td>
			</tr>
			<?php } ?>
			<tr>
			<td style="font-size: 20px;">Type Password again :</td>
			<td><input type="password" name="password2" size="40px" /></td>
						
			</tr>
			<?php if(in_array('password2', $missing)){ ?>
			<tr>
			<td />
			<td style="font-size: 12pt; color: red; padding: 2px;">Please ReEnter a Password.</td>
			</tr>
			<?php } ?>
			</table>
			<table align="center" >
			<tr>
			<td>
			<input type="submit"  name='form4' value='Submit' style="width: 100px; height: 30px; margin-left: 40px" ></td></tr>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			</table>
			</td></tr>
		
		
		
			
<?php }  else { if ($can_send_mail )  {?>
		<tr><td>
			<table align="center">
			<tr>
			<td>
			<div style="font-size: 18pt; color: red; text-align: center;" >Please Check Your Mail Box. Enter the key which already sent to your E-Mail ID.</div>
			</td>
			</tr>
			</table>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>

			<tr><td>
			<table align="center">
			<tr>
			<td style="font-size: 20px;">Key :</td>
			<td><input type="text" name="key" size="40px" /></td>
						
			</tr>
			<?php if(in_array('key', $missing)){ ?>
			<tr>
			<td />
			<td style="font-size: 12pt; color: red; padding: 2px;">Please Provide the Key./td>
			</tr>
			<?php } ?>
			</table>
			<table align="center" >
			<tr>
			<td>
			<input type="submit"  name='form3' value='Submit' style="width: 100px; height: 30px; margin-left: 40px" ></td></tr>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			</table>
			</td></tr>
					
			<?php } elseif((!isset ( $_POST ['form1'] ) or $form1_correction_required or !isset($_POST ['acc_type']))  and (!isset ( $_POST ['form2'] ) and !$form2_correction_required) ) {?>
			
			<tr><td>

			<table align="center" class="block">
						<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr>
			
			
			<td>

			<input type="radio" name="acc_type" class="largerCheckbox" value="Student">
			</td>
			<td><b> <div style="font-size: 15pt; color : blue"> Student </div>  </b></td>
			</tr>	
			<tr/><tr/><tr/>
			<tr>

			<td>
			
			<input type="radio" name="acc_type" class="largerCheckbox" value="Teacher">
			</td>
			<td><b> <div style="font-size: 15pt; color : blue"> Teacher </div>  </b></td>
			</tr>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			</table>
			<table align="center">
			

			<tr>
			<td style="font-size: 15pt;"><b>User Name :</b></td>
			<td><input type="text" name="user_name" size="30px" 								
								<?php
								if (isset($form1_correction_required) and $form1_correction_required) {
									echo 'value="' . $user_name . '"';
								}
								?> >
			</td></tr>
			<?php if(in_array('user_name', $missing)){ ?>
			<tr>
							<td />
							<td style="font-size: 12pt; color: red; padding: 2px;">Please
								fill User name.</td>
						</tr>
			<?php } ?>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>

			</table>
			<table align="center" >
			<tr>
			<td>
			<input type="submit"  name='form1' value='Submit' style="width: 100px; height: 30px; margin-left: 40px" onclick="if(this.form.acc_type.value=='Student' || this.form.acc_type.value=='Teacher'){}else{alert('You must Select Your Account Type.')}"></td></tr>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			</table>
			<?php } elseif ((!isset ( $_POST ['form2'] ) and !$form1_correction_required and isset ( $_POST ['form1']  )) or (isset($_POST ['form2']) and $form2_correction_required ) )  {?>
		<tr><td>
			<table align="center">
			
			<tr><td colspan="2"><div style="font-size: 20pt; color: blue; text-align: center;" > Security Question </div></td></tr>
			
			<tr><td colspan="2"><hr/></td></tr>
			
			</table>
			<table align="center">
			<tr>
			<td>
			<div style="font-size: 18pt; color: red; text-align: center;" ><?php if(isset($seq_ques)){ echo $seq_ques;} else{echo $_SESSION['seq_ques'];} ?></div>
			</td>
			</tr>
			</table>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>

			<tr><td>
			<table align="center">
			<tr>
			<td style="font-size: 20px;">Answer :</td>
			<td><input type="text" name="seq_ans" size="40px" /></td>
						
			</tr>
			<?php if(in_array('seq_ans', $missing)){ ?>
			<tr>
			<td />
			<td style="font-size: 12pt; color: red; padding: 2px;">Please Provide an Answer</td>
			</tr>
			<?php } ?>
			</table>
			<table align="center" >
			<tr>
			<td>
			<input type="submit"  name='form2' value='Submit' style="width: 100px; height: 30px; margin-left: 40px" ></td></tr>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			<tr/><tr/><tr/>
			</table>
			</td></tr>
					
			<?php } } } ?>

			
		</table>
</form>	
</body>
</html>