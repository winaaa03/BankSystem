<?php
 	include "converterTool.php";
	$noException = true;
	try
	{
		$host = 'localhost';
		$user = 'root';
		$pass = '';
		$db = 'banksystem';
		
		$conn = mysqli_connect($host, $user, $pass, $db);	
	}
	catch(customException $e){
		print $e;
	}


	function verifyUsername()
	{
		echo "<br /><br />";
		echo "<img src='images/exclamationMark.png' width='10%' />	";
		echo "<br /><br />";
		echo "<h3 class='w3-sans-serif' style='font-weight:bold'>Forgot Password</h3>";
		echo "<p class='w3-text-dark-gray' style='padding: 0px 40px 0px 40px'>Enter your username and we'll send you a link to reset your password via email</p>";
		echo "<br />";
		echo "<div class='w3-container' style='margin: 0px 50px 0px 50px'>";
		echo "<label for='txtUsername' class='w3-green w3-text-white' style='display:table-cell; padding: 5px 8px 5px 8px'>Username</label>";
		echo "<span style='display:table-cell'><input name='txtUsername' class='w3-input w3-border w3-border-light-green' style='width:115%' type='text' required/></span>				";
		echo "</div>";
		echo "<br />";
		echo "<button name='btnCont' class='w3-button w3-medium w3-round-xlarge w3-text-white' style='background-color:#36463A ;padding: 1% 30% 1% 30%'>Continue</button>";
		echo "<br /><br /><br />";
		echo "<a href='loginPage.php' style='text-decoration:none' class='w3-text-dark-gray'>< Back to Login</a>";
	}
	
	function securityQuestion($secQString)
	{
		$username=$_POST['txtUsername'];
		echo "<br /><br />";
		echo "<h3 class='w3-sans-serif w3-text-green' style='font-weight:bold; letter-spacing: 2px'>Hello, ".$username."!</h3>";
		echo "<input name='hiddenuser' value='$username' hidden />";
		echo "<br />";
		echo "<div class='w3-container' style='margin: 0px 80px 0px 80px; text-align:left'>";
		echo "<label for='txtQuestion' style='font-weight:bold'>Security Question</label>";
		echo "<br /><br />";
		echo "<input name='txtQuestion' class='w3-input w3-border w3-border-light-green' value='$secQString' style='width:100%' type='text' disabled />";
		echo "<br />";
		echo "<label for='txtAnswer' style='font-weight:bold'>Your Answer</label>";
		echo "<br /><br />";
		echo "<input name='txtAnswer' class='w3-input w3-border w3-border-light-green' style='width:100%' type='text' />";
		echo "<br />";
		echo "<button name='btnReset' class='w3-button w3-medium w3-text-white' style='background-color:#36463A ;padding: 1% 25% 1% 25%'>RESET PASSWORD</button>";
		echo "</div>";
		echo "<br /><br />";
		echo "<a href='loginPage.php' style='text-decoration:none' class='w3-text-dark-gray'>< Back to Login</a>";
	}

	function sendemail($email, $uname){
	//	$receiver = "i21020061@student.newinti.edu.my"; //who is the receiver of the email
		$subject = "Reset Password Link for your Everbank account";
		$body = "Hello, you have requested to reset your password. Please click this link to reset your password: http://localhost/everbank/changePassPage.php?id=" . "$uname"."
		
		
Sincerely, Everbank" ; //content of the email
		$sender = "From:everbankphp2023@gmail.com";
		mail($email,$subject,$body,$sender);

		// if(mail($email,$subject,$body,$sender)){
		// 	echo "Email successfully sent";
		// }else{
		// 	echo "";
		// }
	}
?>
<!DOCTYPE html>
<html>
 <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
 <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-2021.css">
 <head>
	<link rel="icon" href="images\logoonly.png"/>
	<title>Everbank</title>
 </head>
 <body>
 <form method='post'>
	<table style='border-collapse:collapse' width='100%' height='100%'>
		<tr height='100px' style='vertical-align:top'>
			<td style='background-color:#36463A' colspan='3'>
				<img src='images\logoNameWhite.png' width='10%' />				
			</td>
		</tr>
		<tr height='180px' style='vertical-align:top'>
			<td style='background-color:#36463A' width='32.5%'>&nbsp;</td>
			<td class='w3-card w3-white' width='35%' rowspan='2' style='text-align:center'>
			<?php 

			$username = "";
			$encAccNum = "";

			if(isset($_POST['btnCont'])){
				$uVar = $_POST['txtUsername'];
				$username = encodeString($uVar);
				$checkUsername = "SELECT * from user WHERE username='$username'";
				$result = $conn->query($checkUsername);
				$resultCheck = mysqli_num_rows($result);

				if($resultCheck > 0) //username exists
				{
					$_POST['btnCont'] = NULL;

					//retreive security question and answer
					$getSecQuestionQ = "SELECT securityQn from user WHERE username='$username'";
					$getSecQS = $conn->query($getSecQuestionQ);
					$SecQVar = mysqli_fetch_array($getSecQS);
					$getSecQCheck = mysqli_num_rows($getSecQS);
					$secQString = "";

					$secQ = (int)decodeString($SecQVar[0]);
					switch ($secQ) {
						case '1':
							$secQString = "In what city were you born?";
							break;
						case '2':
							$secQString = "What was your favorite food as a child?";
							break;
						case '3':
							$secQString = "What is the name of your favorite pet?";
							break;
						default:
							$secQString = "No Security Question set";
							break;
						}
					
					securityQuestion($secQString);
				}else{
					$_POST['btnCont'] = NULL;
					echo '<script>alert("Username Does Not Exist")</script>';
					verifyUsername();
				}
			}else{
				verifyUsername();
			}
			//send reset password email and account number if security answer is correct
			if(isset($_POST['btnReset'])){
				$ans = encodeString($_POST['txtAnswer']);
				$username = encodeString($_POST['hiddenuser']);
				
				$getAnsQ = "SELECT * from user WHERE username='$username'AND answer='$ans'";
				$getAnsS = $conn->query($getAnsQ);
				$ansVar = mysqli_fetch_array($getAnsS);
				$getAnsCheck = mysqli_num_rows($getAnsS);

				$getAccNumQ= "SELECT accountNumber from user WHERE username='$username'";
				$getAccS = $conn->query($getAccNumQ);
				$accVar = mysqli_fetch_array($getAccS);
				$encAccountNum = $accVar[0];
				
				if($getAnsCheck > 0){ //if answer is correct
					$getEmailQ = "SELECT email from personalaccount WHERE accountNumber='$encAccountNum'";
					$getEmailAnsS = $conn->query($getEmailQ);
					while($row = mysqli_fetch_array($getEmailAnsS)){
						$email = decodeString($row[0]);
					}
					//echo $email." ".$username;
					sendemail($email, $username); //send email
					echo '<script>alert("Email Sent! Please reset your password with the gieven link")
					window.location.href="loginPage.php";</script>';
				}else{
					$_POST['btnReset'] = NULL;
					echo '<script>alert("Wrong Answer. Please try again!")</script>';
				}

			}

			?>	
			</td>
			<td style='background-color:#36463A' width='32.5%'>&nbsp;</td>
		</tr>
		<tr height='300px'>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
 </form>
 </body>
</html>