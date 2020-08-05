<?php
$de_nom = 'De_Nom';
$de_mail = 'monmail@orange.fr';
$reply_to = 'reply_to@orange.fr';
$bcc='';

$sujet='test';
$message='<br><h1>test</h1><br>';

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

mail("iart@devmail.com", $sujet, $message, $entete)
?>