<?php
	include "converterTool.php";
?>

<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-2021.css">
	<header>
		<title></title>
	</header>
	
	<?php
		$encAccountNum=$_REQUEST['accountNumber'];
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
	
	<body>
		<table name="statement" class="w3-bordered" width='70%' style='margin: 50px 0px 0px 70px;border-collapse:collapse; background-color;black '>
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
		<?php
			try{
				//display transaction table
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
			catch(customException $e)
			{
				echo $e->errorMessage();
			}
		?>
	</table>
	</body>
</html>