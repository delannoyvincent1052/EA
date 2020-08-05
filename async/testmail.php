<?php

		$caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$ConfirmationCode = '';
		
		for ($i = 0; $i < 100; $i++)
		{
			$ConfirmationCode .= $caracteres[rand(0, 60)];
		}

		require("SendMail.php");
		EmailConfirmation("jde@devmail.com",$ConfirmationCode);

?>