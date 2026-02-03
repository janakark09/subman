<?php

	//asign the value for variable

	$serverName="localhost";
	$userName="root";
	$password="";
	$dbName="subman_db";

	$conn= mysqli_connect($serverName,$userName,$password,$dbName);
	
	//check the database connection_aborted
	
	if(!$conn)
	{
		die("Database Error".mysqli_connect_error);
	}
	else
	{
		//echo "connected";
	}

?>