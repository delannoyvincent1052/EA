<?php

	$Email=$_POST['EmailLogin'];
	$Password=$_POST['MdPLogin'];
	
	try {

    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

  	}

  	catch(exception $e) {

    	die('Erreur '.$e->getMessage());

  	}


	$sql="select * from Worker where Email='".$Email."' and Password='".$Password."';";
	
			
	$ValidWorker=0;
	$ValidAccount=0;
	

	foreach  ($base->query($sql) as $row) {
		
		$ValidWorker=1;
		if($row['Valid']==1){
			$ValidAccount=1;
		}
								
	}

	
	if($ValidWorker==1){

		if($ValidAccount==1){

			session_start();
			$SessionID=session_id();
			$res = ["Success" => "Valid","Session" => $SessionID, "Email" => $Email];
			echo json_encode($res);

			
		}

		if($ValidAccount==0){

			$res = ["Success" => "NotValid"];
			echo json_encode($res);

		}

	}
	

	if($ValidWorker==0){

		echo json_encode($ValidAccount);
	}

?>