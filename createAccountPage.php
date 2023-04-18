<!DOCTYPE html>
<?php
	include "converterTool.php";
	date_default_timezone_set('Asia/Kuala_Lumpur');
	$today = date('m-d');

	session_start();
?>
<html>
 <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
 <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-2021.css">
 <head>
	<link rel="icon" href="images\logoonly.png"/>
	<title>Everbank</title>
 </head>
 <body>
 <form method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<table style='border-collapse:collapse'>
		<tr style='vertical-align:top'>
			<td rowspan='13'>
				<img src='images\laptop.png' height='647px' />
			</td>
			<td colspan='3' height='30px'></td>
		</tr>
		<tr style='vertical-align:top' height='130px'> 
			<td width='5%'></td>
			<td colspan='2'>
				<h1 style='font-size:36px; font-family:arial; font-weight:bold'>Ready to create an account?</h1>
				Before we create your account, let us have your details.
			</td>
		</tr>
		<tr style='vertical-align:top' height='50px'>
			<td></td>
			<td>Full Name</td>
			<td>
				<input name='txtFullname' type='text' placeholder='Ex. John Smith' style='width:250px' value = '<?php echo $_POST['txtFullname']??''?>' required />
			</td>
		</tr>	
		<tr style='vertical-align:top' height='50px'>
			<td></td>
			<td>Username</td>
			<td>
				<input name='txtUN' type='text' placeholder='Ex. user101' style='width:250px' value = '<?php echo $_POST['txtUN']??''?>' required />
			</td>
		</tr>		
		<tr style='vertical-align:top' height='50px'>
			<td></td>
			<td>IC Number</td>
			<td>
				<input name='txtIC' type='text' placeholder='Ex. 112233091234' value = '<?php echo $_POST['txtIC']??''?>' style='width:250px' required />
			</td>
		</tr>
		<tr style='vertical-align:top' height='50px'>
			<td></td>
			<td>Date of Birth</td>
			<td>
				<input name='txtDOB' type='date' max='2005-<?php echo $today; ?>' value = '<?php echo $_POST['txtDOB']??''?>' style='width:250px' required />
			</td>
		</tr>
		<tr style='vertical-align:top' height='50px'>
			<td></td>
			<td>Email</td>
			<td>
				<input name='txtEmail' type='email' placeholder='Ex. username@gmail.com' value = '<?php echo $_POST['txtEmail']??''?>' style='width:250px' required />
			</td>
		</tr>
		<tr style='vertical-align:top' height='50px'>
			<td></td>
			<td>Phone Number</td>
			<td>
				<input name='txtPhone' type='text' placeholder='Ex. 01122223333' value = '<?php echo $_POST['txtPhone']??''?>' style='width:250px' required />
			</td>
		</tr>
		<tr style='vertical-align:top' height='80px'>
			<td></td>
			<td>Address</td>
			<td>
				<textarea name='txtAddress' type='text' placeholder='Enter the address for billing purpose' value = '<?php echo $_POST['txtAddress']??''?>' style='width:250px' required ></textarea>
			</td>
		</tr>
		<tr style='vertical-align:top' height='50px'>
			<td></td>
			<td>Password &emsp; <p class="w3-text-dark-gray"></td>			
			<td>
				Password Requirement:
				<ul>
					<li>Minimum 8 alphanumeric characters, maximum 12 characters</li>
					<li>Must contain at least 1 upper case, 1 lower case and 1 number</li>
					<li>Must not contain space</li>
				</ul>
			</p>
				<input name='txtPassword' type='password' placeholder='Enter your password' style='width:250px' pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,12}$" required />
				<br/><br/>
			</td>
		</tr>
		<tr style='vertical-align:top' height='50px'>
			<td></td>
			<td>
			<label for="txtSecQuestions">Security Question:</label>
			</td>
			<td>
			<select name="txtSecQuestions" id="txtSecQuestions" style='width:300px' required>
				<option value="1">In what city were you born in?</option>
				<option value="2">What was your favorite food as a child?</option>
				<option value="3">What is the name of your favorite pet?</option>
			</select>
			</td>
		</tr>
		<tr style='vertical-align:top' height='50px'>
			<td></td>
			<td>Security Answer:</td>
			<td>
				<input name='txtSecAnswer' type='text' placeholder='Enter your security answer' style='width:250px' required />
			</td>
		</tr>
		<tr style='vertical-align:top' height='50px'>
			<td></td>
			<td colspan='2'>
				<input name='cbAgree' type='checkbox' required />
				I Agree with the <a href="terms.pdf" target="_blank">terms & conditions.</a>
			</td>
		</tr>
		<tr style='vertical-align:top'>
			<td></td>
			<td colspan='3'>
				<button name='btnCreate' class="w3-button w3-round-xlarge" style='background-color:#36463A; color:white'>Create Account</button>
			</td>
		</tr>
	</table>
 </form>
 </body>
