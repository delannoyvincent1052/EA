<?php

	if(isset($_POST['email'])){

		$Email=$_POST['email'];

		try {

	    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

		}

		catch(exception $e) {

		    die('Erreur '.$e->getMessage());

		}


		/* Check if the account exist in the database */


		$ExistingWorker=0;
		$Password='';

		$sql="select * from worker where Email='".$Email."';";

		foreach  ($base->query($sql) as $row) {
				
			$ExistingWorker=1;
			$Password=$row['Password'];
				
		}

		if ($ExistingWorker==0){

			$msg=0;
		}

		if ($ExistingWorker==1){

			$msg=1;
			require("SendMail.php");
			EmailPassword($Email,$Password);

		}

		echo json_encode("Status" -> $msg);


	}

	else{
		header("Location: Login.html");
	}

?>
