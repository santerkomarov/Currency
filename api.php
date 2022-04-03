<?php
require 'php-files/connect.php';
//error_reporting(0);// skip errors from page
$method = $_SERVER['REQUEST_METHOD'];

$dday = sanitize($_GET['date']);

// sanitize GET
function sanitize($data) { 
   $data = trim($data);
   $data = htmlspecialchars($data);
   return $data;
}

//set interval of available dates
// !Exceptions: in GET query 30,31 feb, error not show
$max = strtotime("04/01/2022"); // month/day/Year, Unit Time: 1648794339
$min = strtotime("03/02/2022"); // month/day/Year, Unit Time: 1646202339

// check date format
if ( preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/", $dday)) {
   // converting GET['date'] d/m/Y into m/d/Y for correct "strtotime()" work
   $chosenDay = DateTime::createFromFormat('d/m/Y', $dday)->format('m/d/Y');
   $chosenDay = strtotime($chosenDay);
   
} else {
   echo json_encode(array(
      'error' => 'Bad date format'
   ));
}

if ( $chosenDay < $min || $chosenDay > $max) {
   echo json_encode(array(
      'Bad date interval' => 'Correct interval: from 02/03/2022 to 01/04/2022.'
   ),JSON_UNESCAPED_SLASHES); // "JSON_UNESCAPED_SLASHES" - for correct displaying slashes
} 

if ( $method == "GET" && $dday == true ) {// only GET request AND correct GET['date']
   // retrieving data from DB of one day 
   if (!empty($dday)){
   	$dataOfDay = mysqli_query($connect, "SELECT * FROM `currency` WHERE '$dday' = `date`"); 
   	$dataOfDay = mysqli_fetch_all($dataOfDay);// get all rows and return an associative array
   }

   // JSON_UNESCAPED_UNICODE for correct encode cyrillic characters
   foreach ($dataOfDay as $key => $valute) {
      echo json_encode(array(
         'valuteID' => $valute[1],
         'numCode' => $valute[2],
         'charCode' => $valute[3],
         'name' => $valute[4],
         'value' => $valute[5],
         'date' => $valute[6],
      ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
   }   
} else {
   // Return error
   header('HTTP/1.0 400 Bad Request');
   echo json_encode(array(
      'error' => 'Bad Request'
   ));
};


