<?php
	include 'convertertool.php';
	session_start();
	$conn = mysqli_connect('localhost','root','','banksystem');	
	$accountNumber = $_SESSION['account'];
	if(!isset($_SESSION['accountNum'])){ //check if user has logged in
		echo '<script>alert("Please Login First!")
		window.location.href="loginPage.php";
		</script>';
		exit;
	}
	 
	function updateMsg($updateResult)
	{
		if(isset($updateResult)&&$updateResult)
		{
			echo "<div class='w3-panel w3-green' style='margin:0px'>";
			echo "<button class='w3-button' type='submit' style='font-size:20px;margin-left:98%'>x</button>";
			echo "<h3 style='margin-top:-20px'>Success!</h3>";
			echo " <p>The details have been updated succesfully.</p>";
			echo "</div>";
			$updateResult = false;
		}
		else
		{
			echo "<div class='w3-panel w3-red' style='margin:0px'>";
			echo "<button class='w3-button' type='submit' style='font-size:20px;margin-left:98%'>x</button>";
			echo "<h3 style='margin-top:-20px'>Failed!</h3>";
			echo "<p>Failed to update details.<br/>Please report to IT supports, Thank You.</p>";
			echo "</div>";
		}
	}
	
	function resetMsg($resetResult,$defaultPass)
	{		
		if(isset($resetResult)&&$resetResult)
		{
			echo "<div class='w3-panel w3-green' style='margin:0px'>";
			echo "<button class='w3-button' type='submit' style='font-size:20px;margin-left:98%'>x</button>";
			echo "<h3 style='margin-top:-20px'>Success!</h3>";
			echo " <p>The password has been reset to $defaultPass.</p>";
			echo "</div>";
			$resetResult = false;
		}
		else
		{
			echo "<div class='w3-panel w3-red' style='margin:0px'>";
			echo "<button class='w3-button' type='submit' style='font-size:20px;margin-left:98%'>x</button>";
			echo "<h3 style='margin-top:-20px'>Failed!</h3>";
			echo "<p>Failed to reset password.<br/>Please report to IT supports, Thank You.</p>";
			echo "</div>";
		}
	}
	
	function update($accType)
	{
		global $conn;
		global $accountNumber;
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		switch($accType)
		{
			case 1: $sql = "UPDATE personalaccount SET email='".encodeString($email)."', hpNumber='".encodeString($phone)."',address='".encodeString($address)."' WHERE accountNumber='".$accountNumber."'";									
					break;
			case 2: $sql = "UPDATE companyaccount SET email='".encodeString($email)."', hpNumber='".encodeString($phone)."',address='".encodeString($address)."' WHERE accountNumber='".$accountNumber."'";									
					break;
			case 3: $sql = "UPDATE adminaccount SET email='".encodeString($email)."', hpNumber='".encodeString($phone)."',address='".encodeString($address)."' WHERE accountNumber='".$accountNumber."'";									
					$password = $_POST['pwd'];
					$sqlPass = "UPDATE user SET password='".encodeString($password)."' WHERE accountNumber='".$accountNumber."'";
					mysqli_query($conn,$sqlPass);
					break;
		}
		$updateResult = mysqli_query($conn,$sql);		
		updateMsg($updateResult);		
	}
	
	function resetPass($accType)
	{
		global $conn;
		global $accountNumber;
		$sql = "SELECT accType FROM user WHERE accountNumber='".$accountNumber."'";
		$result = mysqli_fetch_row(mysqli_query($conn,$sql));
		switch($accType)
		{
			case 1: $sql = "SELECT * FROM personalaccount WHERE accountNumber='".$accountNumber."'";
					$user = mysqli_fetch_assoc(mysqli_query($conn,$sql));
					$subDob = substr(decodeString($user['DOB']),-2);
					$subIC = substr(decodeString($user['ICNumber']),-4);		
					$defaultPass = $subDob.$subIC;						
					break;
			case 2: $defaultPass = "default123"; 
					break;
		}			
		$sql = "UPDATE user SET password='".encodeString($defaultPass)."' WHERE accountNumber='".$accountNumber."'";
		$resetResult = mysqli_query($conn,$sql);
		resetMsg($resetResult,$defaultPass);
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
	<img src='images\nameonly.png' height='70px' />
	<form method='post'>
	<div class="w3-padding w3-display-topright" style='width:77%; background-color:#7A7F59; height:70px; text-align:right; '>
	</div>
		<?php		
		$sql = "SELECT accType FROM user WHERE accountNumber='".$accountNumber."'";
		$accType = mysqli_fetch_row(mysqli_query($conn,$sql));
		$accType = decodeString($accType[0]);
		if(isset($_POST['reset']))
		{
			resetPass($accType);
		}
		if(isset($_POST['update']))
		{
			update($accType);
		}		
		$sql = "SELECT * FROM user WHERE accountNumber='$accountNumber'";
		$data = mysqli_fetch_assoc(mysqli_query($conn,$sql));
	?>
	<br />
	<a class='w3-button' href='admin.php' style='margin-left:5px;text-decoration:none'>< Back</a>
	<div style='margin: 0px 30px 0px 30px'>
		<table>
			<tr>
				<td colspan='2'><h4 class='w3-sans-serif' style='font-weight:bold'>View User Information</h4></td>
			</tr>
			<tr>
				<td style='padding-right: 30px'><label class='w3-serif' style='color:#36463A; font-size:14px'>Account Number : </label></td>
				<td><label class='w3-serif' style='color:#36463A; font-size:14px'><?php echo decodeString($data['accountNumber']) ?></label></td>
			</tr>
			<tr>
				<td><label class='w3-serif' style='color:#36463A; font-size:14px'>Account Type : </label></td>
				<td>
					<label class='w3-serif' style='color:#36463A; font-size:14px'>
						<?php
							switch($accType)
							{
								case 1: echo "Personal"; 
										break;
								case 2: echo "Company"; 
										break;
								case 3: echo "Admin"; 
										break;
							}
						?>
					</label>
				</td>
			</tr>
			<tr>
				<td><label class='w3-serif' style='color:#36463A; font-size:14px'>Username : </label></td>
				<td><label class='w3-serif' style='color:#36463A; font-size:14px'><?php echo decodeString($data['username']) ?></label></td>
			</tr>
			<tr>
				<td><label class='w3-serif' style='color:#36463A; font-size:14px'>Name : </label></td>
				<td><label class='w3-serif' style='color:#36463A; font-size:14px'><?php echo decodeString($data['name']) ?></label></td>
			</tr>
		</table>
		<br/>
		<h6 class='w3-sans-serif' style='border-bottom: 1px solid #36463A;color:#36463A;font-weight:bold'>Change Details</h6>
		<table width='100%' class='w3-striped w3-serif' style='border-collapse:collapse;line-height:30px'>
			<?php
			$status = decodeString($data['accountStatus']);
			switch ($accType)
			{
				case 1: 
					$sql = "SELECT * FROM personalaccount WHERE accountNumber='$accountNumber'";
					$result = mysqli_fetch_assoc(mysqli_query($conn,$sql));
					echo "<tr>";
					echo "<td style='font-weight:bold'>Date of Birth</td>";
					echo "<td>".decodeString($result['DOB'])."</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Email</td>";
					echo "<td><input type='email' name='email' value='".decodeString($result['email'])."' style='height:10%;width:40%' required /></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Phone number</td>";
					echo "<td><input type='text' name='phone' value='".decodeString($result['hpNumber'])."' style='height:10%' required /></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>IC number</td>";
					echo "<td>".decodeString($result['ICNumber'])."</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Address</td>";
					echo "<td><input type='text' name='address' value='".decodeString($result['address'])."' style='height:10%' required /></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Status</td>";
					echo "<td><label  style='color:".($status==0 ? 'red' : 'green')."'>";
					echo $status== 0 ? "Blocked" : "Active";
					echo "</label></td>";
					echo "</tr>";		
					echo "<tr>";
					echo "<td style='font-weight:bold'>Password</td>";
					echo "<td><button type='submit' class='w3-sans-serif' name='reset' style='font-size:12px; padding:0px 2px 0px 2px'>Reset to default</button></td>";
					echo "</tr>";
					break;
				case 2: 
					$sql = "SELECT * FROM companyaccount WHERE accountNumber='$accountNumber'";
					$result = mysqli_fetch_assoc(mysqli_query($conn,$sql));
					echo "<tr>";
					echo "<td style='font-weight:bold'>Registration Number</td>";
					echo "<td>".decodeString($result['registrationNumber'])."</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Email</td>";
					echo "<td><input type='email' name='email' value='".decodeString($result['email'])."' style='height:10%;width:40%' required /></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Phone number</td>";
					echo "<td><input type='text' name='phone' value='".decodeString($result['hpNumber'])."' style='height:10%' required /></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Address</td>";
					echo "<td><input type='text' name='address' value='".decodeString($result['address'])."' style='height:10%' required /></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Status</td>";
					echo "<td><label  style='color:".($status==0 ? 'red' : 'green')."'>";
					echo $status== 0 ? "Blocked" : "Active";
					echo "</label></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Password</td>";
					echo "<td><button type='submit' class='w3-sans-serif' name='reset' style='font-size:12px; padding:0px 2px 0px 2px'>Reset to default</button></td>";
					echo "</tr>";
					break;
				case 3:
					$sql = "SELECT * FROM adminaccount WHERE accountNumber='$accountNumber'";
					$result = mysqli_fetch_assoc(mysqli_query($conn,$sql));
					echo "<tr>";
					echo "<td style='font-weight:bold'>Date of Employment</td>";
					echo "<td>".decodeString($result['dateOfEmployment'])."</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Position</td>";
					echo "<td>".decodeString($result['position'])."</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Salary</td>";
					echo "<td>RM ".decodeString($result['salary'])."</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Date of Birth</td>";
					echo "<td>".decodeString($result['DOB'])."</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Email</td>";
					echo "<td><input type='email' name='email' value='".decodeString($result['email'])."' style='height:10%;width:40%' required /></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Phone number</td>";
					echo "<td><input type='text' name='phone' value='".decodeString($result['hpNumber'])."' style='height:10%' required /></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>IC number</td>";
					echo "<td>".decodeString($result['ICNumber'])."</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Address</td>";
					echo "<td><input type='text' name='address' value='".decodeString($result['address'])."' style='height:10%' required /></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='font-weight:bold'>Status</td>";
					echo "<td><label  style='color:".($status==0 ? 'red' : 'green')."'>";
					echo $status== 0 ? "Blocked" : "Active";
					echo "</label></td>";
					echo "</tr>";			
					echo "<tr>";
					echo "<td style='font-weight:bold'>Password</td>";
					echo "<td><input type='password' name='pwd' value='".decodeString($data['password'])."' style='height:10%' required /></td>";
					echo "</tr>";
					break;
			}
			?>			
		</table>
		<br />
		<input type='submit' class='w3-sans-serif' name='update' value='Update' style='font-size:14px' />
	</div>
	</form>	
 </body>
</html>