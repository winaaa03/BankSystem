<?php
	include "converterTool.php";
?>


<?php
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
	
	$username = $_GET['id'];
	$unameDisplay = decodeString($username);
	//set account number
	$getAccNumQ = "SELECT accountNumber from user WHERE username='$username'";
	$getAccNumS = mysqli_query($conn, $getAccNumQ);
	$accNumResult = mysqli_fetch_array($getAccNumS);
	$encAccountNum = $accNumResult[0];

	$notification='';
	
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
 
	<table width='100%' style='border-collapse: collapse'>
		<tr height='50px'>
			<td colspan='2'>
				<img src='images\logoName.png' />
			</td>
			<td style='background-color:#36463A; width:40%'rowspan='11'></td>
		</tr>	
		<tr>
			<td width='5%' rowspan='10'>&nbsp;</td>
			<td>
				<br />
				<h2 style='font-family:arial; font-weight:bold'>Reset Password</h2>
			</td>
		</tr>
		<tr>
			<td class="w3-text-dark-gray">
				<br />
				Password Requirement:
				<ul>
					<li>Minimum 8 alphanumeric characters, maximum 12 characters</li>
					<li>Must contain at least 1 upper case, 1 lower case and 1 number</li>
					<li>Must not contain space</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<label for='txtUsername' style='font-weight:bold'>Username</label>				
			</td>
		</tr>
		<tr>
			<td>
				<label class='w3-white' name='txtUsername' type='text' style='border-top-style:hidden; border-right-style:hidden; border-left-style:hidden; border-bottom-style:hidden' disabled><?php echo "$unameDisplay" ?></label>
			</td>
		</tr>
		<tr>
			<td>
				<br />
				<label for='txtNewPwd' style='font-weight:bold'>Create new password</label>				
			</td>
		</tr>
		<tr>
			<td>
				<input name='txtNewPwd' type='password' required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,12}$"/>
			</td>
		</tr>
		<tr>
			<td>
				<br />
				<label for='txtConfirmPwd' style='font-weight:bold'>Confirm new password</label>				
			</td>
		</tr>
		<tr>
			<td>
				<input name='txtConfirmPwd' type='password' required="required"/>
			</td>
		</tr>
		
		 <?php
			//validate new pass = confirm pass
			if(isset($_POST['btnSubmit']))
			{
				$newPass = $_POST['txtNewPwd'];
				$conPass = $_POST['txtConfirmPwd'];
				$encNewPass = encodeString($newPass);
				if($newPass != $conPass)
				{
					//$notification = "<div class='w3-panel w3-green'><br/><h3>Success!</h3><br/><p>Contact Number Updated Successfully</p><br/></div>";
					$notification = "<div class='w3-panel w3-yellow' style='width:96%;height:3%'><br/><h3>Warning!</h3><br/><p>New Password and Confirm Password does not match.</p><br/></div>";
				}
				else
				{
					$sql= "UPDATE user SET password='$encNewPass' WHERE accountNumber ='$encAccountNum'";
					$result = mysqli_query($conn, $sql);

					//reset user account status to active and loginCount to 0
					$blockAccount = "UPDATE user SET accountStatus='MQ==' WHERE username='$username'"; //set account status to active (1)
					$resetLoginCountQ = "UPDATE user SET loginCount='MA==' WHERE username = '$username'"; //reset loginCount to 0 
					$blockAccountS = $conn->query($blockAccount); //block account
					$resetLoginS = $conn->query($resetLoginCountQ); //reset login count
					$notification = "<div class='w3-panel w3-green' style='width:96%;height:3%'><br/><h3>Success!</h3><br/><p>Password Changed Successfully</p><br/><p>Please close this window and Login again</p><br/></div>";
				}			
			}	
		?>
		
		<tr>
			<td>
				<label name="lbl1" style='font-size:12px'><?php echo "$notification";?></label>
			</td>
		</tr>
		<tr>
			<td>
				<br /><br />
				<button name='btnSubmit' class="w3-button w3-hover-black w3-medium w3-round-xlarge w3-text-white" style="background-color:#36463A; padding: 1% 5% 1% 5%">Submit</button>
			</td>
		</tr>
		<tr height='72px'>
			<td>&nbsp;</td>
		</tr>
	<table>
	
	
	
 </form>
 </body>
</html>