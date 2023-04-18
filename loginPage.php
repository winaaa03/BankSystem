<?php
include "converterTool.php";	
session_start();
//ob_start();
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
	<table style='border-collapse:collapse'>
		<tr style='vertical-align:top'>
			<td colspan='2' height='100px'>
				<img src='images\logoName.png' />
			</td>
			<td width='26%'></td>
			<td rowspan='7'>
				<img src='images\family.png' height='647px' />
			</td>
		</tr>
		<tr style='vertical-align:top'>
			<td width='30%'></td>
			<td width='51%' style='text-align:center' height='150px'>
				<h1 style='font-size:40px; font-family:arial; font-weight:bold'>Online Banking</h1>
			</td>			
		</tr>
		<tr style='vertical-align:top'>
			<td></td>
			<td style='horizontal-align:center' height='70px'>
				<div class="w3-green w3-text-white w3-cell" style="width:33%">
					&emsp;Username&emsp;
				</div>
				<div class="w3-cell">
					<input name='txtUsername' class="w3-input w3-border w3-border-light-green" type='text' style='width:150%' required/>
				</div>
			</td>
		</tr>
		<tr style='vertical-align:top'>
			<td></td>
			<td style='horizontal-align:center' height='60px'>
				<div class="w3-green w3-text-white w3-cell" style="width:33%">
					&emsp;Password				
				</div>
				<div class="w3-cell">
					<input type='password' name='txtPassword' class="w3-input w3-border w3-border-light-green" type='text' style='width:150%' required/>
				</div>
			</td>
		</tr>
		<tr style='vertical-align:top'>
			<td></td>
			<td style='text-align:right' height='85px'>
				<a href='forgotPassPage.php' style='text-decoration:none; font-size:14px' class="w3-text-dark-gray">Forgot Password?</a>
			</td>
		</tr>
		<tr style='vertical-align:top' height='60px'>
			<td></td>
			<td style='text-align:center'>
				<button name='btnLogin' type="submit" class="w3-button w3-hover-black w3-medium w3-round-xlarge w3-text-white" style="background-color:#36463A; padding: 2% 20% 2% 20%">Log In</button>
			</td>
		</tr>
		<tr style='vertical-align:top'>
			<td></td>
			<td style='text-align:center'>
				<a style='font-size:14px' class="w3-text-dark-gray">Not registered yet?</a>
				<a href='createAccountPage.php' style='text-decoration:none; font-size:14px' class="w3-text-blue">Create an account</a>
			</td>
		</tr>
	</table>
 </form>
 </body>
</html>

<?php
$loginTries = 3;
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

	if(isset($_POST['btnLogin']) && isset($_POST['txtUsername'])){ //pressed button
		$_SESSION['username'] = $_POST['txtUsername'];
		$username = encodeString($_POST['txtUsername']);
		$pwd = encodeString($_POST['txtPassword']);

		$checkUsername = "SELECT * from user WHERE username='$username'";
		$result = $conn->query($checkUsername);
		$resultCheck = mysqli_num_rows($result);

		$active = encodeString(1);
		$blocked = encodeString(0);

		$checkAccStatus = "SELECT accountStatus FROM user WHERE username = '$username'";
		$accStatusQ = $conn->query($checkAccStatus);
		$statusCheck = mysqli_num_rows($accStatusQ);

		while($row = mysqli_fetch_array($accStatusQ)){
			$accStatus = decodeString($row[0]);
		}

		//if username exists
		if($resultCheck > 0){
			if($accStatus == 0){ //block login for users with accStatus = 0
				echo '<script>alert("Your account login has been blocked. Please reset your password by clicking Forgot Password.")</script>';
				exit;
			}
			//check password
			$checkPass = "SELECT * from user WHERE username='$username' AND password = '$pwd'";
			$loginTry = $conn->query($checkPass);
			$loginCheck = mysqli_num_rows($loginTry);

			//check login count
			$loginCountQuery = "SELECT loginCount FROM user WHERE username = '$username'";
			$loginCountCheck = $conn -> query($loginCountQuery);
			$loginCountVar = mysqli_fetch_array($loginCountCheck);
			$loginCount = (int)decodeString($loginCountVar[0]);
			//echo "login counter:".$loginCount; //testing

				if($loginCheck <= 0){ //wrong password
				    echo '<script>alert("Invalid Password, Try Again!")</script>';
					echo "You have ".$loginTries - $loginCount." login tries left";
					if($loginCount > 2){ //if logincount more than 3, then block user
						$blockAccount = "UPDATE user SET accountStatus='$blocked' WHERE username='$username'"; //set account status to inactive
						$resetLoginCountQ = "UPDATE user SET loginCount='$blocked' WHERE username = '$username'"; //reset to 0 (lazy way)
						$blockAccountS = $conn->query($blockAccount); //block account
						$resetLoginS = $conn->query($resetLoginCountQ); //reset login count
					}
					//add login count
					$loginCount++;
					$updateLoginCount = encodeString((string)$loginCount);
					$updateCountQ = "UPDATE user SET loginCount='$updateLoginCount' WHERE username = '$username'";
					$updateCountS = $conn->query($updateCountQ);
				}else{ //password correct, log user in
					$accountTypeQ = "SELECT accType FROM user WHERE username = '$username'";
					$accountTypeS = $conn -> query($accountTypeQ);
					$accountTypeVar = mysqli_fetch_array($accountTypeS);
					$accountType = (int)decodeString($accountTypeVar[0]);

					$resetCountQ= "UPDATE user SET loginCount='MA==' WHERE username = '$username'"; //reset to 0 (lazy way)
					$resetCountS = $conn->query($resetCountQ);

					//set account number
					$username = encodeString($_SESSION['username']);
					$getAccNumQ = "SELECT accountNumber from user WHERE username='$username'";
					$getAccNumS = mysqli_query($conn, $getAccNumQ);
					$accNumResult = mysqli_fetch_array($getAccNumS);
					$encAccountNum = $accNumResult[0];
					$_SESSION['accountNum'] = $encAccountNum;
					
					$_POST['btnLogin'] = NULL;

					if($accountType == 3){ //admin login
						echo '<script>alert("Login Successful!")
						window.location.href="admin.php";
						</script>';
					}else{
						echo '<script>alert("Login Successful!")
						window.location.href="myAccountPage.php";
						</script>';
					}

				}
		}else{
			echo '<script>alert("Invalid Username!")</script>';
		}

	}

	$conn->close();
	//ob_get_flush();
 ?>

