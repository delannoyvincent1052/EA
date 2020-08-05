<?php

	$SelectedDepartement=$_POST['SelectedDepartement'];
	
	try {

    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

	}

	  catch(exception $e) {

	    die('Erreur '.$e->getMessage());

	}

	$CityList=array();
	$Counter=0;

	$sql="select * from cities where ville_departement='". $SelectedDepartement."' order by ville_nom_simple";

	foreach  ($base->query($sql) as $row) {
			
		$CityList[$Counter]=$row['ville_nom_simple'];
		$Counter++;
			
	}


	$res = ["Success" => 1, "SelectedDepartement" => $SelectedDepartement, "NbOfCities" => $Counter, "CityList" => $CityList];

	echo json_encode($res);

?>