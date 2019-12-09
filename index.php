<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);
include 'ChromePhp.php';

ChromePhp::log('hello');

//we are going to use session variables so we need to enable sessions
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

if (isset($_POST["submit"])) {
    $emailError="";
    $wrongEmailFormat="";
    $streetError="";
    $cityError="";
    $streetNumberError="";

    // test if entries are filled in and valid
    checkEmail($email);
    checkStreet($street);
    checkStreetNumber($streetNumber);
    checkCity($city);
    checkZipcode($zipCode);
}  
 

function checkEmail($email) {
    if (empty($_POST["email"])) {
        $EmailError="Hey, you need an e-mail!";
    } else {
        $email=test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $WrongEmailFormat="Enter a valid email";
            // invalid emailaddress
            return;
        }
    }
}
function checkStreet($street) {
    if (empty($_POST["street"])) {
        $streetError="Enter a valid street!";
    } else {
        $street=test_input($_POST["street"]);
        return;
    }
}
function checkStreetNumber($streetNumber) {
    if ($_POST["streetnumber"]==0 || $_POST["streetnumber"]==null) {
        $streetNumberError="Enter a valid streetnumber!";
    } else {
        $streetNumber=test_input($_POST["streetnumber"]);
        return;
    }
}
function checkCity($city) {
    if (empty($_POST["city"])) {
        $cityError="Enter a valid city!";
    } else {
        $city=test_input($_POST["city"]);
        return;
    }

}
function checkZipCode($zipCode) {
    if (empty($_POST["zipCode"])) {
        $zipCodeError="Enter a valid zipcode";
    } else {
        $zipCode=test_input($_POST["zipcode"]);
        return;
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function errorHandler($var) {
    echo ($var);
}