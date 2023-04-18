<?php
	include "converterTool.php";
?>

<!DOCTYPE html>

<script>
	function printTable(tableId) 
	{
		// Get the HTML content of the table to print
		var statement = document.getElementById(tableId).outerHTML;
		//Open a new window to print the content
		var printWindow = window.open('height=210,width=142');
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
		printWindow.document.write(statement);
		printWindow.document.write("<table><tr height='100px'><td></td></tr></table>");
		printWindow.document.write("<div><p  class='w3-sans-serif' style='font-size:10px'>Note : <br />(1) All items and balances shown will be considered correct unless the Bank is notified in writing of any discrepencies within 21 days. <br /> (2) Please notify us of any change of address in writing. </p></div>");
		printWindow.document.write('<footer  style="width:150%; background-color:#7A7F59; color:white; height:50px ;"></footer>');
		printWindow.document.write('</body></html>');
		printWindow.document.close();

		// Print the window
		printWindow.print();
	}
</script>

 <?php 
	session_start();
	$encAccountNum = $_SESSION['accountNum'];
	
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
 
	$sql = "SELECT name,accountNumber  FROM user WHERE accountNumber ='$encAccountNum'";
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
				$lblName = decodeString($encName);

				$enclblAccount = $assocresult['accountNumber'];
				$lblAccount = decodeString($enclblAccount);
			}				
		}	
		catch(customException $e){
			echo $e->errorMessage();
		}
	}
	
	$sql = "SELECT balance  FROM transaction WHERE accountNumber ='$encAccountNum' ORDER BY transDate ASC";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result)==0)
	{
		$balance =0;
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
 <form method="post">
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
		<label style='color:white; font-size:24px; font-weight:bold'><?php echo $lblName; ?></label>
	</div>
	<div class="w3-bar-block w3-center w3-display-bottomright" style='background-color:#7A7F59; width:20%; color:white; height:60%; padding:130px 0'>
		<a href="settingPage.php" class="w3-bar-item w3-button">SETTING</a>
		<br /><br />
		<a href="loginPage.php" class="w3-bar-item w3-button">LOG OUT</a>
	</div>		
	<table width='80%' style='background-color:#EBE1D6; border-collapse:collapse'>
		<tr height='100px'>
			<td width='10%'></td>
			<td>
				<label style='font-size:18px; font-weight:bold'>Savings Account-i (Savings)</label>
				<label style='font-size:12px'>&emsp;<?php echo $lblAccount; ?></label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="w3-card-2" style='background-color:white; width:55%; padding: 30px 55px 50px; height:100px'>
					<label style='font-size:18px; font-weight:bold; font-family:sans-serif'>Available Balance</label>
					&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
					<label style='font-size:18px; font-weight:bold; font-family:sans-serif'>RM <?php echo number_format("$balance",2); ?></label>
				</div>
			</td>
		</tr>
		<tr height='60px'>
			<td colspan='2'></td>
		</tr>
	</table>
	
	<table>
		<tr>
			<div  style='margin: 50px 0px 20px 508px;'> <!--right, -->
				<?php
				  $month = 'all';	  
				?>

				<select name='ddl_Months' id='ddl_Months' value="all">
				<?php
					$month = $_POST['ddl_Months'];
				?>
				  <option value="all" <?php if($month == "all") echo "selected"; ?> >All</option>
				  <option value="MjAyMy0wMS" <?php if($month == "MjAyMy0wMS") echo "selected"; ?> >January</option>
				  <option value="MjAyMy0wMi" <?php if($month == "MjAyMy0wMi") echo "selected"; ?> >February</option>
				  <option value="MjAyMy0wMy" <?php if($month == "MjAyMy0wMy") echo "selected"; ?> >March</option>
				  <option value="MjAyMy0wNC" <?php if($month == "MjAyMy0wNC") echo "selected"; ?> >April</option>
				  <option value="MjAyMy0wNS" <?php if($month == "MjAyMy0wNS") echo "selected"; ?> >May</option>
				  <option value="MjAyMy0wNi" <?php if($month == "MjAyMy0wNi") echo "selected"; ?> >June</option>
				  <option value="MjAyMy0wNy" <?php if($month == "MjAyMy0wNy") echo "selected"; ?> >July</option>
				  <option value="MjAyMy0wOC" <?php if($month == "MjAyMy0wOC") echo "selected"; ?> >August</option>
				  <option value="MjAyMy0wOS" <?php if($month == "MjAyMy0wOS") echo "selected"; ?> >September</option>
				  <option value="MjAyMy0xMC" <?php if($month == "MjAyMy0xMC") echo "selected"; ?> >October</option>
				  <option value="MjAyMy0xMS" <?php if($month == "MjAyMy0xMS") echo "selected"; ?> >November</option>
				  <option value="MjAyMy0xMi" <?php if($month == "MjAyMy0xMi") echo "selected"; ?> >December</option>
				</select>
				
				<input type="submit" name="btn_month" value="set"/>
			</div>
		</tr>
	</table>
	<table name="statement" class="w3-bordered" width='70%' style='margin: 0px 0px 0px 70px;border-collapse:collapse; background-color;black '>
		<tr style='background-color:black; color:white'>
			<td width='5%'>
			</td>
			<td width='20%'>
				Date
			</td>
			<td width='30%'>
				Description
			</td>
			<td width='10%'>
				Debit
			</td>
			<td width='10%'>
				Credit
			</td>
			<td width='10%'>
				Balance
			</td>
		</tr>
	</table>
	<table table id="tableStatement" name="statement1" class="w3-bordered" width='70%' style='margin: 5px 10px 10px 70px;border-collapse:collapse'>
		<!--change here into database retrieve query-->
		
		<form method="post">
			<?php
				
				function all($conn, $encAccountNum)
				{
					$sql= "SELECT transDate,description,debit,credit,balance FROM transaction WHERE accountNumber='$encAccountNum' ORDER BY transDate ASC";
					$result = mysqli_query($conn, $sql);
					$assocresult = mysqli_fetch_assoc($result);
					do {
						$transDate = decodeString($assocresult['transDate']);
						$description = decodeString($assocresult['description']);
						$debit = decodeString($assocresult['debit']);
						$credit = decodeString($assocresult['credit']);
						$balance = decodeString($assocresult['balance']);
						echo "<tr><td width='5%'></td>";
						echo "<td width='20%'>$transDate</td>";
						echo "<td width='30%'>$description</td>";
						echo "<td width='10%'>$debit</td>";
						echo "<td width='10%'>$credit</td>";
						echo "<td width='10%'>$balance</td>";
						$assocresult = mysqli_fetch_assoc($result);
						}while($assocresult);
				}
			?>
		</form>
		
		
		<?php

			
			
			if(isset($_POST['btn_month']))
			{ 	
				$selected = "selected";
			  
				try{
					if($month == 'all')
					{
						$sql= "SELECT transDate,description,debit,credit,balance FROM transaction WHERE accountNumber='$encAccountNum'";
						$result = mysqli_query($conn, $sql);
						$assocresult = mysqli_fetch_assoc($result);
						do {
							$transDate = decodeString($assocresult['transDate']);
							$description = decodeString($assocresult['description']);
							$debit = decodeString($assocresult['debit']);
							$credit = decodeString($assocresult['credit']);
							$balance = decodeString($assocresult['balance']);
							echo "<tr><td width='5%'></td>";
							echo "<td width='20%'>$transDate</td>";
							echo "<td width='30%'>$description</td>";
							echo "<td width='10%'>$debit</td>";
							echo "<td width='10%'>$credit</td>";
							echo "<td width='10%'>$balance</td>";
							$assocresult = mysqli_fetch_assoc($result);
							}while($assocresult);
					}
					else{
						
						//display transaction table
						$sql= "SELECT transDate,description,debit,credit,balance FROM transaction WHERE accountNumber='$encAccountNum' AND SUBSTRING(transDate, 1, 10) = '$month'";
						$result = mysqli_query($conn, $sql);
						$assocresult = mysqli_fetch_assoc($result);
						
						if(mysqli_num_rows($result)==0)
						{
							echo "<label style='margin: 0px 0px 0px 70px'>No Record</label>";
						}	
						else
						{
							do 
							{
								$transDate = decodeString($assocresult['transDate']);
								$description = decodeString($assocresult['description']);
								$debit = decodeString($assocresult['debit']);
								$credit = decodeString($assocresult['credit']);
								$balance = decodeString($assocresult['balance']);
								echo "<tr><td width='5%'></td>";
								echo "<td width='20%'>$transDate</td>";
								echo "<td width='30%'>$description</td>";
								echo "<td width='10%'>$debit</td>";
								echo "<td width='10%'>$credit</td>";
								echo "<td width='10%'>$balance</td>";
								$assocresult = mysqli_fetch_assoc($result);
							}while($assocresult);
						}
					}	
				}
				catch(customException $e)
				{
					echo $e->errorMessage();
				}
			}
			else{
				all($conn, $encAccountNum);
			}
			
			
		?>
	</table>
		<button class="w3-button w3-round-large w3-border" style='margin:2% 33%' onclick="printTable('tableStatement')">VIEW STATEMENT</button>
 </body>
 </form>
<html>