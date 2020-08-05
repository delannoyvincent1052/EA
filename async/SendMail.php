<?php

	function EmailConfirmation($MailTo, $ConfirmationCode){

		$de_nom = 'iart@devmail.com';
		$de_mail = 'iart@devmail.com';
		$reply_to = 'iart@devmail.com';
		$bcc='';

		$sujet='Confirmation de votre inscription';
		$message='<br><h3>Merci pour votre inscription sur I-ART</h3>';
		$message.='<p>Afin de finaliser votre inscription, veuillez cliquer sur le lien ci-dessous :</p>';
		$message.='<a href="http://eartisan/async/Finalize_Inscription.php?ConfirmationCode='.$ConfirmationCode.'&Email='.$MailTo.'">Valider votre inscription</a>';

		$entete  = "From: ".utf8_decode($de_nom)." <$de_mail>\r\n";
		$entete .= "Reply-To: $reply_to\r\n";
		if (!empty($bcc)) {
			$entete .= "Bcc: $bcc\r\n";
		}
		$entete .= "Return-Path: $de_mail\r\n";
		$entete .= "X-Mailer: PHP/".phpversion()."\n";
		$entete .= "MIME-Version: 1.0\n";
		$entete .= "Content-type: text/html; charset=utf-8\n";
		$entete .= "Content-Transfer-Encoding: 8bit\n";

		mail($MailTo, $sujet, $message, $entete);

	}

		function EmailPassword($MailTo, $Password){

		$de_nom = 'iart@devmail.com';
		$de_mail = 'iart@devmail.com';
		$reply_to = 'iart@devmail.com';
		$bcc='';

		$sujet='Votre mot de passe I-ART';
		$message='<br><h3>Merci pour utiliser le service I-ART</h3>';
		$message.='Votre mot de passe est : '.$Password;

		$entete  = "From: ".utf8_decode($de_nom)." <$de_mail>\r\n";
		$entete .= "Reply-To: $reply_to\r\n";
		if (!empty($bcc)) {
			$entete .= "Bcc: $bcc\r\n";
		}
		$entete .= "Return-Path: $de_mail\r\n";
		$entete .= "X-Mailer: PHP/".phpversion()."\n";
		$entete .= "MIME-Version: 1.0\n";
		$entete .= "Content-type: text/html; charset=utf-8\n";
		$entete .= "Content-Transfer-Encoding: 8bit\n";

		mail($MailTo, $sujet, $message, $entete);

	}

?>