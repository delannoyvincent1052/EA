<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$CategoryName=$_POST['CategoryName'];
	$Status=0;

	if($CategoryName<>''){

			
		require("common.php");

		$ExistingCategory=0;

		/* Test pour savoir si une catégorie de même nom n'existe pas déjà */

		$sql="select * from quotationcategory where CategoryName='".$CategoryName."' and WorkerID=".$WorkerID;

		foreach  ($base->query($sql) as $row) {
			
			$ExistingCategory=1;
			$Status=1;
										
		}	

		if($ExistingCategory==0){

			$sql="insert into quotationcategory(CategoryName,WorkerID) values ('".$CategoryName."',".$WorkerID.");";

			$Result=$base->exec($sql);

			if($Result){

				$Status=2;
				$CreationDate=date("Ymd");
				$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Category','CategoryCreation',1)";
				$Result=$base->exec($sql);
			}
			else{
				$Status=3;
				$CreationDate=date("Ymd");
				$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Category','CategoryCreation',0)";
				$Result=$base->exec($sql);
			}

		}

	}

	$res = ["Success" => $Status];
	echo json_encode($res);
?>