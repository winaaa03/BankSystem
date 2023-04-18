<?php
	include "converterTool.php";
	session_start();
	if(!isset($_SESSION['accountNum'])){ //check if user has logged in
		echo '<script>alert("Please Login First!")
		window.location.href="loginPage.php";
		</script>';
		exit;
	 }
	
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

<!DOCTYPE html>

 <?php 
	//$encPrimaryKey = $_SESSION[''];
	$encAccountNum = $_SESSION['accountNum'] ;
	// $username = encodeString($_SESSION['username']);
	// $getAccNumQ = "SELECT accountNumber from user WHERE username='$username'";
	// $getAccNumS = mysqli_query($conn, $getAccNumQ);
	// $accNumResult = mysqli_fetch_array($getAccNumS);
	// $encAccountNum = $accNumResult[0];
	// $_SESSION['accountNum'] = $encAccountNum;

	//$encAccountNum = $_SESSION['username'];
	$lblAccount = decodeString($encAccountNum);	
	//session_start();
	//$_SESSION['accountNum']= $encAccountNum;
	//include('BankStatement.php');
 ?>

<script>
 function printTable() {
    var printWindow = window.open('height=210,width=142',"BankStatement.php?accountNumber=<?php echo $encAccountNum ?>");
    printWindow.document.write('<html>');
    printWindow.document.write('<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">');
    printWindow.document.write('<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-2021.css">');
    printWindow.document.write('<head><title></title></head>');
    printWindow.document.write('<body>');
    printWindow.document.write("<table><tr><td><img src='images/logoName.png'/></td><td> <p  class='w3-sans-serif' style='font-size:10px'>Everbank Berhad (765123-E) <br /> 15th Floor, Tower B, Dataran Everbank, 2, Jalan Bestever, 87000, Negeri Sembilan </p></td></tr></table>");            
    printWindow.document.write('<header class="w3-padding w3-display-top" style="width:150%; background-color:#7A7F59; color:white; height:50px ;"></header>');
    printWindow.document.write("<table name='statement' class='w3-bordered' width='70%' style='margin: 50px 10px 10px 70px;border-collapse:collapse;'>");
    printWindow.document.write("<tr style='font-weight:bold'>");
    printWindow.document.write("<td width='5%'></td>");
    printWindow.document.write("<td width='20%'>Date</td>");
    printWindow.document.write("<td width='30%'>Description</td>");
    printWindow.document.write("<td width='10%'>Debit</td>");
    printWindow.document.write("<td width='10%'>Credit</td>");
    printWindow.document.write("<td width='10%'>Balance</td>");
    printWindow.document.write("</tr>");
    printWindow.document.write("</table>");

    // Fetch the contents of bankStatement.php using AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Insert the contents of bankStatement.php into the printWindow
            printWindow.document.write(this.responseText);
			
			
            // Close the document
            printWindow.document.write("<table><tr height='100px'><td></td></tr></table>");
            printWindow.document.write("<div><p  class='w3-sans-serif' style='font-size:10px'>Note : <br />(1) All items and balances shown will be considered correct unless the Bank is notified in writing of any discrepencies within 21 days. <br /> (2) Please notify us of any change of address in writing. </p></div>");
            printWindow.document.write('<footer  style="width:150%; background-color:#7A7F59; color:white; height:50px ;"></footer>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            
            // Print the window
            printWindow.print();
            
        }
    };
    xhttp.open("GET", "BankStatement.php?accountNumber=<?php echo $encAccountNum ?>", true);
    xhttp.send();
}
</script>

 
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
	
	$sql = "SELECT balance FROM transaction WHERE accountNumber ='$encAccountNum' ORDER BY transDate ASC";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result)==0)
	{
		$balance = 0;
	}
	else{
		try{		
			while(($assocresult = mysqli_fetch_assoc($result)) == True)
			{
				$encBalance = $assocresult['balance'];
				$balance = decodeString($encBalance);		
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
		<label style='color:white; font-size:24px; font-weight:bold'><?php echo $lblUsername; ?></label>
	</div>
	<div class="w3-bar-block w3-center w3-display-bottomright" style='background-color:#7A7F59; width:20%; color:white; height:60%; padding:130px 0'>
		<a href="settingPage.php" class="w3-bar-item w3-button">SETTING</a>
		<br /><br />
	<form method='post'>
		<input type="submit" class="w3-bar-item w3-button" name="logout" value="LOG OUT"/>
	</div>
		<table width='80%' style='background-color:#EBE1D6; border-collapse:collapse'>
			<tr height='70px'>
				<td width='10%'></td>
				<td width='35%'></td>
				<td></td>
			</tr>
			<tr height='50px'>
				<td></td>
				<td>
					<div class="w3-card-2" style='background-color:white'>	
						<?php 
							if(isset($_POST['menu']))
							{
								menubar();
							}
						?>
						<header class="w3-container" style='padding-left:85%; height:10px'>						
							<button name='menu' class='w3-button' style='font-size:20px'>...</button>						
						</header>					
						<div class="w3-container" style='padding:25px; height:120px'>
							<label style='font-size:18px'>Savings Account-i</label>
							&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;
							
							<br />
							<label style='color:#BCB1A4'><?php echo $lblAccount; ?></label>
						</div>					
						<footer class="w3-container" style='background-color:#A7AB7D; height:50px; padding: 15px 25px'>						
							<label style='font-size:14px; font-weight:bold'>RM <?php echo number_format("$balance",2) ?></label>
						</footer>
					</div>				
				</td>
			</tr>
			<tr height='278px'>
				<td></td>
			</tr>
		</table>
	</form>
	<?php
		if(isset($_POST['logout'])){
			session_unset();
			session_destroy();
			echo '<script>window.location.href="loginPage.php";</script>';
		}
		function menubar()
		{
			echo "<div class='w3-sidebar w3-collapse w3-hide w3-card-2' style='margin-left:230px; background-color:#D9D9D9; height:250px'>";
			echo "<button style='margin-left:88%; padding:8px 0 0; border-top-style:hidden; border-right-style: hidden; border-left-style:hidden; border-bottom-style:hidden; background-color:#D9D9D9; font-size:18px; font-weight:bold'>x</button>";
			echo "<a href='viewDetailsPage.php' class='w3-bar-item w3-button' style='width:100%; font-size:14px; padding:15px'>View Details</a>";
			echo "<a href='payPage.php' class='w3-bar-item w3-button' style='width:100%; font-size:14px; padding:15px'>Pay Bills</a>";
			echo "<a href='transferPage.php' class='w3-bar-item w3-button' style='width:100%; font-size:14px; padding:15px'>Transfer Funds</a>";
			/*unfinished link*/
			echo "<button class='w3-bar-item w3-button' style='width:100%; font-size:14px; padding:15px' onclick='printTable()'>View Statements</button>";
			echo "</div>";
		}
	?>
	

	 
	
 </body>
</html>