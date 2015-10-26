<?php
	session_start();
	session_unset();
	session_destroy(); 
	// redirect them to anywhere you like.
	header('Location: index.php');
?>