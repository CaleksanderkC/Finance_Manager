<!DOCTYPE HTML>
<html lang="pl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Finances Manager</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/style.css" />

</head>

<body>

<?php include 'header.php';?>


<main class="container mt-2 mb-5">

<?php

    require 'connection_data.php';
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error){
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "
    SELECT * FROM `Order_info`
      INNER JOIN `Client` ON `Order_info`.`Client_id` = `Client`.`Id`
      INNER JOIN `Service` ON `Order_info`.`Service_id` = `Service`.`Id`
      INNER JOIN `Status` ON `Order_info`.`Status_id` = `Status`.`Id`;
    ";

    $result = $conn->query($sql);


    echo " <div class='row align-items-md-stretch'> ";
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {


        $color = ($row['status'] == '0') ? 'bd-highlight' : 'bg-secondary text-white';
        $href_id = 'help_info.php?' . $row["Order_id"];


        // $need = strlen($need) > 60 ? substr($need,0,60)."..." : $need;

        $data = $row['Date'];
        $name = $row['Name'];
        $contact = $row['Contact'];
        $model = $row['Model'];
        $fault = $row['Fault'];

        echo "
          <div class='col-md-4 mt-3'>
            <a href='$href_id' class='link-dark t-d-n'>
              <div class='text-dark bg-light rounded-3 d-flex flex-column min-height'>

                <div class='p-2 justify-content-around d-flex flex-row'>
                  <div>{$data}</div>
                  <div>{$name}</div>
                </div>

                 <div class='p-2 justify-content-around d-flex flex-row'>
                  <div><p>{$model}</p></div>
                  <div>{$fault}</div>
                </div>

                <div id='col-footer' class='p-2 text-white bg-secondary bg-gradient'>{$contact}</div>
              </div>
            </a>
          </div>
        ";
      }
    }

    else {
      echo "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
          Nie znaleziono żadnego rekordu.
        </div>";
    }

    echo "</div>";

    $conn->close();
  ?>

</main>

<?php include 'footer.php';?>

<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>
