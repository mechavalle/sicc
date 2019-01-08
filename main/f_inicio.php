<?
include("../lib/f_conectai.php"); 
include("../lib/f_fnBDi.php");

#Vemos si esta logueado el usuario
session_name ("micsession");
session_start();
if(isset($_SESSION['vida']) && isset($_SESSION['vidamax']))
  {
  $idowner=$_SESSION['IDOwner'];  
  $IDU=$_SESSION['IDU'];
  $IDBase=$_SESSION['IDBase'];
  $IDUser=$_SESSION['IDUser'];
  $IDName=$_SESSION['IDName'];
  $avatar=$_SESSION['Avatar'];
  $Empresa=$_SESSION['Empresa'];
  $conexio=conecta($IDBase);
  $IDL=permiso("AdminComics",$IDU);  
  #echo $IDL;
  if($IDL<1)
    {
    echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Usted no tiene acceso a este modulo.'); window.close(); \"></body></html>";
    exit();
    }
  if($_SESSION['vidamax']>0)
    {
    if(($_SESSION['vida']+$_SESSION['vidamax']) <= time())
      {   
      echo "<html><head><title>Log-In</title></head><body onLoad=\" alert('Su sesion ha expirado, debe autentificarse nuevamente para continuar.'); wx=window.parent; wx.location.href='../index.php'; \"></body></html>";
      exit();
      }
    else
      {
      $_SESSION['vida']=time();
      session_write_close();
      }
    } 
  }
else
  { 
  header("location:../index.php");
  header("Cache-control: private");
  die();
  } 

 ###resultados por página
 $numpag=traedato2("select valor from adm_parametros where idowner='$idowner' and parametro='numpag' and status='1'","valor"); 
 if($numpag<0)
    $numpag=25;

  ###directorio
$consulta="select * from adm_archivos where modulo='numcomics'";
$resx = mysqli_query($conexio,$consulta);
if($val=mysqli_fetch_array($resx))
  {
  $laruta=$val['ruta'];
  $latabla=$val['tabla'];
  }
else
  {
  echo "Error en la configuración de archivos";
  exit();
  }
mysqli_free_result($resx);

if($laruta==-1)
  echo "<br><font color='#ff0000'><b>ERROR</b> No existe ruta para los archivos";
if($latabla==-1)
  echo "<br><font color='#ff0000'><b>ERROR</b> No existe tabla para los archivos";
  
if(isset($_GET['titulo']))
  $titulo=$_GET['titulo'];
else
  $titulo="";
if(isset($_GET['vista']))
  $vista=$_GET['vista'];
