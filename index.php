<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);
session_start();

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}
whatIsHappening();

//your products with their price.
//check if food is checked and if it is set to 1 OR baseline => food, otherwise use drinks.
if ((isset($_GET["food"]) && $_GET["food"]==1) || !isset($_GET["food"])) {
    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
} else {
    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
}

$totalValue = 0;

require 'form-view.php';
$email="";
$street="";
$streetNumber=0;
$city="";
$zipCode=0;

$_SESSION['email']="";
$_SESSION['street']="";
$_SESSION['streetnumber']="";
$_SESSION['city']="";
$_SESSION['zipcode']="";
$_SESSION['error']= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email=test_input($_POST["email"]);
    $street=test_input($_POST["street"]);
    $streetNumber=test_input($_POST["streetnumber"]);
    $city=test_input($_POST["city"]);
    $zipCode=test_input($_POST["zipcode"]);
    $products=($_POST['products']);
    $formvals=array();
    // store the checked values globally in a session
    $_SESSION['email']=$email;
    $_SESSION['street']=$street;
    $_SESSION['streetnumber']=$streetNumber;
    $_SESSION['city']=$city;
    $_SESSION['zipcode']=$zipCode;
    $_SESSION['error']= array();
    // test if entries are filled in and valid
    checkEmail($email);
    checkStreet($street);
    checkStreetNumber($streetNumber);
    checkCity($city);
    checkZipcode($zipCode);

}  


function checkEmail($emailInput) {
    if (empty($emailInput)) {
        $_SESSION['error'][]="email";
    } else {
        if (!filter_var($emailInput, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'][]="email";

        }
    }
}
function checkStreet($streetInput) {
    if (empty($streetInput)) {
        $_SESSION['error'][]="street";

    }
}
function checkStreetNumber($streetNumberInput) {
    if ($streetNumberInput==0 || $streetNumberInput==null || !is_numeric($streetNumberInput)) {
        $_SESSION['error'][]="streetnumber";

    }
}
function checkCity($cityInput) {
    if (empty($cityInput)) {
        $_SESSION['error'][]="city";
    }
}
function checkZipCode($zipCodeInput) {
    if (empty($zipCodeInput) || !is_numeric($_POST["zipCode"])) {
        $_SESSION['error'][]="zipcode";
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

