<?php
require 'php/connect.php';

// sanitize
function sanitize($data) { 
   $data = trim($data);
   $data = htmlspecialchars($data);
   return $data;
}
$numbersOfDates = 31; // set quantity of days from today
for ($i = 0; $i < $numbersOfDates; $i++) {
   $day = date('d/m/Y',strtotime("-" . $i . "days"));// decrement date, per day
   $xml = simplexml_load_file('http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . $day);
   if (!empty($xml)) { 
      foreach ($xml->Valute as $currency) {
         $valuteID = sanitize($currency['ID']);
         $value = sanitize($currency->Value);
         $numCode = sanitize($currency->NumCode);
         $charCode = sanitize($currency->CharCode);
         $name = sanitize($currency->Name);

         if (!empty($value)) {
            $value = str_replace(',', '.', $value);// format DB
         }

         mysqli_query($connect, "INSERT INTO `currency` (`id`, `valuteID`, `numCode`, `сharCode`, `name`, `value`, `date`) VALUES (NULL, '$valuteID', '$numCode', '$charCode', '$name', '$value', '$day')");
      }
   }
}
mysqli_close($connect);
?>