else
  {
  if(strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android'))
    $vista=traedato2("select valor from adm_parametros where idowner='$idowner' and parametro='viewmobil' and status='1'","valor");
  else
    $vista=traedato2("select valor from adm_parametros where idowner='$idowner' and parametro='viewdesktop' and status='1'","valor");
  }
$vartitulo="var vartitulo = [";
$csql = "SELECT * from `cat_comics` where idowner='$idowner' and status='1' order by `descripcion` asc";
$resx = mysqli_query($conexio, $csql);
while($val=mysqli_fetch_array($resx)) 
    $vartitulo .="\"".$val['descripcion']."\",";
mysqli_free_result($resx);
if($vartitulo!="")
  $vartitulo=substr($vartitulo,0,strlen($vartitulo)-1)."];";
else
   $vartitulo .="];";
 
if(isset($_GET['subtitulo']))
  $subtitulo=$_GET['subtitulo'];
else
  $subtitulo="";

if(isset($_GET['ideditorial']))
  $ideditorial=$_GET['ideditorial'];
else
  $ideditorial="0";
if($ideditorial=="0")
  $ideditorialv="<option selected value='0'>(todos)</option>";
else
  $ideditorialv="<option value='0'>(todos)</option>";
$csql = "SELECT * from `cat_editoriales` where idowner='$idowner' and status='1' order by `descripcion` asc;";
$resx = mysqli_query($conexio, $csql);
while($val=mysqli_fetch_array($resx)) 
  {
  if($val['id']==$ideditorial)
    $ideditorialv .="<option selected value='".$val['id']."'>".$val['descripcion']."</option>";
  else
    $ideditorialv .="<option value='".$val['id']."'>".$val['descripcion']."</option>";
  }
mysqli_free_result($resx);

if(isset($_GET['ididioma']))
  $ididioma=$_GET['ididioma'];
else
  $ididioma="0";
if($ididioma=="0")
  $ididiomav="<option selected value='0'>(todos)</option>";
else
  $ididiomav="<option value='0'>(todos)</option>";
$csql = "SELECT * from `cat_idiomas` where idowner='$idowner' and status='1' order by `descripcion` asc;";
$resx = mysqli_query($conexio, $csql);
while($val=mysqli_fetch_array($resx)) 
  {
  if($val['id']==$ididioma)
    $ididiomav .="<option selected value='".$val['id']."'>".$val['descripcion']."</option>";
  else
    $ididiomav .="<option value='".$val['id']."'>".$val['descripcion']."</option>";
  }
mysqli_free_result($resx);

if(isset($_GET['idpublicacion']))
  $idpublicacion=$_GET['idpublicacion'];
else
  $idpublicacion="0";
if($idpublicacion=="0")
  $idpublicacionv="<option selected value='0'>(todos)</option>";
else
  $idpublicacionv="<option value='0'>(todos)</option>";
$csql = "SELECT * from `cat_publicaciones` where idowner='$idowner' and status='1' order by `descripcion` asc;";
$resx = mysqli_query($conexio, $csql);
while($val=mysqli_fetch_array($resx)) 
  {
  if($val['id']==$idpublicacion)
    $idpublicacionv .="<option selected value='".$val['id']."'>".$val['descripcion']."</option>";
  else
    $idpublicacionv .="<option value='".$val['id']."'>".$val['descripcion']."</option>";
  }
mysqli_free_result($resx);

if(isset($_GET['idformato']))
  $idformato=$_GET['idformato'];
else
  $idformato="0";
if($idformato=="0")
  $idformatov="<option selected value='0'>(todos)</option>";
else
  $idformatov="<option value='0'>(todos)</option>";
$csql = "SELECT * from `cat_formatos` where idowner='$idowner' and status='1' order by `descripcion` asc;";
$resx = mysqli_query($conexio, $csql);
while($val=mysqli_fetch_array($resx)) 
  {
  if($val['id']==$idformato)
    $idformatov .="<option selected value='".$val['id']."'>".$val['descripcion']."</option>";
  else
    $idformatov .="<option value='".$val['id']."'>".$val['descripcion']."</option>";
  }
mysqli_free_result($resx);

$arrcomics=array();
$arrdato=array();
$ids="0";
$consulta="SELECT a.id,b.descripcion as titulo,a.subtitulo,c.descripcion as publicacion,d.descripcion as editorial,a.limite,g.archivo  
FROM ope_comics a 
left join cat_comics as b on a.idcomicm=b.id 
left join cat_publicaciones as c on a.idpublicacion=c.id 
left join cat_editoriales as d on a.ideditorial=d.id
left join cat_publicaciones as e on a.idpublicacion=e.id 
left join cat_formatos as f on a.idformato=f.id 
left join arc_numeros as g on a.idimagen=g.id 
where a.idowner='$idowner' and a.status='1' ";

$consultaT1="";
$consultaT2="";
$consultaT3="";
$consultaT4="";
$consultaT5="";
$consultaT6="";

if($titulo!="")
  $consultaT1 .="(b.descripcion like '%".$titulo."%' ) ";
if($subtitulo!="")
  $consultaT2 .="(a.subtitulo like '%".$subtitulo."%' ) ";
if($ideditorial!="0")
  $consultaT3 .="(a.ideditorial = '".$ideditorial."' ) ";
if($ididioma!="0")
  $consultaT4 .="(a.ididioma = '$ididioma' ) ";
if($idpublicacion!="0")
  $consultaT4 .="(a.idpublicacion = '$idpublicacion' ) ";
if($idformato!="0")
  $consultaT4 .="(a.idformato = '$idformato' ) ";

$consulta2="";
if($consultaT1!="")
  $consulta2 .="AND ".$consultaT1;
if($consultaT2!="")
  $consulta2 .="AND ".$consultaT2;
if($consultaT3!="")
  $consulta2 .="AND ".$consultaT3;
if($consultaT4!="")
  $consulta2 .="AND ".$consultaT4;  
if($consultaT5!="")
  $consulta2 .="AND ".$consultaT5; 
if($consultaT6!="")
  $consulta2 .="AND ".$consultaT6;   


mysqli_query($conexio, $consulta.$consulta2);
$total=mysqli_affected_rows($conexio);

if(isset($_GET['limite'])){
  $limite=$_GET['limite'];
  if($total<=$numpag){
    if($limite=="")
      $limitev="";
    else
      $limitev="<li><a href='#' onclick=\"limitame('');\">Todo</a></li>";
    }
  else {
    if($limite=="")
      $limitev="<li class='active'><a href='#' onclick=\"limitame('');\">Todo</a></li>";
    else
      $limitev="<li><a href='#' onclick=\"limitame('');\">Todo</a></li>";
    $sub=-1;
    $k=0;
    while($sub+$numpag<=$total-1){
      $k=$k+1;
      $limiter=sprintf("LIMIT %s,%s",$sub+1,$numpag);
      #$limitev .=sprintf("<option selected value='%s'>%s-%s</option>",$limiter,$sub+2,$sub+26);
      if($limite==$limiter)
        $limitev .=sprintf("<li class='active'><a href='#' onclick=\"limitame('%s');\">%s</a></li>",$limiter,$k);
      else
        $limitev .=sprintf("<li><a href='#' onclick=\"limitame('%s');\">%s</a></li>",$limiter,$k);
      $sub=$sub+$numpag;
      }
    if($sub<$total-1)
      {
      $k=$k+1;
      $limiter=sprintf("LIMIT %s,%s",$sub+1,$numpag);
      if($limite==$limiter)
        $limitev .=sprintf("<li class='active'><a href='#' onclick=\"limitame('%s');\">%s</a></li>",$limiter,$k);
      else
        $limitev .=sprintf("<li><a href='#' onclick=\"limitame('%s');\">%s</a></li>",$limiter,$k);
      }
    }
  }
else {
  #Calculamos limite
  if($total<=$numpag){
    $limitev="";
    $limite ="";}
  else {
    $limitev="<li><a href='#' onclick=\"limitame('');\">Todo</a></li>";
    $sub=-1;
    $limiter=sprintf("LIMIT %s,%s",$sub+1,$numpag);
    $k=1;
    $limitev .=sprintf("<li class='active'><a href='#' onclick=\"limitame('%s');\">%s</a></li>",$limiter,$k);
    $sub=24;
    while($sub+$numpag<=$total-1){
      $k=$k+1;
      $limiter=sprintf("LIMIT %s,%s",$sub+1,$numpag);
      $limitev .=sprintf("<li><a href='#' onclick=\"limitame('%s');\">%s</a></li>",$limiter,$k);
      $sub=$sub+$numpag;
      }
    if($sub<$total-1)
      {
      $k=$k+1;
      $limiter=sprintf("LIMIT %s,%s",$sub+1,$numpag);
      $limitev .=sprintf("<li><a href='#' onclick=\"limitame('%s');\">%s</a></li>",$limiter,$k);
      }
    $limite="LIMIT 0,$numpag";
    }
  }
$total2=traedato2("select ifnull(count(id),0) as resu from ope_numeros where idowner='$idowner'","resu");
$consulta .=$consulta2." order by b.descripcion,a.subtitulo $limite";
#echo $consulta;
$res2 = mysqli_query($conexio,$consulta);
        
while($val=mysqli_fetch_array($res2))
  {
  $ids .=",".$val['id'];
  $arrdato[0]=$val['id']; 
  $arrdato[1]=$val['titulo']; 
  $arrdato[2]=$val['subtitulo'];
  $arrdato[3]=$val['publicacion'];
  $arrdato[4]=$val['editorial'];
  $arrdato[5]=$val['limite'];  
  $arrdato[6]=0; #total de comics
  if($val['archivo']=="")
    $arrdato[7]="../img/genericoc.png";  #portada
  else
    $arrdato[7]=$laruta."/".$val['archivo'];  #portada   
  array_push($arrcomics,$arrdato);         
  }
mysqli_free_result($res2); 
$ccomics=count($arrcomics);


#cantidades
$arrcantidades=array();
$csql="SELECT idcomic,count(id) as resu FROM ope_numeros where idowner='$idowner' and status='1' group by idcomic";
$res2 = mysqli_query($conexio,$csql);
while($val=mysqli_fetch_array($res2))
  {
  $arrdato[0]=$val['idcomic']; 
  $arrdato[1]=$val['resu']; 
  array_push($arrcantidades,$arrdato);           
  }
mysqli_free_result($res2);
$ccantidades=count($arrcantidades);

function cantidad($id)
  {
  global $arrcantidades;
  global $ccantidades;
  $res="";
  for($i=0;$i<$ccantidades;$i++)
      {
      if($arrcantidades[$i][0]==$id)
        {
        $res=$arrcantidades[$i][1];
        $i=$ccantidades;
        }
      }
    return $res;
  }

  #complementamos información

for($i=0;$i<$ccomics;$i++)
  {
  $arrcomics[$i][6]=cantidad($arrcomics[$i][0]);
  #$arrcomics[$i][7]=portada($arrcomics[$i][0]);
  }


#echo "<pre>".print_r($arrportadas,true)."</pre>";
#echo "<pre>".print_r($arrcomics,true)."</pre>";


?>
<!DOCTYPE html>
<html>
<head>
  <title>Mis Comics - Mi Colección</title>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="../img/iconop.png" type="image/x-icon">
  <link rel="stylesheet" href="../lib/fw/css/font-awesome.min.css">
  <link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
  <script src="../lib/jquery-2.1.1.min.js"></script>
  <script src="../lib/boot/js/bootstrap.min.js"></script>
  <SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<link type="text/css" rel="stylesheet" href="../lib/stlinks.css" media="screen"></link>
<link rel="stylesheet" href="../lib/stylecomics.css">
  <style>
    .autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9; 
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
  </style>
  <script type="text/javascript">
    function limitame(lim)
      {
      document.edicion.limite.value=lim;
      document.edicion.submit();
      }

    function alcargar()
      {
      <?
      if($consulta2=="")
        echo "document.getElementById('divboton').innerHTML=\"<font face='Arial' size='2'><b>$total&nbsp;Títulos Actuales</b></font>\";";
      else  
        echo "document.getElementById('divboton').innerHTML=\"<font face='Arial' size='2'><b>$total&nbsp;Coincidencias</b></font>\";";
      ?>
      }
    function cambiarvista(lavista)
      {
      document.edicion.vista.value=lavista;
      document.edicion.submit();
      }

  </script>
  <script type="text/javascript">

  
<? echo $vartitulo; ?>
    
    function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              document.edicion.submit();
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) { 
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) { x[currentFocus].click(); }
        }
      }
  });


  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
}
/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
    closeAllLists(e.target);
});
}
  </script>
