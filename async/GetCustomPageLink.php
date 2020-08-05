<?php

	/* Cette fonction va permettre de récupérer l'information sur la page perso existante */

	session_start();

	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	
	require("common.php");

	$CustomPageDir="";

	/* Récupération du répertoire de la page perso */

	$sql="select * from custompage where WorkerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
		$CustomPageDir=$row['CustomPage'];

	}

	if($CustomPageDir!=""){
		
		$Status=1;
		
	}

	if($CustomPageDir==""){
		
		$Status=0;
		
	}

	$res = ["Success" => $Status, "CustomPageDir" => $CustomPageDir];
	echo json_encode($res);
?>