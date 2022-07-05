<!DOCTYPE HTML>  
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/stylee.css" rel="stylesheet" type="text/css"></head>
<body>  

<?php
// define variables and set to empty values
$nameErr = $firstnameErr = $emailErr = $phoneNumberErr = $cardNumberErr = "";
$name = $firstname = $email = $phoneNumber = $gender = $cardNumber = $success = "";
$ln = $fn = $e = $nbr = $cn = false;
if(isset($_POST['submit'])) {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } 
  else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
    else{
      $ln = true;
    }
  }

  if (empty($_POST["firstname"])) {
    $firstnameErr = "First Name is required";
  }else {
    $firstname = test_input($_POST["firstname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) {
      $firstnameErr = "Only letters and white space allowed";
    }
    else{
      $fn = true;
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  }else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
    else{
      $e = true;
    }
  }

  if(empty($_POST["phoneNumber"])) {
    $phoneNumberErr = "Phone number is required";
  }else {
    $phoneNumber = test_input($_POST["phoneNumber"]);
    // check if name only contains letters and whitespace
    $phoneNumberCheck = "/^\\+?[1-9][0-9]{7,14}$/";
    if(!preg_match($phoneNumberCheck,$phoneNumber)) {
      $phoneNumberErr = "Phone number not valid";
    }
    else{
      $nbr = true;
    }
  }

  if(empty($_POST["cardNumber"])) {
    $cardNumberErr = "Card number is required";
  }else {
    $cardNumber = test_input($_POST["cardNumber"]);
    // check if name only contains letters and whitespace
    $cardNumberCheck = "/(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})/";
    if (!preg_match($cardNumberCheck,$cardNumber)) {
      $cardNumberErr = "Card number not valid";
    }
    else{
      $cn = true;
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

  if(!empty($name) && !empty($firstname) && !empty($email) && !empty($phoneNumber) && !empty($cardNumber) && $ln && $fn && $e && $nbr && $cn){

  $conn = new mysqli('localhost','root','','burger_king');
  if($conn->connect_error){
    die('Connection Failed : '.$conn->connect_error);
  }else{
    $statement = $conn->prepare("insert into users_infos (lastname, firstname, email, phoneNumber, cardNumber) values(?,?,?,?,?)");
    $statement->bind_param("sssss",$name, $firstname, $email, $phoneNumber, $cardNumber);
    $statement->execute();
    $success = "Data saved, thank you :)";
    $statement->close();
  }
  }

  
  



?>
<div class="main">
<h2>Commander</h2>
<p class="hidden"><?php echo $success ?> </p>

  <form method="post" action="">  
    <label for="">Nom <span class="star">*</span></label> <br>
    <input type="text" name="name" value="<?php echo $name?>">
    <span class="error"><?php echo $nameErr;?></span>
    <br>

    <label for="">Prénom <span class="star" >*</span></label> <br>
    <input type="text" name="firstname" value="<?php echo $firstname?>">
    <span class="error"><?php echo $firstnameErr;?></span>
    <br>

    <label for="">Email <span class="star">*</span></label> <br>
    <input type="text" name="email" value="<?php echo $email?>">
    <span class="error"><?php echo $emailErr;?></span>
    <br>

    <label for="">Numéro de télephone <span class="star">*</span></label> <br>
    <input type="text" name="phoneNumber" value="<?php echo $phoneNumber?>"> 
    <span class="error"> <?php echo $phoneNumberErr;?></span>
    <br>

    <label for="">Carte de crédit <span class="star">*</span></label> <br>
    <input type="text" name="cardNumber" value="<?php echo $cardNumber?>">
    <span class="error"><?php echo $cardNumberErr;?></span>
    <br>
    
    <input class="btn" type="submit" name="submit" value="Submit">  
  </form>

</div>

</body>
</html>