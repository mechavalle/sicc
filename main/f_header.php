<?
$mnuvis="";
$mnucat="";
$mnucon="";
switch ($mnu) 
  {
  case 'vistas': $mnuvis="active"; $mnucat=""; $mnucon=""; break;
  case 'catalogos': $mnuvis=""; $mnucat="active"; $mnucon=""; break;
  case 'configuracion': $mnuvis=""; $mnucat=""; $mnucon="active"; break;
  default: break;
  }

?>

<nav class="navbar navbar-inverse"  data-spy="affix" data-offset-top="80" style="background-color: #ddd; color: #070607; border: 0;">
  
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="../main/f_blank.php" style="padding: 3px 10px;">
        <img src="../img/Logo_CEIDE.png" class="img-responsive" style="width: 100px; height: auto;  ">
      </a>
      <a class="navbar-brand" href="../main/f_blank.php">
      <font color='#000066'>SICC</font></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="dropdown <? echo $mnuvis;?>">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Módulos
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
           
            <li><a href="../modClientes/f_consultaclientes.php">Clientes</a></li>          
           
                    
          </ul>
        </li>
        <li class="dropdown <? echo $mnucat;?>">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Catálogos
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../main/f_catalogo.php">Principal</a></li>
            
          </ul>
        </li>

          <li class="dropdown <? echo $mnucon;?>">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Configuración<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <!--<li><a href="#" onclick="abre('contraseña','../main/f_cambiocon.php?prefijo=mic&acceso=AdminComics',450,300,'AUTO');">Cambiar Contraseña</a></li>-->
              <li><a href="#" onclick="abre('contrasenia','../main/f_cambiopass.php',400,300,'AUTO');">Cambiar Contraseña</a></li>
              <li><a href="../main/f_consultausuarios.php">Usuarios</a></li>
              <li><a href="../main/f_consultatree.php?permiso=AdminModulos&desc=Categor%EDas de Modulos&tabla=adm_modcatego&maxnivel=2">Categoría Modulos</a></li>
              <li><a href="../main/f_consultamodulos.php">Modulos</a></li>
            
            </ul>
          </li>

      </ul>
      <ul class="nav navbar-nav navbar-right">        
        <li><a href="#" onclick="if(confirm('¿Salir de la aplicación?')) window.location.href='../main/f_salir.php';"><span class="glyphicon glyphicon-log-in"></span> Salir</a></li>
      </ul>
    </div>
  </div>
</nav>