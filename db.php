<?php
  try {

    $base = new PDO('mysql:host=localhost; dbname=eartisan', 'root', '');

  }

  catch(exception $e) {

    die('Erreur '.$e->getMessage());

  }
?>
