<?php

	/* Fonction qui sert à AJAX à récupérer la liste des clients déclarés par cet utilisateur*/
	session_start();
	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	
	require("common.php");
	
	/* Récupération de la liste des clients du Worker */

	$CustomerList=array();

	$sql="select * from customer where OwnerID='".$WorkerID."' order by LastName;";

	$Counter=0;

	foreach  ($base->query($sql) as $row) {
		
		$CustomerList[$Counter][0]=$row['FirstName'];
		$CustomerList[$Counter][1]=$row['LastName'];
		$CustomerList[$Counter][2]=$row['Address1'];
		$CustomerList[$Counter][3]=$row['Address2'];
		$CustomerList[$Counter][4]=$row['CP'];
		$CustomerList[$Counter][5]=$row['City'];
		$CustomerList[$Counter][6]=$row['Tel1'];
		$CustomerList[$Counter][7]=$row['Tel2'];
		$CustomerList[$Counter][8]=$row['Email'];
		$CustomerList[$Counter][9]=$row['ID'];
		$Counter++;
																
	}
	
	$res = ["Success" => 1,"Customers" => $CustomerList,"NumberOfCustomer" => $Counter];
	echo json_encode($res);
?>