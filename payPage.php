<!DOCTYPE html>
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
	include 'convertertool.php';
	session_start();

	if(!isset($_SESSION['accountNum']))
	{ 	//check if user has logged in
		echo '<script>alert("Please Login First!")
		window.location.href="loginPage.php";
		</script>';
		exit;
	}

	//get account number from session
	$A_encAccNumber = $_SESSION['accountNum'];
	
	date_default_timezone_set('Asia/Kuala_Lumpur');
	$today = date('Y-m-d');
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
				<td width='10%'></td>
				<td width='10%'></td>
				<td width='2%'></td>
				<td width='65%'></td>
				<td></td>
			</tr>
			<tr height='50px'>
				<td></td>
				<td>	
					Pay From
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
			<tr height='100px'>
				<td></td>
				<td>	
					Pay To
				</td>
				<td></td>
				<td>
					<div class="w3-card-2" style='background-color:white; width:100%; padding:15px 15px 15px 25px'>	
					<?php
						$querygetcompanies = "SELECT name FROM user WHERE accType='Mg=='"; //accType=2 aka company
								
						if($r_set = $conn->query($querygetcompanies))
						{
							echo "<SELECT name=company style='width:100%; outline:none; border-top-style: hidden; border-right-style: hidden; border-left-style: hidden; border-bottom-style: hidden' required>";
							while($row=$r_set->fetch_assoc())
							{
								$decodedcomp = decodeString($row['name']); //decode the company name
								echo "<option name=company value=\"$decodedcomp\">$decodedcomp</option>";
							}
							echo "</SELECT>";						
						}
						else {echo $conn->error;}
					?>
					</div>
				</td>
				<td></td>
			</tr>
			<tr height='50px'>
				<td></td>
				<td>	
					Pay Amount
				</td>
				<td></td>
				<td>
					<div class="w3-card-2" style='background-color:white; width:100%; padding:15px 15px 15px 25px'>	
						<input name='amount' type="number" style='width:100%; outline:none; border-top-style: hidden; border-right-style: hidden; border-left-style: hidden; border-bottom-style: hidden' required />
					</div>
				</td>
				<td></td>
			</tr>
			<tr height='100px'>
				<td></td>
				<td>	
					Effective Date
				</td>
				<td></td>
				<td>
					<div class="w3-card-2" style='background-color:white; width:100%; padding:15px 15px 15px 25px'>	
						<input name='date' type="date"  min='<?php echo $today; ?>' style='width:100%; outline:none; border-top-style: hidden; border-right-style: hidden; border-left-style: hidden; border-bottom-style: hidden' required/>
					</div>
				</td>
				<td></td>
			</tr>
			<tr height='40px'>
				<td colspan='5'></td>
			</tr>			
			<tr height='50px'>
				<td colspan='3'></td>
				<td style='text-align:right'>
					<button name="payBtn" class='w3-button w3-round-large' style='background-color:#36463A; padding:10px 50px 10px 50px; color:white'>Pay</button>
				</td>
				<td></td>
			</tr>
			<tr height='38px'>
				<td></td>
			</tr>
		</table>
	</form>
 </body>
</html>

<?php
	if(isset($_POST['payBtn']))
	{
		$currentamt = (int)$A_decrypBal;
		$transferamt = (int)$_POST['amount'];

		echo "currentamt: ".$currentamt."<br/>";  //testline
		echo "transferamt: ".$transferamt."<br/>"; //testline

		$isEnough = checkBalance($currentamt, $transferamt);

		if($isEnough)
		{
			transactionA();
			transactionB();
		}
		else
		{
			echo "<script>alert('Sorry, you do not have enough balance to make this transaction!');</script>";
		}
	}

	function transactionA()
	{
		//Details in POV of A: The User
		
		$A_transID = mt_rand(10000000,99999999);	//RNG 8 digit number
		$A_enctransID = encodeString($A_transID); 

		global $A_encAccNumber;						

		$A_description = "Pay bills to ".$_POST['company'];
		$A_encdescription = encodeString($A_description);

		$A_credit = "0";			
		$A_enccredit = encodeString($A_credit);

		$A_debit = $_POST['amount'];
		$A_encdebit = encodeString($A_debit);

		global $A_decrypBal; //type:string
		$A_balance = (int)$A_decrypBal; //convert string to int
		$A_deductvalue = (int)$A_debit; //convert string to int
 		$A_newbalance = $A_balance - $A_deductvalue; //calculate new balance (deduct, since pay bills)
		$A_encnewbalance = encodeString($A_newbalance); //ecrypt new balance

		$A_transdate = $_POST['date'];
		$A_enctransDate = encodeString($A_transdate);

		inserttodbA($A_enctransID,$A_encAccNumber,$A_encdescription,$A_enccredit,$A_encdebit,$A_encnewbalance,$A_enctransDate);
	}

	function transactionB()
	{
		//Details in POV of B: The company
		global $conn;

		$B_transID = mt_rand(10000000,99999999);	//generate random 8-digit trandID
		$B_enctransID = encodeString($B_transID); 

		$encCompName = encodeString($_POST['company']); 
		$getBaccnum = "SELECT accountNumber FROM user WHERE name='$encCompName'"; //get company's account number from database
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
		$B_description = "Bill payment from ".$A_decrypFNAME;
		$B_encdescription = encodeString($B_description);

		$B_credit = $_POST['amount'];
		$B_enccredit = encodeString($B_credit);
		
		$B_debit = 0;
		$B_encdebit = encodeString($B_debit);

		//get company's latest balance from transaction table
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

		$B_transdate = $_POST['date'];
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
			echo '<script>alert("Paid Successfully!"); window.location.href="myAccountPage.php";</script>';
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

	if(isset($_POST['logout'])){
		session_unset();
		session_destroy();
		echo '<script>window.location.href="loginPage.php";</script>';
	}
?>