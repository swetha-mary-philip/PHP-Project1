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
        <img class="img-fluid pb-3 pull-left logo-img" src="images/writing.png"/>
                <a class="navbar-brand" style="color:brown; font-weight:bold;font-family:cursive; text-decoration:underline;" href="home.html">Book Store</a>
        
        </div>
        
        <div class="navbar-collapse collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a  style="color:brown; font-weight: bold" href="home.html">Home</a></li>
                <li><a style="color:brown;font-weight: bold" href="index.php">Book Store</a></li>   
               <!-- <li><a style="padding:0px;" href="checkout.php"><img class="img-fluid pb-3 pull-left logo-img" src="images/cart.png"/></a></li> -->
            </ul>      
        </div>
    </div>
</nav>
</body>
</html>

<?php 

require('mysqli_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
      if (empty($_POST['quantity'])) {
		echo 'Please enter quantity.';
	   } else 
       {
		  $quantity = $_POST['quantity'];
          $id = $_POST['Book_ID'];
          $price = $_POST['price'];
          $name = $_POST['name'];
          $url = $_POST['image'];
          $amount = round($quantity* $price, 2);
          
             session_start();
             $_SESSION['bookID'] = $id;
             $_SESSION['name'] = $name;
             $_SESSION['quantity'] = $quantity;
             $_SESSION['image'] = $url;
             $_SESSION['amount'] = $amount;
             header("Location: checkout.php");
            
	   }
     
}
else{

$q1 = "select * from book_inventory";

$result = mysqli_query($dbc, $q1);

if($result)
{
    echo '<div class="container">';
   
    while($r = mysqli_fetch_array($result))
    {
        $url = "books/$r[Image_URL]";
        $name= $r['Name'];
        $author = $r['Author'];
        $bookid = $r['Book_ID'];
        $price= $r['Price'];
        $image = $r['Image_URL'];
        
       echo '<div class="col-sm-3 col-12">
             <div style="padding:2%; margin:2%;" class="card text-center">
                <div class="card-body">
                <img class="img-fluid list-img" src="'.$url.'"></img>
                <div style="margin-top:5px;">
                    <p>Book : '.$name.'<br>Author : '.$author.'<br>Price : $'.$price.' CAD</p>
                    <form method="POST" action="index.php">
                    <input style="min-width:80px;" placeholder= "Quantity" required type="number" name="quantity" min="1" max="4" value="<?php if (isset($_POST["quantity"])) echo $_POST["quantity"]; ?>
                    <input type="hidden" name="Book_ID" value="'.$bookid.'">
                     <input type="hidden" name="price" value="'.$price.'">
                     <input type="hidden" name="name" value="'.$name.'">
                     <input type="hidden" name="image" value="'.$image.'">
                    <button type="submit" class="btn btnaddtocart">Buy</button>
                    </form>
                  </div>  
                </div>
            </div>
        </div>';
        
    }
    echo '</div>';
   
}
else
{
    mysqli_error($dbc);
}
    
}

mysqli_close($dbc); // close db connection
?>