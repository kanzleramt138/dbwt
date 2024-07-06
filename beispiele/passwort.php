<?php
$salt = 'abcd';
$password = 'adminpass';
$hashed_password = sha1($salt . $password);
echo $hashed_password;
?>