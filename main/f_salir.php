<?
session_name ("siccsession");
session_start();
unset($_SESSION['IDOwner']);
unset($_SESSION['IDBase']);
unset($_SESSION['IDU']);
unset($_SESSION['Avatar']);
unset($_SESSION['IDUser']);
unset($_SESSION['IDName']);
unset($_SESSION['logo']);
unset($_SESSION['vidamax']);
unset($_SESSION['vida']);
session_destroy();
echo "<html><head><title>Cerrar Sesion</title></head><body onLoad=\"window.location.href='../index.php'; \"></body></html>";
exit();
?>