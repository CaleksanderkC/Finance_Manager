<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <meta lang="pl">
  <title>Form</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>


<body>

<?php include 'header.php';?>


<main class="container mt-2 mb-5">

  <form class="add-form" action="add_script.php" method="post">

    <div class="col-md-3">
      <div class="mb-3">
        <h1 class="h3 mb-3 fw-normal">Client</h1>
      </div>

      <div class="mb-3 d-flex flex-column">
        <label class="form-label" for="Name"><h6>Name</h6></label>
        <input type="text" class="form-control" name="Name" id="Name">
      </div>

      <div class="mb-3 d-flex flex-column">
        <label class="form-label" for="Contact"><h6>Contact</h6></label>
        <input type="text" class="form-control" name="Contact" id="Contact" required>
      </div>
   </div>


    <!-- <div class="col-md-3"> -->
      <div class="mb-3">
        <h1 class="h3 mb-3 fw-normal">Service</h1>
      </div>

      <div class="mb-3">
        <label class="form-label" for="Model"><h6>Model</h6></label>
        <input type="text" class="form-control" name="Model" id="Model">
      </div>

      <div class="mb-3">
        <label class="form-label" for="Fault"><h6>Fault</h6></label>
        <input type="text" class="form-control" name="Fault" id="Fault">
      </div> 
    <!-- </div> -->


    <div class="col-md-3">
      
      <div class="mb-3">
        <h1 class="h3 mb-3 fw-normal">Costs</h1>
      </div>

      <div class="mb-3">
        <label class="form-label" for="Service_c"><h6>Service Costs</h6></label>
        <input type="number" class="form-control" name="Service_c" id="Service_c">
      </div>

    </div>


    <div class="mb-3">
      <label class="form-label" for="Comments"><h6>Comments</h6></label>
      <textarea class="form-control" aria-label="With textarea" name="Comments" id="Comments"></textarea>
    </div>
  
    <button class=" btn btn-lg btn-primary" type="submit">ADD</button>

  </form>

</main>


<?php include 'footer.php';?>

</body>
</html>
