<?php
	
	/*echo json_encode($_POST['email']);*/

	

	$Email="delannoyvincent@free.fr";
	$Password="Password01";
	
	include("db.php");

	$sql="select * from Worker where Email='$Email' and Password='$Password'";
	echo $sql;
		
	$ValidWorker=0;

	foreach  ($base->query($sql) as $row) {
		
		$ValidWorker=1;
								
	}

	if($ValidWorker==1){

		echo json_encode($_POST['email']);
		session_start();
		header("Location: Index.html");
	}
?>