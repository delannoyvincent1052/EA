<?php

	session_start();
	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];

	require("common.php");	

	/* Récupération de la liste des factures pour l'utilisateur en cours */

	$NbOfInvoices=0;

	$sql="select * from invoice where WorkerID=".$WorkerID;

	foreach  ($base->query($sql) as $row) {
		
			$NbOfInvoices++;

	}

	$Result=0;

	if($NbOfInvoices>0){

		$Result=1;

	}

	$res = ["Success" => $Result];
	echo json_encode($res);

?>
