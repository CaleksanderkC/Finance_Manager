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

  $Id = is_and_trim('Id');
  $Date = is_and_trim('Date', date('Y-m-d H:i:s'));
  $Name = is_and_trim('Name');
  $Contact = is_and_trim('Contact');
  $Model = is_and_trim('Model');
  $Fault = is_and_trim('Fault');
  $Service_c = is_and_trim('Service', '0');
  $Comments = is_and_trim('Comments');


  $Costs = array(
    'Details' => is_and_trim('Details'),
    'Delivery' => is_and_trim('Delivery'),
    'Service' => is_and_trim('Service'),
    'Addition' => is_and_trim('Addition'),
    'Unplanned' => is_and_trim('Unplanned'),
    'Final' => is_and_trim('Final'),
    'Income' => is_and_trim('Income')
  );


  $Costs_an = array(
    'Details_an' => is_and_trim('Details_an'),
    'Delivery_an' => is_and_trim('Delivery_an'),
    'Service_an' => is_and_trim('Service_an'),
    'Addition_an' => is_and_trim('Addition_an'),
    'Unplanned_an' => is_and_trim('Unplanned_an'),
    'Final_an' => is_and_trim('Final_an'),
    'Income_an' => is_and_trim('Income_an')
  );

  $Status = array(
    'PartFee' => '0',
    'PartOrder' => '0',
    'DeliveryStatus' => '0',
    'ServiceFees' => '0',
    'Completed' => '0'
  );

  $arr = array();
  if(isset($_POST['Status'])) {
    $arr = $_POST['Status'];
  }

  for ($i=0; $i < count($arr); $i++) { 
    switch ($arr[$i]) {
      case 'PartFee':
        $Status['PartFee'] = '1';       
        break;
      case 'PartOrder':
        $Status['PartOrder'] = '1'; 
        break;
      case 'DeliveryStatus':
        $Status['DeliveryStatus'] = '1'; 
        break;
      case 'ServiceFees':
        $Status['ServiceFees'] = '1'; 
        break;
      case 'Completed':
        $Status['Completed'] = '1'; 
        break;
    }
  }




  $sql ="SELECT * FROM `Order_info` WHERE `Order_id` = {$Id}";


  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $Client_id = $row['Client_id'];
      $Service_id = $row['Service_id'];
      $Status_id = $row['Status_id'];
      $Costs_id = $row['Costs_id'];
      $Costs_an_id = $row['Costs_an_id'];

      $sql = "UPDATE `Client` SET `Name`='{$Name}',`Contact`='{$Contact}' WHERE `Id` = {$Client_id}";
      if ($conn->query($sql) === TRUE) {
        $client_id = $conn->insert_id;
      } else { die("Error: " . $sql . "<br>" . $conn->error); }


      $sql = "UPDATE `Service` SET `Model`='{$Model}',`Fault`='{$Fault}',`Description`='{$Comments}' WHERE `Id` = {$Service_id}";
      if ($conn->query($sql) === TRUE) {
        $client_id = $conn->insert_id;
      } else { die("Error: " . $sql . "<br>" . $conn->error); }


      $sql = "UPDATE `Status` SET `PartFee`='{$Status['PartFee']}',`PartOrder`='{$Status['PartOrder']}',
      `DeliveryStatus`='{$Status['DeliveryStatus']}', `ServiceFees`='{$Status['ServiceFees']}',
      `Completed`='{$Status['Completed']}' 
      WHERE `Id` = {$Status_id}";

      if ($conn->query($sql) === TRUE) {
        $client_id = $conn->insert_id;
      } else { die("Error: " . $sql . "<br>" . $conn->error); }


      $sql = "UPDATE `Costs` SET `Details`='{$Costs['Details']}',
      `Delivery`='{$Costs['Delivery']}',`Service`='{$Costs['Service']}',`Addition`='{$Costs['Addition']}',
      `Unplanned`='{$Costs['Unplanned']}',`Final`='{$Costs['Final']}',`Income`='{$Costs['Income']}'
      WHERE `Id` = {$Costs_id}";
      
      if ($conn->query($sql) === TRUE) {
        $client_id = $conn->insert_id;
      } else { die("Error: " . $sql . "<br>" . $conn->error); }


      $sql = "UPDATE `Costs_an` SET
      `Details_an`='{$Costs_an['Details_an']}',`Delivery_an`='{$Costs_an['Delivery_an']}',
      `Service_an`='{$Costs_an['Service_an']}',`Addition_an`='{$Costs_an['Addition_an']}',
      `Unplanned_an`='{$Costs_an['Unplanned_an']}',`Final_an`='{$Costs_an['Final_an']}',
      `Income_an`='{$Costs_an['Income_an']}'
      WHERE `Id` = {$Costs_an_id}";
      
      if ($conn->query($sql) === TRUE) {
        $client_id = $conn->insert_id;
      } else { die("Error: " . $sql . "<br>" . $conn->error); }


      $sql = "UPDATE `Order_info` SET `Date`='{$Date}' WHERE `Order_id` = {$Id}";
      if ($conn->query($sql) === TRUE) {
        $client_id = $conn->insert_id;
      } else { die("Error: " . $sql . "<br>" . $conn->error); }
    }
  }


  $conn->close();

  header("Location: index.php");
  die();
?>