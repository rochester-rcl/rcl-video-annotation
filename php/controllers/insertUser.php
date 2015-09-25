<?php

include_once '../user.php';

$email = 'jromphf@library.rochester.edu';
$name = 'Josh Romphf';
$userPassword = 'DigitalHum15';

$hashed = User::hash($userPassword);

$user = new User(null, $email, $name, $hashed);

$insert = UserDAO::add($user);

var_dump($insert);