</head>
<body onload="alcargar();">
<form method="GET" name="edicion" target="_self">
<? 
$mnu="";
$secbuscar=1;
include("f_header.php");?>
<br>
<div class="container-fluid bg-3"> 
    <div class="well well-sm">
        <div class="row">
          <div class="col-sm-3">
            <table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
              <tr>
                <td width="60" height="20"><font face="Verdana" size="1">Título:</font></td>
                <td height="20">
                  <div class="autocomplete" >
                    <input type="text" name="titulo" id="titulo" class="cenbox" onkeypress="if(event.keyCode==13) limitame('limit 0,25');" value="<?echo $titulo;?>">
                  </div>
                </td>
              </tr>
              <tr>
                <td width="60" height="20"><font face="Verdana" size="1">Subtitulo:</font></td>
                <td height="20">
                  <input type="text" name="subtitulo" class="cenbox" onkeypress="if(event.keyCode==13) limitame('limit 0,25');" value="<?echo $subtitulo;?>">
                </td>
              </tr>                     
            </table>
          </div>
          <div class="col-sm-3">
            <table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
              <tr>
                <td width="60" height="20"><font face="Verdana" size="1">Editorial:</font></td>
                <td height="20">
                  <select size="1" name="ideditorial" class='cenbox' onchange="limitame('limit 0,25');">
                    <?echo $ideditorialv;?>
                  </select>
                </td>
              </tr>
              <tr>
                <td width="60" height="20"><font face="Verdana" size="1">Idioma:</font></td>
                <td height="20">
                  <select size="1" name="ididioma" class='cenbox' onchange="limitame('limit 0,25');">
                    <?echo $ididiomav;?>
                  </select>
                </td>
              </tr>       
            </table>
          </div>
          <div class="col-sm-3">
            <table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
              <tr>
                <td width="60" height="20"><font face="Verdana" size="1">Publicación:</font></td>
                <td height="20">
                  <select size="1" name="idpublicacionv" class='cenbox' onchange="limitame('limit 0,25');">
                    <?echo $idpublicacionv;?>
                  </select>
                </td>
              </tr>
              <tr>
                <td width="60" height="20"><font face="Verdana" size="1">Formato:</font></td>
                <td height="20">
                  <select size="1" name="idformato" class='cenbox' onchange="limitame('limit 0,25');">
                    <?echo $idformatov;?>
                  </select>
                </td>
              </tr>       
            </table>
          </div>
          <div class="col-sm-3">
            <table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right" height="20">
                  <a href="#"  onclick="limitame('limit 0,25'); document.edicion.submit();"><span class="glyphicon glyphicon-refresh"></span>&nbsp;<font size="1" face="Verdana">Actualizar</font></a>
                  &nbsp;|&nbsp;<a href="#"  onclick="window.location.href='f_inicio.php';"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;<font size="1" face="Verdana">Limpiar</font></a>
                  
                </td>
              </tr> 
              <tr>
                <td align="right" height="20">
                  <font face='Arial' size="2"><b><? echo $total2; ?>&nbsp;Ejemplares</b></font> 
                </td>
              </tr> 


                   
            </table>
          </div>
        </div>
      </div>
    </div>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-2">
      <div id="divboton"><i class='fa fa-refresh fa-spin fa-2x'></i></div>
    </div>
    <div class="col-sm-8 text-center">
      <?if($total>$numpag)
          {
           echo "<div class='container-fluid bg-4 text-center'><ul class='pagination pagination-sm' style='margin: 0;'>$limitev";
           if($vista==1)
            echo "<li><a href='#' onclick='cambiarvista(2);'><span class='glyphicon glyphicon-th-list'></span></a></li>";
          if($vista==2)
            echo "<li><a href='#' onclick='cambiarvista(1);'><span class='glyphicon glyphicon-th'></span></a></li>";            
          echo "</ul></div>"; 
          }
  
      else
        {
        if($vista==1)
          echo "<div class='container-fluid bg-4 text-center'><a href='#' onclick='cambiarvista(2);'><span class='glyphicon glyphicon-th-list'></span></a></div>";
        if($vista==2)
          echo "<div class='container-fluid bg-4 text-center'><a href='#' onclick='cambiarvista(1);'><span class='glyphicon glyphicon-th'></span></a></div>";
        }
