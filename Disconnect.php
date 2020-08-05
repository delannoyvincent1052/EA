<?php

	session_start();
	$_SESSION = array();
	session_unset();
	session_regenerate_id(TRUE);
	session_destroy();
?>

<script>
	document.location.href="Home.html"
</script>