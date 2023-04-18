<!DOCTYPE html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php

	//database connection
	try
	{
		$host = 'localhost';
		$user = 'root';
		$pass = '';
		$db = 'banksystem';
		
		$conn = mysqli_connect($host, $user, $pass, $db);	
	}
	catch(customException $e)
	{
		print $e;
	}
?>

<?php 
	include "convertertool.php";	

	session_start();

	if(!isset($_SESSION['accountNum']))
	{ 	//check if user has logged in
		echo '<script>alert("Please Login First!")
		window.location.href="loginPage.php";
		</script>';
		exit;
	}

	$A_encAccNumber = $_SESSION['accountNum']; //get account number from session

	date_default_timezone_set('Asia/Kuala_Lumpur');
	$today = date('Y-m-d');

	if (!isset($_SESSION['tac'])) 
	{
		// Generate the $tac variable and store it in the session
		$tac = mt_rand(100000, 999999);
		$_SESSION['tac'] = $tac;
	} 
	else 
	{
		// Use the $tac variable from the session
		$tac = $_SESSION['tac'];
	}
?>

<?php
	//get user's full name from user table
	$querygetdetails = "SELECT name FROM user WHERE accountNumber='$A_encAccNumber'";
	$result = mysqli_query($conn, $querygetdetails);
	if ($result) 
	{
		$row = mysqli_fetch_array($result);
		$A_FullName = $row['name'];

		//decrypt user's name
		$A_decrypFNAME = decodeString($A_FullName);
	}
	else 
	{
		echo "Error: " . mysqli_error($conn);
	}	
?>

<?php
	//get account's latest balance from transaction table
	$querygetbal = "SELECT balance FROM transaction WHERE accountNumber ='$A_encAccNumber' ORDER BY transDate ASC";
	$result = mysqli_query($conn, $querygetbal);
	try
	{		
		while(($assocresult = mysqli_fetch_assoc($result)) == True)
		{
			$A_balance = $assocresult['balance'];
			$A_decrypBal = decodeString($A_balance);		
		}				
	}	
	catch(customException $e)
	{
		echo $e->errorMessage();
	}
?>

<?php
	if(!isset($_POST['transferBtn']))
	{
		$field_name = "";
		$field_accnum = "";
		$field_transferamt = "";
		$field_date = "";
		$field_reference = "";
	} 
	else 
	{
		$_SESSION['field_name1'] = $_POST['payeeName'];
		$_SESSION['field_accnum1'] = $_POST['payeeAccNum'];
		$_SESSION['field_amount1'] = $_POST['amount'];
		$_SESSION['field_date1'] = $_POST['date'];
		$_SESSION['field_reference1'] = $_POST['reference'];

		$field_name = $_SESSION['field_name1'];
		$field_accnum = $_SESSION['field_accnum1'];
		$field_transferamt = $_SESSION['field_amount1'];
		$field_date = $_SESSION['field_date1'];
		$field_reference = $_SESSION['field_reference1'];
	} 


	if(isset($_POST['confirmTACBtn']))
	{
		
		$field_name = $_SESSION['field_name1'];
		$field_accnum = $_SESSION['field_accnum1'];
		$field_transferamt = $_SESSION['field_amount1'];
		$field_date = $_SESSION['field_date1'];
		$field_reference = $_SESSION['field_reference1'];
		
	} 
	
?>






