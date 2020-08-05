<?php

	/* Cette fonction va permettre de récupérer la liste des catégories d'activité (plomberie, menuiserie, etc.) */

	session_start();

	$LoggedUser=$_POST['LoggedUser'];
	$UserSession=$_POST['UserSession'];
	
	require("common.php");

	/* Récupération de la liste */

	$Counter=0;
	$ActivityCategoryList=array();
	$sql="select * from workertype order by WorkerTypename";

	foreach  ($base->query($sql) as $row) {
		
		$ActivityCategoryList[$Counter][0]=$row['ID'];
		$ActivityCategoryList[$Counter][1]=$row['WorkerTypeName'];

		$Counter++;							
	}

	/*$res = ["Success" => 1, "ActivityCategoryList" => $ActivityCategoryList];*/
	$res = ["Success" => 1, "ActivityCategoryList" => $ActivityCategoryList, "NbOfActivityCategory" => $Counter];
	echo json_encode($res);
?>
