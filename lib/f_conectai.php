<?php
function conecta($b) 
   { 
   if($b=="")
      $b="sicc";
   
   $mysqli = new mysqli("localhost", "root", "", $b);
   if ($mysqli->connect_errno)
      {
      echo "Error al conectar a la base de datos ($b): ". $mysqli->connect_error;
      }
   return $mysqli;

   }
 
?>
