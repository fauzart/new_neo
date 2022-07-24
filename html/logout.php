<?php
   session_start();
   session_unset();
   session_destroy();
   $m="Logged Out.";
   
   include "inc.common.php";
   header("Location: index$ext?x=success&m=$m");
?>