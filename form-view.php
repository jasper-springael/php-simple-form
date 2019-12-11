<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_SESSION['error'] !== "") {
?>
<div class="alert alert-danger" role="alert">
<?php
            echo('Some of the required fields are not filled in correctly.. Fields are:');
            echo('</br>');
            foreach($_SESSION['error'] as $key=>$value){
                echo($_SESSION['error'][$key]);
                echo('</br>');
            }
        }
    }
?>
</div>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php if (isset($_SESSION['email'])) echo $_SESSION['email'];?>"/>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control" value="<?php if (isset($_SESSION['street'])) echo $_SESSION['street'];?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control" value="<?php if (isset($_SESSION['streetnumber'])) echo $_SESSION['streetnumber'];?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control"value="<?php if (isset($_SESSION['city'])) echo $_SESSION['city'];?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php if (isset($_SESSION['zipcode'])) echo $_SESSION['zipcode'];?>">
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
        </fieldset>
        <fieldset>
        <legend>Delivery method</legend>
            <label class="radio"><input type="radio" name="delivery" value="normal"> Normal (delivery time: 2hours)</label></br>
            <label class="radio"><input type="radio" name="delivery" value="express"> Express (delivery time: 45minutes)</label></br>
        </fieldset>
        <button type="submit" class="btn btn-primary">Order!</button>
    </form>
    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['products'])) {
    ?>
        <div class="alert alert-danger" role="alert">
        <?php

            echo 'Please order a product!';
        }
        ?>
        </div>
    <?php 
        if (empty($_POST['delivery'])) {
    ?>
        <div class="alert alert-danger" role="alert">
        <?php

            echo 'Please select a delivery method!';
        }
    }
        ?>
        </div>
    <h1> You ordered: </h1>
    <?php
        if (empty($_POST['products'])) {
            echo 'Nothing so far';
        } else {
            echo('You ordered:');
            echo('<ul>');
            foreach ($_POST['products'] as $key => $value) {
                echo('<li>'.$products[$key]['name'].'</li>');
                $totalValue+=$products[$key]['price'];
            }
        }
    $deliveryCost=0;
    if (isset($_POST['delivery'])) {
        if ($_POST['delivery'] == 'normal') {
            $deliveryCost= 0;
        } else {
            $deliveryCost=5;
        }
    }
    ?>
    <footer>Total amount:<strong>&euro; <?php echo $totalValue.'+ a delivery cost of:'?> &euro; <?php echo $deliveryCost; ?></strong></footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>