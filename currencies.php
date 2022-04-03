<?php
require 'php/connect.php';
// debug
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();
// deny open this file from address bar writing http://.../currencies.php 
if ( $_SESSION['permission'] != "allowed" ) {
	header("Location: entrance.php");
}
// sanitize 
function sanitize($data) { 
   $data = trim($data);
   $data = htmlspecialchars($data);
   return $data;
}
$dday = sanitize($_GET['dday']);

// get data to get all dates from DB
$items = mysqli_query($connect, "SELECT * FROM `currency`");
$items = mysqli_fetch_all($items);

// get data of one day from DB
if (!empty($dday)){
	$dataOfDay = mysqli_query($connect, "SELECT * FROM `currency` WHERE '$dday' = `date`"); 
	$dataOfDay = mysqli_fetch_all($dataOfDay);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>World currencies</title>
	<link rel="icon" type="image/png" href="images/coins.png" />
	<link rel="stylesheet" href="style/style.css">	
</head>
<body>
	<h1>Currencies</h1>
	<form  action="currencies.php" method="GET">
	<?php
	// forming array of dates for select option
	$day = 0; // store for "yesterday"
	$daysStore = array(); // store for dates
	foreach ($items as $key => $date) {
		if ($date[6] != $day) { // compare dates
			array_push($daysStore, $date[6]);// adding unique date in store
			$day = $date[6]; 
		}
	}	
	?>
      <select name="dday">
			<option value="">select date to show currencies</option>
			<?php
			for ($i=0; $i < count($daysStore); $i++) { 
			?>
			<option value="<?php echo $daysStore[$i]?>"><?php echo $daysStore[$i]?></option>
			<?php } ?>
		</select>
		<button type="submit">search</button>
	</form>

	<div class="content">
		<table>
			<tr>
				<th>ValueID</th>
				<th>NumCode</th>
				<th>CharCode</th>
				<th>Name</th>
				<th>Value</th>
				<th>Date</th>
			</tr>
			<?php
				// fill <td> with data
				if ( !empty($dataOfDay) ) {
				foreach ($dataOfDay as $key => $item) { 
			?>	
				<tr>
					<?php
					for ($j = 1; $j < 7; $j++) { // filling row with values
						?>
						<td><?php echo $item[$j]?></td>
					<?php } ?>
				</tr>
			<?php
				}
			}
			mysqli_close($connect);
			?>
		</table>
	</div>

</body>
</html>