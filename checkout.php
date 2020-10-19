<?php
 session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="main.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Swetha Project 1</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <nav class="navbar" style="border-bottom: 2px solid brown; min-height:70px;">
        <div class="container-fluid" style="margin-top:10px;">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" style="background-color:white;" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar" style="background-color:black;"></span>
                    <span class="icon-bar" style="background-color:black;"></span>
                    <span class="icon-bar" style="background-color:black;"> </span>
                </button>
                <img class="img-fluid pb-3 pull-left logo-img" src="images/writing.png" />
                <a class="navbar-brand" style="color:brown; font-weight:bold;font-family:cursive; text-decoration:underline;" href="home.html">Book Store</a>

            </div>

            <div class="navbar-collapse collapse" id="navbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a style="color:brown; font-weight: bold" href="home.html">Home</a></li>
                    <li><a style="color:brown;font-weight: bold" href="index.php">Book Store</a></li>
                    <!-- <li><a style="padding:0px;" href="checkout.php"><img class="img-fluid pb-3 pull-left logo-img" src="images/cart.png"/></a></li> -->
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a class="checkout-tab" href="#summary">Order Summary</a></li>
            <li><a class="checkout-tab" href="#billingdetails">Billing Details</a></li>
        </ul>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="tab-content">
                <div id="summary" class="tab-pane fade in active">
                    <br>
                    <label>Book Name: <?php echo $_SESSION['name']; ?></label><br />
                    <label>Quantity :  <?php echo $_SESSION['quantity']; ?></label><br />
                    <label>Amount :  $ <?php echo $_SESSION['amount']; ?> CAD</label><br />
                    <img class="img-fluid list-img" src="books/<?php echo $_SESSION['image']; ?>" />
                </div>
                <div id="billingdetails" class="tab-pane fade">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <br>
                            <div class="form-group">
                                <label class="required" for="firstname">First Name</label>
                                <input required type="text" class="form-control" name="firstname" value="<?php if (isset($_POST['firstname'])) echo $_POST['firstname']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" name="lastname" value="<?php if (isset($_POST['lastname'])) echo $_POST['lastname']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="required" for="email">Email</label>
                                <input required type="email" class="form-control" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" title="Phone must be 10 digit number" pattern="[1-9]{1}[0-9]{9}" placeholder="Phone Number" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input disabled type="text" class="form-control" name="country" value="Canada">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <br>
                            <div class="form-group">
                                <label class="required" for="Address1">Address Line 1</label>
                                <input required type="text" class="form-control" name="Address1" value="<?php if (isset($_POST['Address1'])) echo $_POST['Address1']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="Address2">Address Line 2</label>
                                <input type="text" class="form-control" name="Address2" value="<?php if (isset($_POST['Address2'])) echo $_POST['Address2']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="required" for="city">City</label>
                                <input required type="text" class="form-control" name="city" value="<?php if (isset($_POST['city'])) echo $_POST['city']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="required" for="pin">Pin Code</label>
                                <input required type="text" class="form-control" name="pin" value="<?php if (isset($_POST['pin'])) echo $_POST['pin']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="required" for="province">Province</label>
                                <input required type="text" class="form-control" name="province" value="<?php if (isset($_POST['province'])) echo $_POST['province']; ?>">
                            </div>

                        </div>
                        <div class="col-sm-12">
                            <div class="form-group cc-selector">
                                <label class="required">Select a payment type</label> <br>

                                <input id="visa" type="radio" name="credit-card" value="visa" />
                                <label class="drinkcard-cc visa" for="visa"></label>
                                <input id="mastercard" type="radio" name="credit-card" value="mastercard" />
                                <label class="drinkcard-cc mastercard" for="mastercard"></label>
                            </div>
                            <div class="form-group col-sm-6">
                                <input required placeholder="Card Holder's Name" type="text" class="form-control required" name="cardholdername" value="<?php if (isset($_POST['cardholdername'])) echo $_POST['cardholdername']; ?>">                                
                                <br>                                
                                <input required type="text" class="form-control" name="cardnumber" title="Must be 14 digit number" pattern="[0-9]{14}" placeholder="14 digit Card Number" value="<?php if (isset($_POST['cardnumber'])) echo $_POST['cardnumber']; ?>">
                                
                            </div>
                            <div class="form-group col-sm-6">                                
                                <input required type="text" class="form-control" name="expiry" title="Must be 4 digit combination" pattern="[0-9]{4}" placeholder="Expiry Date (MMYY)" value="<?php if (isset($_POST['expiry'])) echo $_POST['expiry']; ?>">
                                <br>
                                <input required type="password" class="form-control" name="cvv" title="Must be 3 digit combination" pattern="[0-9]{3}" placeholder="CVV" value="<?php if (isset($_POST['cvv'])) echo $_POST['cvv']; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12  text-center" style="margin-bottom:10px;">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <script>
        $(document).ready(function () {
            $(".nav-tabs a").click(function () {
                $(this).tab('show');
            });
            $('.nav-tabs a').on('shown.bs.tab', function (event) {
                var x = $(event.target).text();
                var y = $(event.relatedTarget).text();
                $(".act span").text(x);
                $(".prev span").text(y);
            });


        });
    </script>
