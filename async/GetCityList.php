<?php

	$Counter=0;
	if(isset($_POST['DeptNumber'])){

		$DeptNumber=$_POST['DeptNumber'];

		try {

    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

	  	}

	  	catch(exception $e) {

	    	die('Erreur '.$e->getMessage());

	  	}

		$CityList=array();
		

		$sql="select DISTINCT City from worker where SUBSTRING(CP,1,2)=".$DeptNumber;

		foreach  ($base->query($sql) as $row) {
			
			$CityList[$Counter]=$row['City'];			
			$Counter++;						
		} 
	}

	if($Counter>0){

		$res = ["Success" => 1, "NbOfCities" => $Counter, "CityList" => $CityList];

	}
	else{

		$res = ["Success" => 0];
	}

	
	echo json_encode($res);
	

?>