</html>

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

function checkExists($query, $conn){
	$result = $conn->query($query);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck > 0){
		return true;
	}else{
		return false;
	}
}

if(isset($_POST['btnCreate'])){
	$encFullname = encodeString($_POST['txtFullname']);
	$encUsername = encodeString($_POST['txtUN']);
	$encIC = encodeString($_POST['txtIC']);
	$encDOB = encodeString($_POST['txtDOB']);
	$encEmail = encodeString($_POST['txtEmail']);
	$encHpNum = encodeString($_POST['txtPhone']);
	$encAddr= encodeString($_POST['txtAddress']);
	$encPwd= encodeString($_POST['txtPassword']);
	$encSecQ = encodeString($_POST['txtSecQuestions']);
	$encSecAns = encodeString($_POST['txtSecAnswer']);

	//checks for existing values
	$ucheckStr = "SELECT * FROM user WHERE username = '$encUsername'"; //check for existing username
	$ICcheckStr = "SELECT * FROM personalaccount WHERE ICNumber = '$encIC'"; //check for existing IC
	$emailCheckStr = "SELECT * FROM personalaccount WHERE email = '$encEmail'"; //check for existing email
	$hpNumCheckStr = "SELECT * FROM personalaccount WHERE hpNumber = '$encHpNum'"; //check for existing hp number

	if(checkExists($ucheckStr, $conn)){
		echo '<script>alert("Username Already In Use!")</script>';
	}else if(checkExists($ICcheckStr, $conn)){
		echo '<script>alert("IC Number Already Exists! Please login to your account")</script>';
	}else if(checkExists($emailCheckStr, $conn)){
		echo '<script>alert("Email Address Already Exists! Please login to your account")</script>';
	}else if(checkExists($hpNumCheckStr, $conn)){
		echo '<script>alert("Phone Number Already Exists! Please login to your account")</script>';
	}else{
		$zeroEnc = encodeString('0');
		$oneEnc = encodeString('1');
		$encStartingBal = encodeString('1000');
		$encTransDate = encodeString((string)date('Y-m-d'));

		//generate random account number, PIN and transaction ID
		$encAccNumber = encodeString((string)rand(111111111111,999999999999));
    	$encPIN = encodeString((string)rand(111111,999999));
		$encTransID = encodeString((string)rand(11111111,99999999));

		$encDescription = encodeString("New Account Creation");


		//insert values into the table
		try{
			//insert into user table
			$stmt = $conn->prepare("INSERT INTO user (accountNumber,name,username,password,securityQn,answer,accountStatus,accType,PIN,loginCount)
			     VALUES (?,?,?,?,?,?,?,?,?,?)");
			$stmt->bind_param("ssssssssss",$encAccNumber,$encFullname,$encUsername,$encPwd,$encSecQ,$encSecAns,$oneEnc,$oneEnc,$encPIN,$zeroEnc);
		 	$stmt->execute();
			
			//insert into personalaccount table
			$stmt = $conn->prepare("INSERT INTO personalaccount (accountNumber,email,hpNumber,ICNumber,DOB,address)
			     VALUES (?,?,?,?,?,?)");
			$stmt->bind_param("ssssss",$encAccNumber,$encEmail,$encHpNum,$encIC,$encDOB,$encAddr);
		 	$stmt->execute();

			//create new record in transaction table
			$stmt = $conn -> prepare("INSERT INTO transaction (transID,accountNumber,description,credit,debit,balance,transDate)
				VALUES (?,?,?,?,?,?,?)");
			$stmt->bind_param("sssssss",$encTransID,$encAccNumber,$encDescription,$encStartingBal,$zeroEnc,$encStartingBal,$encTransDate);
			$stmt->execute();

			 $_SESSION['accountNum'] = $encAccNumber; //set session for account number
			 $_SESSION['username'] = $encUsername; //set session for username

			unset($_POST['txtFullname']);
			unset($_POST['txtUN']);
			unset($_POST['txtIC']);
			unset($_POST['txtDOB']);
			unset($_POST['txtEmail']);
			unset($_POST['txtPhone']);
			unset($_POST['txtAddress']);
			unset($_POST['txtPassword']);
			unset($_POST['txtSecQuestions']);
			unset($_POST['txtSecAnswer']);

			echo '<script>alert("Account Created Successfully!")
			window.location.href="myAccountPage.php";
			</script>';

		}catch(Exception $e){
			print $e;
		}
	}

	// echo $unameTemp." ".$ICTemp." ".
	// $DOBTemp." ".
	// $emailTemp." ".
	// $hpNumTemp." ".
	// $addrTemp." ".
	// $pwdTemp." ".
	// $secQTemp." ".
	// $secAnsTemp." ";
}






?>