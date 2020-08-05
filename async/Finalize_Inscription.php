<?php

	if(isset($_GET['ConfirmationCode'])&&isset($_GET['Email'])){

		$ConfirmationCode=$_GET['ConfirmationCode'];
		$Email=$_GET['Email'];
	}
	
	try {

    	$base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

	}

	  catch(exception $e) {

	    die('Erreur '.$e->getMessage());

	}

	$ExistingConfirmation=0;

	$sql="select * from validationworker where Email='".$Email."' and ValidationCode='".$ConfirmationCode."';";

	foreach  ($base->query($sql) as $row) {
			
		$ExistingConfirmation=1;
			
	}

	/* Mise à jour du compte dans la table worker */

	if($ExistingConfirmation==1){

		$sql="update worker set Valid=1 where Email='".$Email."'";
		$Result=$base->exec($sql);

		/* Suppresion de l'élément correspondant dans la table de confirmation */

		$sql="delete from validationworker where Email='".$Email."'";
		$Result=$base->exec($sql);

		echo'<br>';
		echo'<center><img src="img/logoiart-mini.png" class="LogoLogin" /></center>';
		echo'<br>';
		echo'<center><h3>Votre inscription est bien validée. Vous pouvez maintenant vous connecter sur I-Art</h3></center>';
		echo'<br>';
		echo'<center><a href="http://eartisan/Login.html">Connexion</a></center>';

	}

	else{

		/* Code de validation erroné */
		echo'<br>';
		echo'<center><img src="img/logoiart-mini.png" class="LogoLogin" /></center>';
		echo'<br>';
		echo'<center><h3>Cette validation n\' pas valable.</h3></center>';
		
	}

	



?>