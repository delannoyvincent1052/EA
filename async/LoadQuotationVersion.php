<?php

	session_start();

	$WorkerEmail=$_POST['LoggedUser'];
	$WorkerSession=$_POST['UserSession'];
	$QuotationID=$_POST['QuotationID'];
	

	require("common.php");

	$ListOfVersion=array();
	$Counter=0;

	$sql="select * from generatedquotation where QuotationID=".$QuotationID;

	foreach  ($base->query($sql) as $row) {
		
		$ListOfVersion[$Counter]=$row['GenerationDate'];
		$Counter++;
									
	}	

	$res = ["Version" => $ListOfVersion, "NumberOfVersion" => $Counter];
	echo json_encode($res);


?>
