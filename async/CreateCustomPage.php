<?php

	/* Cette fonction va permettre de créer la page perso à partir du modèle sélectionné */

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$CustomPageTemplate=$_POST['CustomPageTemplate'];

	require("common.php");

	/* Vérification pour savoir si la page perso de l'utilisateur n'existe pas déjà */

	$ExistingCustomPage=0;
	$Status=0;
	$Result=0;
	$Success=0;

	$sql="select * from custompage where WorkerID=".$WorkerID;
	foreach  ($base->query($sql) as $row) {
		
		$ExistingCustomPage++;
									
	}

	if($ExistingCustomPage==0){

		$Char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 		$CharLength = strlen($Char);
 		$RandomString = '';
 		
		for ($i = 0; $i < 15; $i++)
		{
		 	$RandomString .= $Char[rand(0, $CharLength - 1)];
		}

		$sql="insert into custompage (TemplateName,CustomPage,WorkerID) values(".$CustomPageTemplate.",'".$RandomString."',".$WorkerID.");";
		$Result=$base->exec($sql);

		if($Result){
			$Success=1;
			mkdir('../CustomPage/'.$RandomString, 0777, true);
			$BaseFile="../TmplCustomPage/".$CustomPageTemplate.".php";
			$DestFile="../CustomPage/".$RandomString."/index.php";
			if (!copy($BaseFile, $DestFile)) {

				$Success=0;		    
			}

			/* Configuration de la page web créée INDEX.HTML */
			 
		  	$contenu = str_replace("LoggedUser", $WorkerEmail, file_get_contents($DestFile));
		  	file_put_contents($DestFile, $contenu); 

		  	$DestFile="../CustomPage/".$RandomString."/CustomPage.js";

			if (!copy('../TmplCustomPage/CustomPage.js', $DestFile)) {

				$Success=0;	    
			}

			/* Configuration de la page web créée CUSTOMPAGE.JS */
			 
		  	$contenu = str_replace("USERTOLOAD", $WorkerEmail, file_get_contents($DestFile));
		  	file_put_contents($DestFile, $contenu); 

			if (!copy('../TmplCustomPage/GetDataCustomPage.php', '../CustomPage/'.$RandomString.'/GetDataCustomPage.php')) {

				$Success=0;		    
			}

			$Status=$Success;
			$CreationDate=date("Ymd");
			$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','CustomPageCreation',1)";
			$Result=$base->exec($sql);
		}

		if(!$Result){
			$Status=0;
			$CreationDate=date("Ymd");
			$sql="insert into log (UserEmail,Date,Category,Action,Result) values ('".$WorkerEmail."','".$CreationDate."','Profile','CustomPageCreation',0)";
			$Result=$base->exec($sql);

		}

	}

	else{

		/* La page perso existe déjà, il faut la mettre à jour */

		$CustomPageDir="";
		$sql="select * from custompage where WorkerID=".$WorkerID;
		foreach  ($base->query($sql) as $row) {
		
			$CustomPageDir=$row['CustomPage'];
									
		}
		$Suppress=unlink('../CustomPage/'.$CustomPageDir.'/index.php');

		if($Suppress){

			$BaseFile="../TmplCustomPage/".$CustomPageTemplate.".php";
			$DestFile="../CustomPage/".$CustomPageDir."/index.php";
			if (!copy($BaseFile, $DestFile)) {

				$Success=0;		    
			}
			else{
				$Success=1;
			}
		
		}
		
		else{

			$Success=0;
		}

		$Status=$Success;

	}

	$res = ["Success" => $Status];
	echo json_encode($res);

?>
