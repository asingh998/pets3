<?php


//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require the autoload file
require_once("vendor/autoload.php");

//Instantiate the F3 Base class
$f3 = Base::instance();

//Default route
$f3->route('GET /', function() {
    //echo '<h1>My pets</h1>';
    //echo '<a href=\'order\'>Order a Pet</a>';

    $views = new Template();
    echo $views->render('views/pet-home.html');
});

//order route
$f3->route('GET|POST /order', function($f3) {
    //echo '<h1>Order page</h1>';

    //check if form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //validate
        if (empty($_POST['pet'])) {
            echo 'Please supply a pet type';

        } else {
            //data is valid
            $_SESSION['pet'] = $_POST['pet'];
            $_SESSION['color'] = $_POST['color'];

            $f3->reroute('summary');
        }
    }

    $views = new Template();
    echo $views->render('views/pet-order.html');
});

//summary
$f3->route('GET /summary', function() {
    //echo '<h1>Thank you for your order!</h1>';

    $view = new Template();
    echo $view->render('views/order-summary.html');

});

//Run F3
$f3->run();