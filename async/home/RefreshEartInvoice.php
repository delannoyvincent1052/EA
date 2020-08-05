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

  	/* Récupération de la période d'activité sur le site */

  	$sql="select CreationDate from worker where ID=".$WorkerID;

  	foreach  ($base->query($sql) as $row) {
		
		$CreationDate=$row['CreationDate'];
									
	}

	if($CreationDate<>""){

		$Result=1;
		$CreationYear=substr($CreationDate, 0,4);
		$CreationMonth = substr($CreationDate, 4,-2);
		$CreationDay=substr($CreationDate, 6,8);
	}
	else{
		$Result=0;
	}

	$res = ["Success" => $Result, "CreationYear" => $CreationYear, "CreationMonth" => $CreationMonth, "CreationDay" => $CreationDay];
	echo json_encode($res);

?>