<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$RealisationTitle=$_POST['RealisationTitle'];
	$RealisationDescription=$_POST['RealisationDescription'];
	$Success=0;

	if (isset($_FILES["file"])){
	
	
		require("common.php");

		/* Récupération du nombre de réalisation pour ce worker */

		$Counter=0;
		$sql="select * from realisation where OwnerID=".$WorkerID;
		
		foreach  ($base->query($sql) as $row) {
			
			$Counter++;
										
		}


		$tmp_name = $_FILES["file"]["tmp_name"];
		$name = $_FILES["file"]["name"];
		$PictureName="RealisationTitle-".$Counter."-".$WorkerEmail.".jpg";
		move_uploaded_file($tmp_name, "../realisation/".$PictureName);

		/* Insertion de la nouvelle réalisation dans la base de données*/

		$sql="insert into realisation (Title,Description,Picture,OwnerID) values ('".$RealisationTitle."','".$RealisationDescription."','".$PictureName."',".$WorkerID.")";
		$Result=$base->exec($sql);
		
		if($Result){
			$CreationDate=date("Ymd");
			$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','UploadRealisation',1)";
			$Result=$base->exec($sql);
			$Success=1;
		}

		if(!$Result){
			$CreationDate=date("Ymd");
			$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','UploadRealisation',0)";
			$Result=$base->exec($sql);
			$Success=0;
		}

	$res = ["Success" => $Result];
	echo json_encode($res);

	}

?>