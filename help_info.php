<!DOCTYPE html>
<html lang="pl">

<head>
  <title>Zmien</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <meta charset="utf-8">
</head>

<body>

<?php include 'header.php';?>

<main class="container mt-2 mb-5">
<div class='row align-items-md-stretch'> 


<?php

  include 'connection_data.php';

  $conn = new mysqli($servername, $username, $password, $dbname);
  
  if ($conn->connect_error){ die("Connection failed: " . $conn->connect_error); }

  $id = trim($_SERVER['QUERY_STRING']);
  if($id == ""){ die("Błąd"); }


  $sql = "
    SELECT * FROM `Order_info`
      INNER JOIN `Client` ON `Order_info`.`Client_id` = `Client`.`Id`
      INNER JOIN `Service` ON `Order_info`.`Service_id` = `Service`.`Id`
      INNER JOIN `Status` ON `Order_info`.`Status_id` = `Status`.`Id`
      INNER JOIN `Costs` ON `Order_info`.`Costs_id` = `Costs`.`Id`
      INNER JOIN `Costs_an` ON `Order_info`.`Costs_an_id` = `Costs_an`.`Id`

      WHERE `Order_info`.`Order_id` = {$id};
  ";

  $result = $conn->query($sql);

  

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

      $Date = $row['Date'];
      $Completed = $row['Completed'];
      $Name = $row['Name'];
      $Contact = $row['Contact'];
      $Model = $row['Model'];
      $Fault = $row['Fault'];

      $Costs = array(
        'Details' => $row['Details'],
        'Delivery' => $row['Delivery'],
        'Service' => $row['Service'],
        'Addition' => $row['Addition'],
        'Unplanned' => $row['Unplanned'],
        'Final' => $row['Final'],
        'Income' => $row['Income']
      );


      $Costs_an = array(
        'Details' => $row['Details_an'],
        'Delivery' => $row['Delivery_an'],
        'Service' => $row['Service_an'],
        'Addition' => $row['Addition_an'],
        'Unplanned' => $row['Unplanned_an'],
        'Final' => $row['Final_an'],
        'Income' => $row['Income_an']
      );

      function chacked_type($str)
      {
        if($str == '0') {
          return '';
        }
        return 'checked';
      }


      $Status = array(
        'PartFee' => chacked_type($row['PartFee']),
        'PartOrder' => chacked_type($row['PartOrder']),
        'DeliveryStatus' => chacked_type($row['DeliveryStatus']),
        'ServiceFees' => chacked_type($row['ServiceFees']),
        'Completed' => chacked_type($row['Completed'])
      );

      $Comments = $row['Description'];


      echo "
        <form class='add-form' action='save_script.php' method='post'>

          <div class='mb-3'>
            <h1 class='h3 mb-3 fw-normal'>Order Nr {$id} Info</h1>
          </div>


          

          <div class='mb-3 d-flex flex-column'>
            <label class='form-label' for='Date'><h6>Date</h6></label>
            <input type='date' class='form-control' name='Date' id='Date' value='{$Date}'>
          </div>

          <div>
            <label class='form-label' for='Completed'><h6>Completed</h6></label>
            <input type='checkbox' class='form-check-input' name='Status[]' value='Completed' {$Status['Completed']}>
          </div>

          <div class='mb-3'>
            <h1 class='h3 mb-3 fw-normal'>Client</h1>
          </div>

          
          <div class='mb-3 d-flex flex-column'>
            <label class='form-label' for='Name'><h6>Name</h6></label>
            <input type='text' class='form-control' name='Name' id='Name' value='{$Name}'>
          </div>

          <div class='mb-3 d-flex flex-column'>
            <label class='form-label' for='Contact'><h6>Contact</h6></label>
            <input type='text' class='form-control' name='Contact' id='Contact' value='{$Contact}'>
          </div>
        
         
          <div class='mb-3'>
            <h1 class='h3 mb-3 fw-normal'>Service</h1>
          </div>

          <div class='mb-3'>
            <label class='form-label' for='Model'><h6>Model</h6></label>
            <input type='text' class='form-control' name='Model' id='Model' value='{$Model}'>
          </div>

          <div class='mb-3'>
            <label class='form-label' for='Fault'><h6>Fault</h6></label>
            <input type='text' class='form-control' name='Fault' id='Fault' value='{$Fault}'>
          </div> 

          <div class='d-flex justify-content-around'>

            <div class='mb-3'>
              <div class='mb-3'>
                <h1 class='h3 mb-3 fw-normal'>Costs</h1>
              </div>

              <div class='mb-3'>
                <label class='form-label' for='Details'><h6>Details</h6></label>
                <input type='number' class='form-control' name='Details' id='Details' value='{$Costs['Details']}'>
              </div>


              <div class='mb-3'>
                <label class='form-label' for='Delivery'><h6>Delivery</h6></label>
                <input type='number' class='form-control' name='Delivery' id='Delivery' value='{$Costs['Delivery']}'>
              </div>

              <div class='mb-3'>
                <label class='form-label' for='Service'><h6>Service</h6></label>
                <input type='number' class='form-control' name='Service' id='Service' value='{$Costs['Service']}'>
              </div>

              <div class='mb-3'>
                <label class='form-label' for='Addition'><h6>Addition</h6></label>
                <input type='number' class='form-control' name='Addition' id='Addition' value='{$Costs['Addition']}'>
              </div>

              <div class='mb-3'>
                <label class='form-label' for='Unplanned'><h6>Unplanned</h6></label>
                <input type='number' class='form-control' name='Unplanned' id='Unplanned' value='{$Costs['Unplanned']}'>
              </div>

              <div class='mb-3'>
                <label class='form-label' for='Final'><h6>Final</h6></label>
                <input type='number' class='form-control' name='Final' id='Final' value='{$Costs['Final']}'>
              </div>

              <div class='mb-3'>
                <label class='form-label' for='Income'><h6>Income</h6></label>
                <input type='number' class='form-control' name='Income' id='Income' value='{$Costs['Income']}'>
              </div>

            </div>

            <div class='mb-3'>
              <div class='mb-3'>
                <h1 class='h3 mb-3 fw-normal'>Costs announced</h1>
              </div>

              <div class='mb-3'>
                <label class='form-label' for='Details_an'><h6>Details</h6></label>
                <input type='number' class='form-control' name='Details_an' id='Details_an' value='{$Costs_an['Details']}'>
              </div>

              <div class='mb-3'>
                <label class='form-label' for='Delivery_an'><h6>Delivery</h6></label>
                <input type='number' class='form-control' name='Delivery_an' id='Delivery_an' value='{$Costs_an['Delivery']}'>
              </div>

              <div class='mb-3'>
                <label class='form-label' for='Service_an'><h6>Service</h6></label>
                <input type='number' class='form-control' name='Service_an' id='Service_an' value='{$Costs_an['Service']}'>
              </div>

              <div class='mb-3'>
                <label class='form-label' for='Addition_an'><h6>Addition</h6></label>
                <input type='number' class='form-control' name='Addition_an' id='Addition_an' value='{$Costs_an['Addition']}'>
              </div>

              <div class='mb-3'>
                <label class='form-label' for='Unplanned_an'><h6>Unplanned</h6></label>
                <input type='number' class='form-control' name='Unplanned_an' id='Unplanned_an' value='{$Costs_an['Unplanned']}'>
              </div>

              <div class='mb-3'>
                <label class='form-label' for='Final_an'><h6>Final</h6></label>
                <input type='number' class='form-control' name='Final_an' id='Final_an' value='{$Costs_an['Final']}'>
              </div>

              <div class='mb-3'>
                <label class='form-label' for='Income_an'><h6>Income</h6></label>
                <input type='number' class='form-control' name='Income_an' id='Income_an' value='{$Costs_an['Income']}'>
              </div>

            </div>

            </div>

          </div>

          <div class='mb-3'>
            <h1 class='h3 mb-3 fw-normal'>Status</h1>
          </div>

          <div class='d-flex justify-content-around'>

            <div>
              <label class='form-label' for='PartFee'><h6>Part Fee</h6></label>
              <input type='checkbox' class='form-check-input' name='Status[]' value='PartFee' {$Status['PartFee']}>
            </div>

            <div>
              <label class='form-label' for='PartOrder '><h6>Part Order</h6></label>
              <input type='checkbox' class='form-check-input' name='Status[]' value='PartOrder' {$Status['PartOrder']}>
            </div>

            <div>
              <label class='form-label' for='DeliveryStatus'><h6>Delivery Status</h6></label>
              <input type='checkbox' class='form-check-input' name='Status[]' value='DeliveryStatus'
              {$Status['DeliveryStatus']}>
            </div>  
                
            <div>
              <label class='form-label' for='ServiceFees'><h6>Service Fees</h6></label>
              <input type='checkbox' class='form-check-input' name='Status[]' value='ServiceFees' {$Status['ServiceFees']}>
            </div>

          </div>


          <div class='mb-3'>
            <label class='form-label' for='Comments'><h6>Comments</h6></label>
            <textarea class='form-control' aria-label='With textarea' name='Comments' id='Comments'>{$Comments}</textarea>
          </div>

          <input type='hidden' class='form-control' name='Id' id='Id' value='{$id}'>
          <button class='btn btn-lg btn-primary' type='submit'>Save</button>

        </form>";
    }
  }

  else { echo "0 results"; }


  $conn->close();
?>

</div>
</main>

<?php include 'footer.php';?>

<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>
