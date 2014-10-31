<?php
session_start ();

if (! isset ( $_POST ['user_name'] )) {
	
	if (! isset ( $_SESSION ['attempt_count'] )) {
		// header ( 'Location: ' . 'home.php' );
		
		$_SESSION ['user_name_correction'] = true;
		
		header ( 'Location: ' . 'home.php' );
	}
}

if (isset ( $_POST ['user_name'] )) {
	
	if (isset ( $_SESSION ['attempt_count'] )) {
		unset ( $_SESSION ['attempt_count'] );
	}
	
	$user_name = $_POST ['user_name'];
} else {
	$user_name = $_SESSION ['user_name'];
}

if(isset($_POST['can_change_passwd'])){
	$can_change_passwd=$_POST['can_change_passwd'];
	$_SESSION['can_change_passwd']=$can_change_passwd;
}


$_SESSION ['user_name'] = $user_name;

$db = mysql_connect ( 'localhost', 'root', '' );
mysql_select_db ( 'student' );

$d = 'SELECT * FROM account_info';
$res = mysql_query ( $d );

$valid_user_name = false;

while ( $row = mysql_fetch_array ( $res ) ) {
	
	if (strcmp ( $user_name, $row [8] ) == 0) {
		$valid_user_name = true;
	}
}

if (! $valid_user_name) {
	$_SESSION ['user_name_correction'] = true;
	$_SESSION ['student_user_name'] = $user_name;
	
	// echo $user_name;
	
	// echo $_SESSION['student_user_name'];
	
	header ( 'Location: ' . 'home.php' );
} 





else {
	/*
	 * if (isset($_SESSION['attempt_count'])){ ?> <script type="text/javascript"> document.getElementById('xcord').innerHTML = "Sorry That 3D Password was incorrect, Please Try Again..!!!!"; </script> <?php }
	 */
	?>




<html>

<head>

<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">

<script type="text/javascript" src="./Resources/SupportLibraries/glMatrix-0.9.5.min.js"></script>

<script type="text/javascript" src="./Resources/SupportLibraries/webgl-utils.js"></script>
<script type="text/javascript" src="threeDpassword.js"></script>

<script id="shader-fs" type="x-shader/x-fragment">
    precision mediump float;

    varying vec2 vTextureCoord;

    uniform sampler2D uSampler;

    void main(void) {
        gl_FragColor = texture2D(uSampler, vec2(vTextureCoord.s, vTextureCoord.t));
    }
</script>

<script id="shader-vs" type="x-shader/x-vertex">
    attribute vec3 aVertexPosition;
    attribute vec2 aTextureCoord;

    uniform mat4 uMVMatrix;
    uniform mat4 uPMatrix;

    varying vec2 vTextureCoord;

    void main(void) {
        gl_Position = uPMatrix * uMVMatrix * vec4(aVertexPosition, 1.0);
        vTextureCoord = aTextureCoord;
    }
</script>


<script type="text/javascript">





	</script>

<style type="text/css">
#loadingtext {
	position: absolute;
	top: 250px;
	left: 150px;
	font-size: 2em;
	color: white;
}
</style>



</head>


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
<h1 style="font-size: 50pt; color: blue; text-align: center;">Enter
	Your <?php if(isset($_SESSION['student_login'])){ echo "current"; } ?> Password <?php if(isset($_SESSION['student_name'])){ echo "once more."; } ?></h1>


<body style="background-color: #aba" onload="webGLStart();">

	<audio autoplay='autoplay'>
		<source src="mff.ogg"></source>
	</audio>

	<div id="xcord" style="color: red; text-align: center; font-size: 20pt"><?php if (isset($_SESSION['attempt_count'])){ echo "Sorry That 3D Password was incorrect, Please Try Again..!!!!"; } else{ ?>Please Make an Interaction.<?php }?></div>
	<div id="ycord" style="color: red; text-align: center; font-size: 20pt"></div>

	<table>

		<tr>
			<td>
				<table>
					<tr>
						<td id="err_pass_msj"
							style="font-size: 12pt; color: red; padding: 2px; visibility: hidden;">Try
							another password.</td>
					</tr>
					<tr id="text_pass_button" style="visibility: visible;">
						<td><input type="button" name="set_passwd"
							value="Textual Password" onclick="set_textual_password()"
							style="width: 150px; height: 30px; color: blue;"></td>
					</tr>
					<tr id="pass1_text" style="visibility: hidden;">
						<td><input type="text" id="pass1" name="passwd1"
							value="       Enter Password" style="color: gray;"
							onClick="password_box_manage(1)"></td>
					</tr>
					<tr id="pass2_text" style="visibility: hidden;">
						<td><input type="text" id="pass2" name="passwd2"
							value="     Reenter Password" style="color: gray;"
							onClick="password_box_manage(2)"></td>
					</tr>
					<tr id="ok_pass_button" style="visibility: hidden;">
						<td>
							<table align="center">
								<tr>
									<td><input type="button" name="passOk" value="Ok.!"
										onclick="check_textual_password()"
										style="width: 50px; height: 30px; color: blue;"></td>
									<td><input type="button" name="passCancel" value="Cancel.!"
										onclick="cancel_textual_password()"
										style="width: 70px; height: 30px; color: red;"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td>

				<table align="center" style="border: 20px groove;">



					<tr>




						<td>


							<canvas id="canv" style="border: none;" width="1000" height="500"></canvas>

							<div id="loadingtext"
								style="margin-left: 450px; margin-top: 100px">Loading
								3D-world...</div>

						</td>
					</tr>
				</table>

			</td>

		</tr>

	</table>

	<table align="center" style="margin-top: 30px;">

		<tr />
		<tr />
		<tr />
		<tr />

		<tr>
			<td><input type="button" value="Submit"
				onClick="submit_selected_password();"
				style="width: 200px; height: 30px"></td>
			<td />
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td>
			
			<td />
			<td><input type="button" value="Cancel" onClick="reload_check();"
				style="width: 200px; height: 30px"></td>
		</tr>


	</table>

	<form name="myform" method="post" action="validate_3d_password.php">


		<input type="hidden" id="password3d" name="password">

	</form>



</body>

</html>

<?php }?>
	