<?php
  try {

    $base = new PDO('mysql:host=192.168.186.1; dbname=eartisan', 'root', '');

  }

  catch(exception $e) {

    die('Erreur '.$e->getMessage());

  }
?>
