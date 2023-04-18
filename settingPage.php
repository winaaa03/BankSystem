<!DOCTYPE html>
 <?php 	
 include "converterTool.php";
 session_start();
 if(!isset($_SESSION['accountNum'])){ //check if user has logged in
	echo '<script>alert("Please Login First!")
	window.location.href="loginPage.php";
	</script>';
	exit;
 }
	$_SESSION['button_value'] = false;
	$encAccountNum = $_SESSION['accountNum'];
	$Mobile='';
	$Email='';
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
 ?>
 
 
 <?php
		//get name and balance
		$sql = "SELECT name FROM user WHERE accountNumber ='$encAccountNum'";
		$result = mysqli_query($conn, $sql);
		
		if(mysqli_num_rows($result)==0)
		{
			echo "no matched found";
		}
		else{
			try{		
				while(($assocresult = mysqli_fetch_assoc($result)) == True)
				{
					$encName = $assocresult['name'];
					$lblUsername = decodeString($encName);		
				}				
			}	
			catch(customException $e){
				echo $e->errorMessage();
			}
		}
?>
 
 
<html>
 <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
 <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-2021.css">
 <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
 <head>
	<link rel="icon" href="images\logoonly.png"/s>
	<title>Everbank</title>
 </head>
 <body>
	<img src='images\nameonly.png' height='70px' />
	<div class="w3-padding w3-display-topright" style='width:77%; background-color:#7A7F59; color:white; height:70px'>
		<a href="myAccountPage.php" class="w3-bar-item w3-button">MY ACCOUNTS</a>
		<a href="payPage.php" class="w3-bar-item w3-button">PAY</a>
		<a href="transferPage.php" class="w3-bar-item w3-button">TRANSFER</a>
	</div>
	<div class="w3-bar-block w3-display-topright" style='background-color:#36463A; width:20%; height:60%; padding:75px 0; text-align:center'>
		<h4 style='color:white'>Good Day,</h4>
		<br />
		<label style='color:white; font-size:24px; font-weight:bold'><?php echo $lblUsername; ?></label>
	</div>
	<div class="w3-bar-block w3-center w3-display-bottomright" style='background-color:#7A7F59; width:20%; color:white; height:60%; padding:130px 0 260px'>
		<a href="settingPage.php" class="w3-bar-item w3-button">SETTING</a>
		<br /><br />
	<form method='post'>
		<input type="submit" class="w3-bar-item w3-button" name="logout" value="LOG OUT"/>
	</div>
		<table width='80%' style='background-color:#EBE1D6; border-collapse:collapse'>
			<tr height='120px'>
				<td width='10%'></td>
				<td colspan='4'>
					<label style='font-size:18px; font-weight:bold; font-family:sans-serif'>My Settings</label>
				</td>
			</tr>
			<tr height='495px' style='vertical-align:top'>
				<td></td>
				<td width='19%'>
					<?php 
						$color = '#A7AB7D';							
						if(isset($_POST['email'])||isset($_POST['updateEmail'])||$_SESSION['button_value'] == true)
						{
							$colors = '#A7AB7D';	
							$color = 'white';	
						}
						else
						{
							$color = '#A7AB7D';
							$colors = 'white';	
						}
					?>
					<div class="w3-bar-block w3-white" style='width:80%'>
					  <button name='contact' class="w3-bar-item w3-button w3-hover-lime" style='background-color:<?php echo $color; ?>'>Contact Number</button>
					  <button name='email' class="w3-bar-item w3-button w3-hover-lime" style='background-color:<?php echo $colors; ?>'>Email Address</button>
					</div>
				</td>
				<td style='text-align:left'>
					<?php
						if(isset($_POST['email'])||isset($_POST['updateEmail'])||$_SESSION['button_value'] == true)
						{
							$_SESSION['button_value'] == false;
							email();														
						}
						else
						{
							contact();	
						}
					?>
				</td>
				<td width='10%'>					
				</td>
			</tr>
		</table>
	</form>
	<?php		
		function contact()
		{
			//dupliacte connection and retrieve session value
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
			
			$encAccountNum = $_SESSION['accountNum'];
			try
			{
				$sql = "SELECT * FROM user WHERE accountNumber ='$encAccountNum'";
				$result = mysqli_query($conn, $sql);
				
				if(mysqli_num_rows($result)==0)
				{
					echo "no matched found";
				}
				else{
					$assocresult = mysqli_fetch_assoc($result);

					switch(decodeString($assocresult['accType']))
					{
						case 1 : 
							$sql = "SELECT * FROM personalaccount WHERE accountNumber ='$encAccountNum'";								
							$result = mysqli_query($conn, $sql);
							$assocresult = mysqli_fetch_assoc($result);
							$encMobile = $assocresult['hpNumber'];
							$Mobile = decodeString($encMobile);

							if(isset($_POST['updateContact']))
							{
								$contactNumber = $_POST['contactNumber'];
								$encContactNumber = encodeString($contactNumber);
								try{
									$sql= "UPDATE personalaccount SET  hpNumber='$encContactNumber' WHERE accountNumber ='$encAccountNum'";
									$result = mysqli_query($conn, $sql);
									$Mobile = $contactNumber;
									echo "<div class='w3-panel w3-green' style='margin-top:0px'>";
									echo "<h3>Success!</h3>";
									echo " <p>Contact Number Updated Successfully</p>";
									echo "</div>";
								}
								catch(customException $e){
									echo "<div class='w3-panel w3-red' style='margin-top:0px'>";
									echo "<h3>Failed!</h3>";
									echo "<p>Contact Number Update Unsuccessfully.<br/>/nPlease report to EverBank, Thank You.</p>";
									echo "</div>";
								}	
							}
							break;
							
						case 2 :
							$sql = "SELECT * FROM companyaccount WHERE accountNumber ='$encAccountNum'";
							$result = mysqli_query($conn, $sql);
							$assocresult = mysqli_fetch_assoc($result);
							$encMobile = $assocresult['hpNumber'];
							$Mobile = decodeString($encMobile);	
							
							if(isset($_POST['updateContact']))
							{
								$contactNumber = $_POST['contactNumber'];
								$encContactNumber = encodeString($contactNumber);
								try{
									$sql= "UPDATE companyaccount SET  hpNumber='$encContactNumber' WHERE accountNumber ='$encAccountNum'";
									$result = mysqli_query($conn, $sql);
									$Mobile = $contactNumber;
									echo "<div class='w3-panel w3-green' style='margin-top:0px'>";
									echo "<h3>Success!</h3>";
									echo " <p>Contact Number Updated Successfully</p>";
									echo "</div>";
								}
								catch(customException $e){
									echo "<div class='w3-panel w3-red' style='margin-top:0px'>";
									echo "<h3>Failed!</h3>";
									echo "<p>Contact Number Update Unsuccessfully.<br/>/nPlease report to EverBank, Thank You.</p>";
									echo "</div>";
								}	
							}
							break;
					}				
				}
			}
			catch(customException $e)
			{
				print $e;
			}	
			echo "<div class='w3-card-2' style='background-color:white; height:400px'>";
			echo "<table width='100%' style='border-collapse:collapse'>";
			echo "<tr style='background-color:#36463A;' height='60px'>";
			echo "<td width='5%'></td>";
			echo "<td colspan='2' style='color:white'>Contact Number</td>";			
			echo "</tr>";
			echo "<tr height='100px'>";
			echo "<td></td>";
			echo "<td style='text-align:right'>";
			echo "<button name='updateContact' class='w3-button w3-border'>UPDATE</button>";
			echo "</td>";
			echo "<td width='5%'></td>";
			echo "</tr>";
			echo "</table>";
			echo "<table class='w3-bordered' width='82%' style='margin: 30px 10px 10px 70px; border-collapse:collapse'>";
			echo "<tr style='background-color:black; color:white'>";
			echo "<td width='10%'></td>";
			echo "<td>";
			echo "CONTACT TYPE";
			echo "</td>";
			echo "<td>";
			echo "CONTACT NUMBER";
			echo "</td>";
			echo "</tr>";
			echo "<tr height='50px'>";
			echo "<td></td>";			
			echo "<td>Mobile</td>";
			echo "<td>";
			echo "<input name='contactNumber' value='$Mobile' style='border-top-style:hidden; border-right-style:hidden; width:100%; border-left-style:hidden; border-bottom-style:hidden'  />";
			echo "</td>";
			echo "</tr>";
			echo "</table>";
			echo "</div>";		
		}		
		
		function email()
		{
			//dupliacte connection and retrieve session value
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
			
			$encAccountNum = $_SESSION['accountNum'];
			try
			{
				$sql = "SELECT * FROM user WHERE accountNumber ='$encAccountNum'";
				$result = mysqli_query($conn, $sql);
				
				if(mysqli_num_rows($result)==0)
				{
					echo "no matched found";
				}
				else{
					$assocresult = mysqli_fetch_assoc($result);
					switch(decodeString($assocresult['accType']))
					{	
						case 1 : 
							$sql = "SELECT * FROM personalaccount WHERE accountNumber ='$encAccountNum'";								
							$result = mysqli_query($conn, $sql);
							$assocresult = mysqli_fetch_assoc($result);
							$encEmail = $assocresult['email'];
							$Email = decodeString($encEmail);
							$_SESSION['button_value'] = true;
							

							if(isset($_POST['updateEmail']))
							{
								$email = $_POST['emailAddress'];
								$encEmail = encodeString($email);
								try{
									$sql= "UPDATE personalAccount SET  email='$encEmail' WHERE accountNumber ='$encAccountNum'";
									$result = mysqli_query($conn, $sql);
									$Email = $email;
									echo "<div class='w3-panel w3-green' style='margin-top:0px'>";
									echo "<h3>Success!</h3>";
									echo " <p>Email Updated Successfully</p>";
									echo "</div>";
								}
								catch(customException $e){
									echo "<div class='w3-panel w3-red' style='margin-top:0px'>";
									echo "<h3>Failed!</h3>";
									echo "<p>Email Update Unsuccessfully.<br/>/nPlease report to EverBank, Thank You.</p>";
									echo "</div>";
								}	
							}
							else
							{
								$_SESSION['button_value'] = false;
							}
							break;
							
						case 2 :
							$sql = "SELECT * FROM companyaccount WHERE accountNumber ='$encAccountNum'";
							$result = mysqli_query($conn, $sql);
							$assocresult = mysqli_fetch_assoc($result);
							$encEmail = $assocresult['email'];
							$Email = decodeString($encEmail);
							
							if(isset($_POST['updateEmail']))
							{
								$email = $_POST['emailAddress'];
								$encEmail = encodeString($email);
								try{
									$sql= "UPDATE companyaccount SET  email='$encEmail' WHERE accountNumber ='$encAccountNum'";
									$result = mysqli_query($conn, $sql);
									$Email = $email;
									echo "<div class='w3-panel w3-green' style='margin-top:0px'>";
									echo "<h3>Success!</h3>";
									echo " <p>Email Updated Successfully</p>";
									echo "</div>";
								}
								catch(customException $e){
									echo "<div class='w3-panel w3-red' style='margin-top:0px'>";
									echo "<h3>Failed!</h3>";
									echo "<p>Email Update Unsuccessfully.<br/>/nPlease report to EverBank, Thank You.</p>";
									echo "</div>";
								}	
							}
							else
							{
								$_SESSION['button_value'] = false;
							}
							break;
					}				
				}
				
			}
			catch(customException $e)
			{
				print $e;
			}
			
			
			echo "<div class='w3-card-2' style='background-color:white; height:400px'>";
			echo "<table width='100%' style='border-collapse:collapse'>";
			echo "<tr style='background-color:#36463A;' height='60px'>";
			echo "<td width='5%'></td>";
			echo "<td colspan='2' style='color:white'>Email Address</td>";			
			echo "</tr>";
			echo "<tr height='100px'>";
			echo "<td></td>";
			echo "<td style='text-align:right'>";
			echo "<button name='updateEmail' class='w3-button w3-border'>UPDATE</button>";
			echo "</td>";
			echo "<td width='5%'></td>";
			echo "</tr>";
			echo "</table>";
			echo "<table class='w3-bordered' width='82%' style='margin: 30px 10px 10px 70px; border-collapse:collapse'>";
			echo "<tr style='background-color:black; color:white'>";
			echo "<td width='10%'></td>";
			echo "<td>";
			echo "DESCRIPTION";
			echo "</td>";
			echo "<td>";
			echo "EMAIL ADDRESS";
			echo "</td>";
			echo "</tr>";
			echo "<tr height='50px'>";
			echo "<td></td>";			
			echo "<td>Personal Email</td>";
			echo "<td>";
			echo "<input name='emailAddress' value='$Email' style='border-top-style:hidden; width:100%; border-right-style:hidden; border-left-style:hidden; border-bottom-style:hidden'  />";
			echo "</td>";
			echo "</tr>";
			echo "</table>";
			echo "</div>";				
		}

		if(isset($_POST['logout'])){
			session_unset();
			session_destroy();
			echo '<script>window.location.href="loginPage.php";</script>';
		}
	?>
 </body>
</html>