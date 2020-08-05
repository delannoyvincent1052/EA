<?php

	try {

    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

	}

	  catch(exception $e) {

	    die('Erreur '.$e->getMessage());

	}

	$sql="select * from departement";

	$DepartementList=array();
	$Counter=0;

	foreach  ($base->query($sql) as $row) {
			
		$DepartementList[$Counter][0]=$row['Number'];
		$DepartementList[$Counter][1]=$row['Name'];
		$Counter++;
			
	}

	if($Counter>0){

		$res = ["Success" => 1,"NbOfDepartement" => $Counter,"DepartementList" => $DepartementList];

	}
	if($Counter==0){

		$res = ["Success" => 0];
	}
		
	echo json_encode($res);

?>