<html>
 <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
 <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-2021.css">
 <head>
	<link rel="icon" href="images\logoonly.png"/>
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
		<label style='color:white; font-size:24px; font-weight:bold'><?php echo $A_decrypFNAME; ?></label>
	</div>
	<div class="w3-bar-block w3-center w3-display-bottomright" style='background-color:#7A7F59; width:20%; color:white; height:60%; padding:130px 0'>
		<a href="settingPage.php" class="w3-bar-item w3-button">SETTING</a>
		<br /><br />
		<form method='POST'>
		<input type="submit" class="w3-bar-item w3-button" name="logout" value="LOG OUT"/>
		</form>
	</div>
	<form method='post'>
		<table width='80%' style='background-color:#EBE1D6; border-collapse:collapse'>
			<tr height='70px'>
				<td width='9%'></td>
				<td width='15%'></td>
				<td width='2%'></td>
				<td width='65%'></td>
				<td></td>
			</tr>
			<tr height='40px'>
				<td></td>
				<td>	
					Transfer From
				</td>
				<td></td>
				<td>
					<div class="w3-card-2" style='background-color:white; width:100%; padding:15px'>	
						<label>&emsp;Savings Account-i(Savings)</label>
						&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
						<label>Available Balance &emsp;&emsp; RM <?php echo number_format("$A_decrypBal",2); ?></label>
					</div>
				</td>
			</tr>
			<tr height='80px'>
				<td></td>
				<td>	
					Payee Name
				</td>
				<td></td>
				<td>
					<div class="w3-card-2" style='background-color:white; width:100%; padding:15px 15px 15px 25px'>	
					<input value='<?php echo $field_name; ?>' name='payeeName' type="text" style='width:100%; outline:none; border-top-style: hidden; border-right-style: hidden; border-left-style: hidden; border-bottom-style: hidden' required/>
					</div>
				</td>
				<td></td>
			</tr>
			<tr height='60px'>
				<td></td>
				<td>	
					Account Number
				</td>
				<td></td>
				<td>
					<div class="w3-card-2" style='background-color:white; width:100%; padding:15px 15px 15px 25px'>	
					<input value='<?php echo $field_accnum; ?>' name='payeeAccNum' type="text" style='width:100%; outline:none; border-top-style: hidden; border-right-style: hidden; border-left-style: hidden; border-bottom-style: hidden' required />
					</div>
				</td>
				<td></td>
			</tr>
			<tr height='80px'>
				<td></td>
				<td>	
					Transfer Amount
				</td>
				<td></td>
				<td>
					<div class="w3-card-2" style='background-color:white; width:100%; padding:15px 15px 15px 25px'>	
						<input value='<?php echo $field_transferamt; ?>' name='amount' type="number" style='width:100%; outline:none; border-top-style: hidden; border-right-style: hidden; border-left-style: hidden; border-bottom-style: hidden' required />
					</div>
				</td>
				<td></td>
			</tr>
			<tr height='60px'>
				<td></td>
				<td>	
					Effective Date					
				</td>
				<td></td>
				<td>
					<div class="w3-card-2" style='background-color:white; width:100%; padding:15px 15px 15px 25px'>	
						<input value='<?php echo $field_date; ?>' name='date' type="date"  min='<?php echo $today; ?>' style='width:100%; outline:none; border-top-style: hidden; border-right-style: hidden; border-left-style: hidden; border-bottom-style: hidden' required  />
					</div>
				</td>
				<td></td>
			</tr>
			<tr height='18px'><td colspan='4'></td></tr>
			<tr height='50px'>
				<td></td>
				<td>	
					Recipient Reference
				</td>
				<td></td>
				<td>
					<div class="w3-card-2" style='background-color:white; width:100%; padding:15px 15px 15px 25px'>	
						<input value='<?php echo $field_reference; ?>' name='reference' type="text" style='width:100%; outline:none; border-top-style: hidden; border-right-style: hidden; border-left-style: hidden; border-bottom-style: hidden' required />
					</div>
				</td>
				<td></td>
			</tr>			
		</table>
		<table width='100%' style='background-color:#EBE1D6; border-collapse:collapse'>
			<tr height='20px'>
				<td colspan='4'></td>
				<td width='253px' style='background-color:#7A7F59'></td>
			</tr>
			<tr height='50px'>
				<td colspan='3'></td>
				<td style='text-align:right'>
					<button name="transferBtn" class='w3-button w3-round-large' style='background-color:#36463A; padding:10px 50px 10px 50px; color:white; margin-right:87px'>Transfer</button>
				</td>
				<td width='253px' style='background-color:#7A7F59'></td>
			</tr>			
			<tr height='100px'>
				<td></td>
				<td width='50px'>	
					<label style="margin-left:85px; padding: 0px 0px 0px 0px">Favourites</label>
				</td>
				<td width='90px'></td>
				<td>
					<div class="w3-card-2" style='background-color:white; width:89%; padding:15px 15px 15px 25px'>	
					<?php
						$querygetfaves = "SELECT faveAccNumber, faveAccName FROM favourites WHERE accountNumber='$A_encAccNumber'";
								
						if($r_set = $conn->query($querygetfaves))
						{
							if($r_set->num_rows == 0)
							{
								echo "No favourites yet...";
							}
							else
							{
								echo "<SELECT id='faves' name=faves style='width:96%; outline:none; border-top-style: hidden; border-right-style: hidden; border-left-style: hidden; border-bottom-style: hidden'>";
								echo"<option value='' selected>Select a favourite account</option>";

								while($row=$r_set->fetch_assoc())
								{
									$decodedAccNumber = decodeString($row['faveAccNumber']); 
									$decodedAccName = decodeString($row['faveAccName']);
									$combined = $decodedAccName."&nbsp"." [".$decodedAccNumber."]";

									echo "<option name=faves value='".$decodedAccNumber."' data-name='".$decodedAccName."'>$combined</option>";
								}
							}
							echo "</SELECT>";						
						}
						else {echo $conn->error;}
					?>
					</div>
				</td>
				<td width='253px' style='background-color:#7A7F59'></td>
			</tr>
		</table>
	</form>
 </body>
