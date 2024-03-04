<?php
    $hostname = '127.0.0.1';
	$username = 'root';
	$password = '';
	$dbname   = 'galerifoto';
	
	$conn = mysqli_connect($hostname, $username, $password, $dbname) or die ('gagal terhubung ke database');
?>