?>
  </div>
  <div class="col-sm-2 text-right">
    <? if($IDL>=2){?>
    <button type='button' class='btn btn-primary' onclick="abre('comic','f_comic.php',500,500,'AUTO');">Crear Nuevo Título</button> 
     <?}?>  
  </div>    
</div>

<?
#echo "<pre>".print_r($arrcomics,true)."</pre>";
#echo $vista;
if($ccomics<=0)
  echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Para iniciar la captura de Comics, utiliza primero 'Crear Nuevo Título'</div>";

if($vista==1)
  {
  echo "<div class='container-fluid bg-4 text-center'>";
  for($i=0;$i<$ccomics;$i++)
      {
      echo "<div class='well well-sm tarjeta'>";             
      echo "  <a href='f_consultanumgra.php?id=".$arrcomics[$i][0]."'>";
      if($arrcomics[$i][7]!="../img/genericoc.png")
        {
        if(file_exists($arrcomics[$i][7]))
          echo "  <img border='0' src='".$arrcomics[$i][7]."' class='img-responsive'></a>";
        else
          echo "  <img border='0' src='../img/genericoc.png' class='img-responsive'></a>";
        }
      else
        echo "  <img border='0' src='../img/genericoc.png' class='img-responsive'></a>";
       
      #echo "<img border='0' src='".$laruta."/".$val['archivo']."' ".tamanio($laruta."/".$val['archivo'],90,90)."></a>";
      echo "<span class='ctitulo'>".$arrcomics[$i][1]."</span>";
      if($arrcomics[$i][2]!="")
        echo "<span class='csubtitulo'>".$arrcomics[$i][2]."</span>";
      echo "<span class='cextra'>".$arrcomics[$i][4].", ".$arrcomics[$i][3]."</span>";
      if($arrcomics[$i][6]>0)
        {
        if($arrcomics[$i][5]>0)
          echo "  <span class='cnum'>".$arrcomics[$i][6]." de ".$arrcomics[$i][5]." números</span>";
        else
          echo "  <span class='cnum'>".$arrcomics[$i][6]." números</span>";  
        }
      else
         echo "  <span class='cnum'>Sin Números</span>"; 
      echo "</div>";
      }
    echo "</div>";
  }