</html>

<?php
	function validateAccount($accname, $accnumber)
	{
		global $conn;

		$encaccname = encodeString($accname);
		$encaccnumber = encodeString($accnumber);

		$querycheckaccount = "SELECT * FROM user WHERE name = '$encaccname' AND accountNumber = '$encaccnumber'";
		$result = mysqli_query($conn, $querycheckaccount);
		if (mysqli_num_rows($result) > 0) 
		{
			return true;
		} 
		else 
		{
			return false;
		}	
	}

	function transactionA()
	{
		global $field_name;
		global $field_accnum;
		global $field_transferamt;
		global $field_date;
		global $field_reference;

		//Details in POV of A: The User

		$A_transID = mt_rand(10000000,99999999);	//RNG 8 digit number
		$A_enctransID = encodeString($A_transID); 

		global $A_encAccNumber;						

		$A_description = "Transfer to ".$field_name." - ".$field_reference;
		$A_encdescription = encodeString($A_description);

		$A_credit = "0";			
		$A_enccredit = encodeString($A_credit);

		$A_debit = $field_transferamt;
		$A_encdebit = encodeString($A_debit);

		global $A_decrypBal; //type:string
		$A_balance = (int)$A_decrypBal; //convert string to int
		$A_deductvalue = (int)$A_debit; //convert string to int
 		$A_newbalance = $A_balance - $A_deductvalue; //calculate new balance (deduct, since pay bills)
		$A_encnewbalance = encodeString($A_newbalance); //ecrypt new balance

		$A_transdate = $field_date;
		$A_enctransDate = encodeString($A_transdate);

		inserttodbA($A_enctransID,$A_encAccNumber,$A_encdescription,$A_enccredit,$A_encdebit,$A_encnewbalance,$A_enctransDate);
	}

	function transactionB()
	{
		global $field_name;
		global $field_accnum;
		global $field_transferamt;
		global $field_date;
		global $field_reference;
		
		//Details in POV of B: The company
		global $conn;

		$B_transID = mt_rand(10000000,99999999);	//generate random 8-digit trandID
		$B_enctransID = encodeString($B_transID); 

		$encRecipientName = encodeString($field_name); 
		$getBaccnum = "SELECT accountNumber FROM user WHERE name='$encRecipientName'"; //get company's account number from database
		$result = mysqli_query($conn, $getBaccnum);
		if ($result) 
		{
			$row = mysqli_fetch_array($result);
			$B_encAccNumber = $row['accountNumber'];
		}
		else 
		{
			echo "Error: " . mysqli_error($conn);
		}

		global $A_decrypFNAME;
		$B_description = "Received from ".$A_decrypFNAME." - ".$field_reference;
		$B_encdescription = encodeString($B_description);

		$B_credit = $field_transferamt;
		$B_enccredit = encodeString($B_credit);
		
		$B_debit = 0;
		$B_encdebit = encodeString($B_debit);

		//get recipient's latest balance from transaction table
		$querygetbalance = "SELECT balance FROM transaction WHERE accountNumber ='$B_encAccNumber' ORDER BY transDate ASC";
		$result = mysqli_query($conn, $querygetbalance);
		try
		{		
			while(($assocresult = mysqli_fetch_assoc($result)) == True)
			{
				$B_balance = $assocresult['balance'];
				$B_decrypBal = decodeString($B_balance);		
			}				
		}	
		catch(customException $e)
		{
			echo $e->errorMessage();
		}
		$B_balance = (int)$B_decrypBal; //convert string to int
		$B_addvalue = (int)$B_credit;   //convert string to int
 		$B_newbalance = $B_balance + $B_addvalue; //calculate new balance (add, since receive payment)
		$B_encnewbalance = encodeString($B_newbalance); //ecrypt new balance

		$B_transdate = $field_date;
		$B_enctransDate = encodeString($B_transdate);

		inserttodbB($B_enctransID,$B_encAccNumber,$B_encdescription,$B_enccredit,$B_encdebit,$B_encnewbalance,$B_enctransDate);
	}

	function inserttodbA($A_enctransID,$A_encAccNumber,$A_encdescription,$A_enccredit,$A_encdebit,$A_encnewbalance,$A_enctransDate)
	{
		global $conn;

		$addtransactionA = "INSERT INTO transaction VALUES ('$A_enctransID','$A_encAccNumber','$A_encdescription','$A_enccredit','$A_encdebit','$A_encnewbalance','$A_enctransDate')";
		$result = mysqli_query($conn, $addtransactionA);
		if($result) 
		{}
		else 
		{
			echo "Error: " . mysqli_error($conn);
		}
	}

	function inserttodbB($B_enctransID,$B_encAccNumber,$B_encdescription,$B_enccredit,$B_encdebit,$B_encnewbalance,$B_enctransDate)
	{
		global $conn;

		$addtransactionB = "INSERT INTO transaction VALUES ('$B_enctransID','$B_encAccNumber','$B_encdescription','$B_enccredit','$B_encdebit','$B_encnewbalance','$B_enctransDate')";
		$result = mysqli_query($conn, $addtransactionB);
		if ($result) 
		{
			echo '<script>alert("Transfer Made Successfully!"); window.location.href="myAccountPage.php";</script>';
		}
		else 
		{
			echo "Error: " . mysqli_error($conn);
		}
	}

	function checkBalance($currentamt, $transferamt)
	{
		if($currentamt>=$transferamt)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	$(document).ready(function() 
	{
		$('#faves').change(function() 
		{
			var selectedOption = $(this).find(':selected');
			var payeeName = selectedOption.data('name');
			var payeeAccNum = selectedOption.val();
			$('input[name=payeeName]').val(payeeName);
			$('input[name=payeeAccNum]').val(payeeAccNum);
		});
	});
</script>

<html>
<head>
	<style>
		.modal {
			display: none;
			position: fixed;
			z-index: 1;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: auto;
			background-color: rgba(0,0,0,0.4);
		}
		
		.modal-content {
			background-color: #fefefe;
			margin: 15% auto;
			padding: 20px;
			border: 1px solid #888;
			width: 80%;
		}

		.close {
			color: #aaa;
			float: right;
			font-size: 28px;
			font-weight: bold;
		}
		
		.close:hover,
		.close:focus {
			color: black;
			text-decoration: none;
			cursor: pointer;
		}
	</style>
</head>
<body>
	<table width='100%' style='background-color:#EBE1D6; border-collapse:collapse'>
		<tr height='50px'>
			<td colspan='3'></td>
			<!-- Button to trigger the modal -->
			<td style='text-align:right'>
			<button onclick="document.getElementById('myModal').style.display='block'" class='w3-button w3-round-large' style='background-color:#36463A; padding:10px 50px 10px 50px; color:white; margin-left: -212px;'>+ Add Favourites</button>
			</td>
			<td></td>
			<td width='253px' style='background-color:#7A7F59'></td>
		</tr>
	</table>
	
	<!-- The modal form -->
	<div id="myModal" class="modal">
		<div class="modal-content">
			<span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
			<h2>Add New Favourite Account</h2>
			<br/>
			<form method="post">
				<table id="popup">
					<tr>
					<td><label for="accnum">Account Number </label></td>
					<td><input type="text" name="faveaccNum"></td>
					</tr>

					<tr>
					<td style="padding-top: 20px;"><label for="subject">Account Name </label></td>
					<td style="padding-top: 20px;"><input type="text" name="faveaccName"></td>
					</tr>

					<tr>
					<td style="padding-top: 40px;"><input type="submit" name="addfaveBtn" value="Add to Favourites" class='w3-button w3-round-large' style='background-color:#36463A; padding:10px 50px 10px 50px; color:white'/></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	
	<!-- Add JavaScript to close the modal when clicked outside of it -->
	<script>
		var modal = document.getElementById('myModal');
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	</script>
</body>
</html>

<?php
	if(isset($_POST['addfaveBtn']))
	{
		$faveaccNum = $_POST['faveaccNum'];
		$faveaccName = $_POST['faveaccName'];

		//validate that account exists
		$isValid = validateAccount($faveaccName, $faveaccNum); //returns true or false

		if($isValid)
		{
			//add new account to favourites table
			global $conn;

			$faveID = mt_rand(100,999);	//generate random 3-digit faveID
			$encfaveID = encodeString($faveID); 

			global $A_encAccNumber;		

			$encFaveAccNum = encodeString($faveaccNum);
			$encFaveAccName = encodeString($faveaccName);

			$addfaveacc = "INSERT INTO favourites VALUES ('$encfaveID','$A_encAccNumber','$encFaveAccNum','$encFaveAccName')";
			$result = mysqli_query($conn, $addfaveacc);
			if($result) 
			{
				echo "<script>alert('Added to Favourites!');</script>";

				echo "<meta http-equiv='refresh' content='0'>"; //reloads the page to reflect new favourites
			}
			else 
			{
				echo "Error: " . mysqli_error($conn);
			}
		}
		else
		{
			echo "<script>alert('Account does not exist. Please try again.');</script>";
		}
	}
?>


<?php
	if(isset($_POST['transferBtn']))
	{
		$payeename = $_POST['payeeName'];
		$payeeAccNum = $_POST['payeeAccNum'];

		$isValid = validateAccount($payeename, $payeeAccNum); //returns true or false

		if($isValid)
		{
			$currentamt = (int)$A_decrypBal;
			$transferamt = (int)$_POST['amount'];

			$balanceEnough = checkBalance($currentamt, $transferamt);

			if($balanceEnough)
			{
				sendtacEmail();
				
				showTacForm();

				//transactionA();
				//transactionB();
			}
			else
			{
				echo "<script>alert('Sorry, you do not have enough balance to make this transaction!');</script>";
			}
		}
		else
		{
			echo "<script>alert('Payee Name and Account Number do not match any existing record. Please check your inputs and try again.');</script>";
		}
	}
?>

<?php
	function sendtacEmail()
	{
		global $conn;
		global $A_encAccNumber;
		global	$A_decrypFNAME;

		$TAC = $_SESSION['tac'];

		//get user's email from database
		$querygetemail = "SELECT email FROM personalaccount WHERE accountNumber='$A_encAccNumber'";
		$result = mysqli_query($conn, $querygetemail);
		if ($result) 
		{
			$row = mysqli_fetch_array($result);
			$A_encEmail = $row['email'];
			$A_decrypEmail = decodeString($A_encEmail); //decrypt user email
		}
		else 
		{
			echo "Error: " . mysqli_error($conn);
		}	
		
		$subject = "Confirm Transaction: TAC Code Request";
		$body = "Dear $A_decrypFNAME

Thank you for choosing Everbank as your financial partner. We have sent you a TAC (Transaction Authorization Code) to confirm your transaction. 
				
Please enter the following 6-digit TAC code to complete your transaction:

$TAC

Please keep this code confidential and do not share it with anyone, as it is required for authorizing your transaction through our platform.

If you did not request a TAC code from Everbank, please disregard this email and contact our support team immediately.

Thank you for your cooperation.

Best regards,
Everbank";

		$sender = "From:everbankphp2023@gmail.com";

		mail($A_decrypEmail,$subject,$body,$sender);
	}
?>

<?php
	function showTacForm()
	{
		echo "<form method='post'>";
		echo "<table width='100%' style='background-color:#7A7F59; border-collapse:collapse'>";
		echo "<tr height='130px'>";
			echo "<td colspan='3'></td>";
			echo "<td style='text-align:left; color:white'>";
				echo "Enter TAC sent to your email:";
				echo "<input name='tacinput' type='text' style='width:30%; outline:none; border-top-style: hidden; border-right-style: hidden; border-left-style: hidden; border-bottom-style: hidden'  />";
				echo "<br/><br/>";
				echo "<button name='confirmTACBtn' class='w3-button w3-round-large' style='background-color:#36463A; padding:10px 50px 10px 50px; color:white'>Confirm</button>";
			echo "</td>";
			echo "<td></td>";
		echo "</tr>";
		echo "</table>";
		echo "</form";
	}
?>

<?php
	if(isset($_POST['confirmTACBtn']))
	{		
		$TAC = $_SESSION['tac'];

		$tacinput = $_POST['tacinput'];
		$TACinput = (int)$tacinput;

		//echo "TACCODE:".$TAC.gettype($TAC)."<br/>";               //testline
		//echo "TACinput:".$TACinput.gettype($TACinput)."<br/>";	  //testline

		if($TACinput == $TAC)
		{
			//echo "<br/>TAC MATCH!!!! Time to add.";

			transactionA();
			transactionB();
		}
		else
		{
			unset($_SESSION['tac']);
			echo "<script>alert('Incorrect TAC. Please try again.');</script>";
		}
	}

	if(isset($_POST['logout'])){
		session_unset();
		session_destroy();
		echo '<script>window.location.href="loginPage.php";</script>';
		exit();
	}
?>
