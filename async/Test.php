<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];

	if (isset($_FILES["file"])){


		if ($WorkerSession!=session_id())
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

		  	$sql="select * from Worker where Email='".$WorkerEmail."'";
		  	
			foreach  ($base->query($sql) as $row) {
				
				$WorkerID=$row['ID'];
											
			}	

		$tmp_name = $_FILES["file"]["tmp_name"];
		$name = $_FILES["file"]["name"];
		move_uploaded_file($tmp_name, "c:\\test\\logo-".$WorkerEmail);

		$ExistingData=0;

		$sql="select * from worker_add where OwnerID=".$WorkerID;

		foreach  ($base->query($sql) as $row) {
				
				$ExistingData++;
											
		}	

		if($ExistingData!=0){

			$sql="update worker_add set LogoName='logo-".$WorkerEmail."' where OwnerID=".$WorkerID;
			$Result=$base->exec($sql);

		}

		if($ExistingData==0){

			$sql="insert into worker_add(LogoName,ActivityDescription,OwnerID) values ('logo-".$WorkerEmail."','',".$WorkerID.");";
			$Result=$base->exec($sql);
		}

		$Success=0;

		if($Result){
			$CreationDate=date("Ymd");
			$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','UploadLogo',1)";
			$Result=$base->exec($sql);
			$Success=1;
		}

		if(!$Result){
			$CreationDate=date("Ymd");
			$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','UploadLogo',0)";
			$Result=$base->exec($sql);
			$Success=0;
		}


				
	}
	$res = ["Success" => $sql];
	echo json_encode($res);

?>