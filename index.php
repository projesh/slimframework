<?php

require './vendor/autoload.php';
require_once 'mysql.php';

/**
 * Country / Activities / Packages / Detail
 */
$app = new \Slim\Slim();
$app->get('/', function() use ($app, $db) {
    $app->redirect('/api/nepal');
});


$app->group('/api', function() use ($app) {

    $app->get('/name(/)', function() {
        echo 'name';
    });
    $app->get('/name/:name', function($name) {
       echo 'This name is '. $name;
    });
});

/*
 * Route for Activities
 */
$app->get('/nepal(/)', function() use ($app, $db) {

    $sql = "SELECT id,title, cid FROM tbl_activity";
    try {
        $result = $db->query($sql);
        $res = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($res);
    }
    catch(PDOException $e) {
        echo '{ "error": {"test":'.$e->getMessage().'}}';
    }
});

$app->get('/nepal/:activity(/)', function($activity) use ($app, $db) {

    $sql = "SELECT id,title,urlcode,description,aid FROM tbl_package WHERE aid=$activity";
    try {
        $result = $db->query($sql);
        $res = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($res);
    }
    catch(PDOException $e) {
        echo '{ "error": {"test":'.$e->getMessage().'}}';
    }
});

$app->get('/nepal/:activity/:pkg(/)', function($activity, $pkg) use ($app, $db) {

    $sql = "SELECT id,title,aid,duration,cost,area,mingroupsize,bestseason,highlights,
                    description,accomodations,includes,excludes,
                     trip_notes,trip_reviews FROM tbl_package WHERE aid=$activity AND id=$pkg";
    try {
        $result = $db->query($sql);
        $res = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($res);
    }
    catch(PDOException $e) {
        echo '{ "error": {"test":'.$e->getMessage().'}}';
    }
});

$app->get('/nepal/:activity/:pkg/detail(/)', function($activity, $pkg) use ($app, $db) {

    $sql = "SELECT * FROM tbl_itinerary WHERE pid=$pkg";
    try {
        $result = $db->query($sql);
        $res = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($res);
    }
    catch(PDOException $e) {
        echo '{ "error": {"test":'.$e->getMessage().'}}';
    }
});

$app->get('/contact', function() {
    echo 'contact form';
});

$app->get('/error', function(){
    echo 'error';
});

$app->run();


?>
