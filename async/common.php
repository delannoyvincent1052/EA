<?php

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

  	$sql="select * from worker where Email='".$LoggedUser."';";
  	
	foreach  ($base->query($sql) as $row) {
		
		$WorkerID=$row['ID'];
									
	}	
	
?>