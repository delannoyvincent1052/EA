<?php

	$SelectedCity=$_POST['SelectedCity'];
	
	try {

    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

	}

	  catch(exception $e) {

	    die('Erreur '.$e->getMessage());

	}

	$CPOfCity="";

	$sql="select * from cities where ville_nom_simple='".$SelectedCity."'";

		foreach  ($base->query($sql) as $row) {
			
		$CPOfCity=$row['ville_code_postal'];
			
	}

	if($CPOfCity!=""){

		$Success=1;
		$res = ["Success" => 1, "CPOfCity" => $CPOfCity];
	}

	if($CPOfCity==""){

		$Success=1;
		$res = ["Success" => $sql];
	}

	
	echo json_encode($res);

?>