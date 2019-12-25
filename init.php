<?php 
require_once 'functions.php';
session_start();
try {
    $db = new PDO('mysql:host=remotemysql.com;dbname=nQhrcXzBBL;charset=utf8', 'nQhrcXzBBL', 'GV65vJDdMj');
//    $db = new PDO('mysql:host=localhost;dbname=peace;charset=utf8', 'root', 'root');
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
