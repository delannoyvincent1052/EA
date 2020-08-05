<?php

	session_start();
	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	

	if ($UserSession!=session_id())
	{
			header("Location: /Login.html");
	}

	try {

    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

  	}

  	catch(exception $e) {

    	die('Erreur '.$e->getMessage());

  	}

  	/* Récupération de l'ID du worker */ 

  	$sql="select * from Worker where Email='".$LoggedUser."';";
  	
	foreach  ($base->query($sql) as $row) {
		
		$WorkerID=$row['ID'];
									
	}

	/* Récupération de la liste des factures */

	$res = ["Success" => 1];
	echo json_encode($res);
?>