<?php

	$Department=$_POST['Department'];
	$City=$_POST['City'];
	$Activity=$_POST['Activity'];

	try {

    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

  	}

  	catch(exception $e) {

    	die('Erreur '.$e->getMessage());

  	}

  	$sql="select ID,SUBSTR(CP, 1, 2) from worker";
  	$Counter=0;
  	$WorkerList=array();

  	foreach  ($base->query($sql) as $row) {
	
		if($row['SUBSTR(CP, 1, 2)']==$Department){
			$WorkerList[$Counter]=$row['ID'];
  		$Counter++;
		}

		$GlobalNbOfWorker=$Counter;
  										
	}

	$ConcernedWorker=array();
	$WorkerCounter=0;

	for ($Counter=0;$Counter<$GlobalNbOfWorker;$Counter++){

		$sql="select * from workertypelink where workerID=".$WorkerList[$Counter]." and WorkerTypeID=".$Activity;
		foreach  ($base->query($sql) as $row) {
	
			$ConcernedWorker[$Counter]=$row['WorkerID'];

		}

		$WorkerCounter++;
		  										
	}

	$res = ["Success" => $ConcernedWorker];
	echo json_encode($res);

?>