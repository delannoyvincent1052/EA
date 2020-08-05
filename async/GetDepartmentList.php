<?php

	/*if(isset($_POST['Main'])){*/

		try {

	    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

	  	}

	  	catch(exception $e) {

	    	die('Erreur '.$e->getMessage());

	  	}

	  	$Dpts=array();
	  	$Counter=0;

	  	$sql="select * from departement where 1";

	  	foreach  ($base->query($sql) as $row) {
			
			$Dpts[$Counter][0]=$row['Number'];
			$Dpts[$Counter][1]=$row['Name'];
			$Counter++;

		}

		for($counter=0;$counter<20;$counter++){

			echo $Dpts[$counter][1];
		}

		//$res = ["Success" => 1,"Departements" => $Dpts,"NbOfDepartments" => $Counter];
		$res = ["Success" => 1,"NbOfDepartments" => $Counter, "DepartementList" => $Dpts];
		echo json_encode($res);

	/*}
	
	else{

		$res = ["Success" => 0];
		echo json_encode($res);

	}
*/
	

?>