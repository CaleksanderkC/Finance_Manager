<?php
  require 'connection_data.php';

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  function is_and_trim($str, $def='') {

    $ret = $def;
    if(isset($_POST[$str])) {
      $ret = trim($_POST[$str]);
    }

    return $ret;
  }

  $Date = is_and_trim('Date', date('Y-m-d H:i:s'));
  $Name = is_and_trim('Name');
  $Contact = is_and_trim('Contact');
  $Model = is_and_trim('Model');
  $Fault = is_and_trim('Fault');
  $Service_c = is_and_trim('Service_c', '0');
  $Comments = is_and_trim('Comments');



  $sql = "INSERT INTO `Client` (`Id`, `Name`, `Contact`)
    VALUES (NULL, '{$Name}', '{$Contact}')";

  if ($conn->query($sql) === TRUE) {
    $client_id = $conn->insert_id;
  } else { die("Error: " . $sql . "<br>" . $conn->error); }


  $sql = "INSERT INTO `Service` (`Id`, `Model`, `Fault`, `Description`)
    VALUES (NULL, '{$Model}', '{$Fault}', '{$Comments}')";

  if ($conn->query($sql) === TRUE) {
    $service_id = $conn->insert_id;
  } else { die("Error: " . $sql . "<br>" . $conn->error); }


  $sql = "INSERT INTO `Status` (`Id`, `PartFee`, `PartOrder`, `DeliveryStatus`, `ServiceFees`, `Completed`)
    VALUES (NULL, '0', '0', '0', '0', '0') ";

  if ($conn->query($sql) === TRUE) {
    $status_id = $conn->insert_id;
  } else { die("Error: " . $sql . "<br>" . $conn->error); }


  $sql = "INSERT INTO `Costs` (`Id`, `Details`, `Delivery`, `Service`, `Addition`, `Unplanned`, `Final`, `Income`)
    VALUES (NULL, '0', '0', '{$Service_c}', '0', '0', '0', '0')";

  if ($conn->query($sql) === TRUE) {
    $costs_id = $conn->insert_id;
  } else { die("Error: " . $sql . "<br>" . $conn->error); }


  $sql = "INSERT INTO `Costs_an` (`Id`, `Details_an`, `Delivery_an`, `Service_an`, `Addition_an`, `Unplanned_an`, `Final_an`, `Income_an`)
  VALUES (NULL, '0', '0', '0', '0', '0', '0', '0');";

  if ($conn->query($sql) === TRUE) {
    $costs_an_id = $conn->insert_id;
  } else { die("Error: " . $sql . "<br>" . $conn->error); }


  $sql = "INSERT INTO `Order_info` (`Order_id`, `Date`, `Client_id`, `Service_id`, `Status_id`, `Costs_id`, `Costs_an_id`)
  VALUES (NULL, '{$Date}', '{$client_id}', '{$service_id}', '{$status_id}', '{$costs_id}', '{$costs_an_id}') ";

  if ($conn->query($sql) === TRUE) {
    $costs_an_id = $conn->insert_id;
  } else { die("Error: " . $sql . "<br>" . $conn->error); }


  $conn->close();

  header("Location: index.php");
  die();

?>