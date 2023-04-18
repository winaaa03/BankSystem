<?php
    include 'convertertool.php';
	session_start();
	$conn = mysqli_connect('localhost','root','','banksystem');	

	if(!isset($_SESSION['accountNum'])){ //check if user has logged in
		echo '<script>alert("Please Login First!")
		window.location.href="loginPage.php";
		</script>';
		exit;
	 }

	if(!isset($_SESSION['search']) && !isset($_SESSION['type']) && !isset($_SESSION['blockUser']))
	{
		$_SESSION['search']= null;
		$_SESSION['type']= null;
		$_SESSION['blockUser']= null;
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
		<br />
		<input name='searchKey' type='text' style='width:22%' />
		<input name='search' type='submit' value='Search User' style='width:20%; margin-right:5%' />
		<input name='logoutBtn' type='submit' value='Logout' style='width:11%; margin-right:5%'/>
	</div>
	</form>	

	<div style='padding:45px'>
	<form method='post'>
		<table width='100%' class="w3-bordered" width='70%' style='border-collapse:collapse'>
			<tr  style='background-color:grey'>
				<td colspan='9'>
					<div class="w3-bar w3-black">
					  <button class="w3-bar-item w3-button" name='all'>All Users</button>
					  <button class="w3-bar-item w3-button" name='blockUser'>Blocked Users</button>					  
						<div class="w3-dropdown-hover w3-mobile">							
							<label class="w3-button">Account Type <i class="fa fa-caret-down"></i></label>
							<div class="w3-dropdown-content w3-bar-block w3-dark-grey">
								<button class="w3-bar-item w3-button" name='personal'>Personal</button>					
								<button class="w3-bar-item w3-button" name='company'>Company</button>									
								<button class="w3-bar-item w3-button" name='admin'>Admin</button>									
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr style='background-color:#36463A; color:white' height='50px'>
				<td>Account Number</td>
				<td>Username</td>
				<td>Name</td>
				<td>Email</td>
				<td>Phone Number</td>
				<td>Address</td>
				<td>Account Type</td>
				<td></td>
				<td></td>
			</tr>
				<?php
					if(isset($_POST['logoutBtn'])){
						session_unset();
						session_destroy();
						header('Location: loginPage.php');
					}
					if(isset($_POST['view']))
					{
						$_SESSION['account'] = $_POST['view'];
						header('Location:adminEdit.php');
					}
					if(isset($_POST['block']))
					{
						$accountNumber = $_POST['block'];
						$status = 0;
						$sql = "UPDATE user SET accountStatus='".encodeString($status)."' WHERE accountNumber='$accountNumber'";
						mysqli_query($conn, $sql);
					}
					if(isset($_POST['unblock']))
					{
						$accountNumber = $_POST['unblock'];
						$status = 1;
						$sql = "UPDATE user SET accountStatus='".encodeString($status)."' WHERE accountNumber='$accountNumber'";
						mysqli_query($conn, $sql);
						$resetLogin = "UPDATE user SET loginCount='".encodeString('0')."' WHERE accountNumber='$accountNumber'"; //reset loginCount
						mysqli_query($conn, $resetLogin);
					}					
					if(isset($_POST['search']) && $_POST['searchKey'] != null)
					{
						$searchKey = encodeString($_POST['searchKey']);							
						$sqlSearch = "SELECT * FROM user WHERE username='$searchKey'";
						$result = mysqli_query($conn, $sqlSearch);		
						$_SESSION['search'] = $searchKey;
						$_SESSION['blockUser'] = null;
						$_SESSION['type'] = null;
						display($result);
					}
					else
					{
						if(isset($_POST['search']) && $_POST['searchKey'] == null)
						{
							$_SESSION['search'] = null;
						}
						$sql = "SELECT * FROM user";						
						if(isset($_POST['all']))
						{
							$sql = "SELECT * FROM user";
							$_SESSION['blockUser'] = null;
							$_SESSION['type'] = null;			
							$_SESSION['search'] = null;																	
						}
						if(isset($_POST['personal']) ||  $_SESSION['type'] == encodeString(1))
						{
							$_SESSION['search'] = null;
							$_SESSION['type'] = encodeString(1);
							$sql = "SELECT * FROM user WHERE accType='".$_SESSION['type']."'";	
							$_SESSION['blockUser'] = null;							
						}
						if(isset($_POST['company'])|| $_SESSION['type'] == encodeString(2))
						{
							$_SESSION['search'] = null;
							$_SESSION['type'] = encodeString(2);
							$sql = "SELECT * FROM user WHERE accType='".$_SESSION['type']."'";
							$_SESSION['blockUser'] = null;							
						}
						if(isset($_POST['admin'])|| $_SESSION['type'] == encodeString(3))
						{
							$_SESSION['search'] = null;
							$_SESSION['type'] = encodeString(3);
							$sql = "SELECT * FROM user WHERE accType='".$_SESSION['type']."'";
							$_SESSION['blockUser'] = null;							
						}
						if(isset($_POST['blockUser']) || $_SESSION['blockUser']!= null)
						{
							$_SESSION['search'] = null;
							$_SESSION['blockUser'] = "set";
							$sql = "SELECT * FROM user WHERE accountStatus='".encodeString(0)."' AND accType!='".encodeString(3)."'";
							$_SESSION['type'] = null;
						}
						if($_SESSION['search']!= null)
						{
							$searchKey = $_SESSION['search'];
							$sql = "SELECT * FROM user WHERE username='$searchKey'";
						}
						$result = mysqli_query($conn, $sql);
						display($result);							
					}	

				?>
			</tr>
		</table>
	</form>
	</div>
 </body>
 <?php
	function display($result)
	{
		$first_1 = true;
		$first_2 = true;
		$first_3 = true;
		if($_SESSION['search']!= null)
		{			
			if(mysqli_num_rows($result) == 0)
			{
				echo "<tr><td>No matches record found</td></tr>";
			}
			else
			{
				$row = mysqli_fetch_assoc($result);
				$rowColor = "";	
				$conn = mysqli_connect('localhost','root','','banksystem');	
				switch(decodeString($row['accType']))
				{
					case '1': $rowColor = '#FFF4BD'; break;
					case '2': $rowColor = '#FFEBD5'; break;
					case '3': $rowColor = '#E9FFBF'; break;
				}
				echo "<tr style='background-color:".$rowColor."'>";
				echo "<td>".decodeString($row['accountNumber'])."</td>";
				echo "<td>".decodeString($row['username'])."</td>";
				echo "<td>".decodeString($row['name'])."</td>";
				$accountNumbers = $row['accountNumber'];
				if(decodeString($row['accType']) == 1 && $first_1 == true)
				{
					$sql = "SELECT * FROM personalaccount WHERE accountNumber='$accountNumbers'";	
					$result1 = mysqli_query($conn, $sql);	
					$first_1 = false;
				}
				else if(decodeString($row['accType']) == 2 && $first_2 == true)
				{
					$sql = "SELECT * FROM companyaccount WHERE accountNumber='$accountNumbers'";	
					$result2 = mysqli_query($conn, $sql);
					$first_2 = false;				
				}
				else if(decodeString($row['accType']) == 3 && $first_3 == true)
				{
					$sql = "SELECT * FROM adminaccount WHERE accountNumber='$accountNumbers'";
					$result3 = mysqli_query($conn, $sql);			
					$first_3 = false;				
				}			
				switch(decodeString($row['accType']))
				{
					case 1: 
						$row1 = mysqli_fetch_assoc($result1);		
						echo "<td>".decodeString($row1['email'])."</td>";
						echo "<td>".decodeString($row1['hpNumber'])."</td>";
						echo "<td>".decodeString($row1['address'])."</td>";
						break;
					case 2:
						$row2 = mysqli_fetch_assoc($result2);		
						echo "<td>".decodeString($row2['email'])."</td>";
						echo "<td>".decodeString($row2['hpNumber'])."</td>";
						echo "<td>".decodeString($row2['address'])."</td>";
						break;
					case 3:
						$row3 = mysqli_fetch_assoc($result3);		
						echo "<td>".decodeString($row3['email'])."</td>";
						echo "<td>".decodeString($row3['hpNumber'])."</td>";
						echo "<td>".decodeString($row3['address'])."</td>";
						break;			
				}			
				echo "<td>";
				switch(decodeString($row['accType']))
				{
					case '1': echo "personal"; break;
					case '2': echo "company"; break;
					case '3': echo "admin"; break;
				}
				echo "</td>";						
				echo "<td>";
				if(decodeString($row['accType'])!=3)
				{
					switch(decodeString($row['accountStatus']))
					{
						case '0': echo "<button name='unblock' value='".$row['accountNumber']."' style='background-color:#00723B; color:white; border:none'>Unblock</button>"; break;
						case '1': echo "<button name='block' value='".$row['accountNumber']."' style='background-color:#CD0F0F; color:white; border:none'>&ensp;Block&ensp;&nbsp;</button>"; break;
					}
				}
				echo "</td>";	
				if(decodeString($row['accType'])!=3)
				{				
					echo "<td><button name='view' value='".$row['accountNumber']."'>View</button></td>";
				}
				else if($row['accountNumber'] == $_SESSION['accountNum'])
				{
					echo "<td><button name='view' value='".$row['accountNumber']."'>View</button></td>";
				}
				else
				{
					echo "<td></td>";
				}
				echo "</tr>";		
			}				
		}
		else
		{
			while(($row = mysqli_fetch_assoc($result)) != false)
			{
				$rowColor = "";	
				$conn = mysqli_connect('localhost','root','','banksystem');	
				switch(decodeString($row['accType']))
				{
					case '1': $rowColor = '#FFF4BD'; break;
					case '2': $rowColor = '#FFEBD5'; break;
					case '3': $rowColor = '#E9FFBF'; break;
				}
				echo "<tr style='background-color:".$rowColor."'>";
				echo "<td>".decodeString($row['accountNumber'])."</td>";
				echo "<td>".decodeString($row['username'])."</td>";
				echo "<td>".decodeString($row['name'])."</td>";
				if(decodeString($row['accType']) == 1 && $first_1 == true)
				{
					$sql = "SELECT * FROM personalaccount";	
					$result1 = mysqli_query($conn, $sql);	
					$first_1 = false;
				}
				else if(decodeString($row['accType']) == 2 && $first_2 == true)
				{
					$sql = "SELECT * FROM companyaccount";	
					$result2 = mysqli_query($conn, $sql);
					$first_2 = false;				
				}
				else if(decodeString($row['accType']) == 3 && $first_3 == true)
				{
					$sql = "SELECT * FROM adminaccount";
					$result3 = mysqli_query($conn, $sql);			
					$first_3 = false;				
				}			
				switch(decodeString($row['accType']))
				{
					case 1: 
						$row1 = mysqli_fetch_assoc($result1);		
						echo "<td>".decodeString($row1['email'])."</td>";
						echo "<td>".decodeString($row1['hpNumber'])."</td>";
						echo "<td>".decodeString($row1['address'])."</td>";
						break;
					case 2:
						$row2 = mysqli_fetch_assoc($result2);		
						echo "<td>".decodeString($row2['email'])."</td>";
						echo "<td>".decodeString($row2['hpNumber'])."</td>";
						echo "<td>".decodeString($row2['address'])."</td>";
						break;
					case 3:
						$row3 = mysqli_fetch_assoc($result3);		
						echo "<td>".decodeString($row3['email'])."</td>";
						echo "<td>".decodeString($row3['hpNumber'])."</td>";
						echo "<td>".decodeString($row3['address'])."</td>";
						break;			
				}			
				echo "<td>";
				switch(decodeString($row['accType']))
				{
					case '1': echo "personal"; break;
					case '2': echo "company"; break;
					case '3': echo "admin"; break;
				}
				echo "</td>";						
				echo "<td>";
				if(decodeString($row['accType'])!=3)
				{
					switch(decodeString($row['accountStatus']))
					{
						case '0': echo "<button name='unblock' value='".$row['accountNumber']."' style='background-color:#00723B; color:white; border:none'>Unblock</button>"; break;
						case '1': echo "<button name='block' value='".$row['accountNumber']."' style='background-color:#CD0F0F; color:white; border:none'>&ensp;Block&ensp;&nbsp;</button>"; break;
					}
				}
				echo "</td>";	
				if(decodeString($row['accType'])!=3)
				{				
					echo "<td><button name='view' value='".$row['accountNumber']."'>View</button></td>";
				}
				else if($row['accountNumber'] == $_SESSION['accountNum'])
				{
					echo "<td><button name='view' value='".$row['accountNumber']."'>View</button></td>";
				}
				else
				{
					echo "<td></td>";
				}
				echo "</tr>";				
			}
		}
	}
 ?>
</html>