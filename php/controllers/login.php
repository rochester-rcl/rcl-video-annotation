<?php


include_once '../user.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$email = $_POST["email"];
$userPassword = $_POST["password"];


//echo("Email = " . $email . " password = " . $password);
//echo("hello");

$user = UserDAO::loginUser('test@test.com', $userPassword);

if( $user){
    echo("User Found!!!!");
} else {
    echo("USER NOT found!!!!");
}


