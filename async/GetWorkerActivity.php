<?php

	/* Cette fonction va permettre de récupérer la liste des activités possibles */

	$Counter=0;

	if(isset($_POST['WorkerActivity'])){

		try {

    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

	  	}

	  	catch(exception $e) {

	    	die('Erreur '.$e->getMessage());

	  	}

		$ActivityList=array();
		
		$sql="select * from workertype";

		foreach  ($base->query($sql) as $row) {
			
			$ActivityList[$Counter][0]=$row['ID'];
			$ActivityList[$Counter][1]=$row['WorkerTypeName'];			
			$Counter++;						
		} 

	}

	if($Counter>0){

		$res = ["Success" => 1, "NbOfActivities" => $Counter, "ActivityList" => $ActivityList];

	}
	else{

		$res = ["Success" => 0];
	}

	
	echo json_encode($res);
	

?>