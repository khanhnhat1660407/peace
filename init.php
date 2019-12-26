<?php 
require_once 'functions.php';
$config = include('config.php');
$database = $config['database'];
session_start();
try {
    $db = new PDO('mysql:host='.$database['host'].';dbname='.$database['name'].';charset=utf8', $database['user'], $database['pass']);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

 $currentUser = null;
 $currentID = null;
 if(isset($_SESSION['userId']))
 {
     $user = findUserByID($_SESSION['userId']);
     if($user)
     {
        $currentUser = $user;
        $currentID = $_SESSION['userId'];
     }
 }
