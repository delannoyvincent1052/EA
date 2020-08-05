<?php
	require_once(__DIR__ . '/class.phpmailer.php'); 
	require_once(__DIR__ . '/class.smtp.php');

	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = 'smtp.lhmail.fr';
	$mail->SMTPAuth   = true;
	$mail->Username = "Votre_adresse@domaine.com";		// A PERSONNALISER
	$mail->Password = "votre_mot_de_passe";				// A PERSONNALISER
	$mail->SMTPSecure = 'tls';
	$mail->Port = 25;
	 
	// Expéditeur
	$mail->SetFrom($mail->Username, 'Nom de contact');	// A PERSONNALISER
	// Destinataire
	$mail->AddAddress('destinataire', '');				// A PERSONNALISER
	// Objet
	$mail->Subject = 'Objet du message';				// A PERSONNALISER
	// Votre message
	$mail->MsgHTML('Contenu du message en HTML');		// A PERSONNALISER

	// Envoi du mail avec gestion des erreurs
	if(!$mail->Send()) {
	  echo 'Erreur : ' . $mail->ErrorInfo;
	} else {
	  echo 'Message envoyé !';
	}