if($vista==2)
  {
  echo "<div class='container-fluid bg-4 text-left'>";
  echo "<div class='table-responsive'>";
  echo "<table class='table'>
    <thead>
      <tr>
        <th></th>
        <th><font face='Arial' size='2'>Título</font></th>
        <th><font face='Arial' size='2'>Subtítulo</font></th>
        <th><font face='Arial' size='2'>Editorial</font></th>
        <th><font face='Arial' size='2'>Publicación</font></th>
        <th><font face='Arial' size='2'>Números</font></th>
        <th><font face='Arial' size='2'>Límite</font></th>
      </tr>
    </thead>
    <tbody>";
  for($i=0;$i<$ccomics;$i++)
      {
      $j=$i+1;
      $linkc="<a href='f_consultanumgra.php?id=".$arrcomics[$i][0]."'>";
      echo "<tr>";
      echo "<td><font face='Verdana' size='1' color='#808080'>$j</font></td>";
      echo "<td><font face='Arial' size='2'>$linkc".$arrcomics[$i][1]."</a></font></td>";
      echo "<td><font face='Arial' size='2'>$linkc".$arrcomics[$i][2]."</a></font></td>";
      echo "<td><font face='Arial' size='2'>$linkc".$arrcomics[$i][4]."</a></font></td>";
      echo "<td><font face='Arial' size='2'>$linkc".$arrcomics[$i][3]."</a></font></td>";
      echo "<td><font face='Arial' size='2'>$linkc".$arrcomics[$i][6]."</a></font></td>";
      echo "<td><font face='Arial' size='2'>$linkc".$arrcomics[$i][5]."</a></font></td>";
      echo "</tr>";
      }
    echo "</tbody></table></div></div>";
  }
?>


<?if($total>$numpag)
  echo "<div class='container-fluid bg-4 text-center'><ul class='pagination pagination-sm'>$limitev</ul></div>";
?> 
</div>
<br><br>

<? include("f_footer.php");?>

<script>
  autocomplete(document.getElementById("titulo"), vartitulo);
</script>
<input type="hidden" name="vista" <?echo "value='$vista'"?>>
<input type="hidden" name="limite" <?echo "value='$limite'"?>>
</form>
</body>
</html>