</body>
</html>



<?php
require('mysqli_connect.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $errors = [];
    
    if (empty($_POST['firstname'])) 
    {
        $errors[] = 'First Name';
    } 
    else 
    {
		$firstname = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
    }
    
    if (empty($_POST['email'])) 
    {
        $errors[] = 'email';
    } 
    else 
    {
		$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    }
    if (empty($_POST['Address1'])) 
    {
        $errors[] = 'Address Line 1';
    } 
    else 
    {
		$address1 = mysqli_real_escape_string($dbc, trim($_POST['Address1']));
    }
     if (empty($_POST['city'])) 
    {
        $errors[] = 'city';
    } 
    else 
    {
		$city = mysqli_real_escape_string($dbc, trim($_POST['city']));
    }
    if (empty($_POST['pin'])) 
    {
        $errors[] = 'pin code';
    } 
    else 
    {
		$pin = mysqli_real_escape_string($dbc, trim($_POST['pin']));
    }
    if (empty($_POST['province'])) 
    {
        $errors[] = 'province';
    } 
    else 
    {
		$province = mysqli_real_escape_string($dbc, trim($_POST['province']));
    }
    if (isset($_POST['credit-card'])) 
    {
       $cardtype = mysqli_real_escape_string($dbc, trim($_POST['credit-card']));
    } 
    else 
    {
		 $errors[] = 'payment type';
    }
    
    if (empty($_POST['cardholdername'])) 
    {
        $errors[] = 'cardholdername';
    } 
    else 
    {
		$cardholdername = mysqli_real_escape_string($dbc, trim($_POST['cardholdername']));
    }
    if (empty($_POST['cardnumber']) && strlen($_POST['cardnumber']) != 14 ) 
    {
        $errors[] = 'Valid cardnumber';
    } 
    else 
    {
		$cardnumber = mysqli_real_escape_string($dbc, trim($_POST['cardnumber']));
    }
    if (empty($_POST['expiry']) && strlen($_POST['expiry']) != 4 ) 
    {
        $errors[] = 'Valid expiry';
    } 
    else 
    {
		$expiry = mysqli_real_escape_string($dbc, trim($_POST['expiry']));
    }
  
    if (empty($errors)) {
        
        $book_id= $_SESSION['bookID'];
        $amount = $_SESSION['amount'];
        $copies = $_SESSION['quantity'];

        $lastname = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
        $address2 = mysqli_real_escape_string($dbc, trim($_POST['Address2']));
        $phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
        //$cardholdername = mysqli_real_escape_string($dbc, trim($_POST['cardholdername']));
        //$cardnumber = mysqli_real_escape_string($dbc, trim($_POST['cardnumber']));
        //$expiy = mysqli_real_escape_string($dbc, trim($_POST['cardnumber']));

        $q1 = "CALL SP_PLACE_ORDER(
        '$firstname',
        '$lastname',
        '$email',
        '$address1',
        '$address2',
        $phone,
        '$pin',
        '$city',
        '$province',
        'Canada',
        '$cardtype',
        '$cardholdername',
        $cardnumber,
        $expiry,
        $book_id,
        $amount,
        $copies);";        
        
        $result = mysqli_query($dbc, $q1);
        
        if ($result){
           mysqli_close($dbc); // close db connection
            
           echo "<script> location.href='success.php'; </script>";
           exit;
        }
        else {
             echo '<div class= "container text-center bg-info error"><h5><b>FAILED. PLEASE TRY AGAIN.</b></h5></div>';
        }
    }
    else
    {
         echo '<div class= "container text-center error"><h5><u>ERRORS!!</u></h5><p> Please enter ';             
                foreach ($errors as $msg) { // Print out each error
                    echo $msg.',&nbsp;';
                  }
                echo '</p></div>';
    }
}

?>

