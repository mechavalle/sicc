<?
include("../lib/f_conectai.php"); 
include("../lib/f_fnBDi.php");

if(isset($_GET['tipo']))
	$tipo=$_GET['tipo'];
else
	exit();

if(isset($_GET['anio']))
	$anio=$_GET['anio'];
else
	$anio=date("Y");

# 1= x dia
# 2= x semana
# 3= x mes
# 4= x rango

if($tipo==1)
	$titulo="Seleccione el Día";
if($tipo==2)
	$titulo="Seleccione Semana Natural";
if($tipo==3)
	$titulo="Seleccione el Mes";
if($tipo==4)
	$titulo="Seleccione el Rango";
if($tipo==5)
	$titulo="Seleccione Semana Hábil";
?>

<html>

<head>
<meta http-equiv="Content-Language" content="es-mx">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><? echo $titulo;?></title>
<link rel="stylesheet" href="../lib/boot/css/bootstrap.min.css">
<script src="../lib/jquery.min.js"></script>
<script src="../lib/boot/js/bootstrap.min.js"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="../lib/fns.js"></SCRIPT>
<script src="../lib/jquery_1_12_1/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../lib/jquery_1_12_1/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../lib/jquery_1_12_1/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="../lib/stlinks.css" media="screen"></link>

<SCRIPT LANGUAGE="JavaScript">

<? 
if($tipo==1)
		echo "window.resizeTo(310,370);";

if($tipo==2)
		echo "window.resizeTo(360,375);";

if($tipo==3)
		echo "window.resizeTo(300,250);";

if($tipo==4)
		echo "window.resizeTo(620,400);";

if($tipo==5)
		echo "window.resizeTo(360,375);";
?>


function regresar(inicio,fin)
	{
	//alert(inicio);
	window.opener.document.getElementById('fecha1').value=inicio;
	window.opener.document.getElementById('fecha2').value=fin;
	window.opener.recargar();
	window.close();
	}

</SCRIPT>

</head>
<body>
<form method="GET" name="edicion" target="_self">
<div style="padding: 0 20px;">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><h4><font face="Arial"><? echo $titulo;?></font></h4></td>
			<td width="50" align="right"><a href="#" onclick="window.close();"><span class="glyphicon glyphicon-remove-circle" style="font-size: 30px; float: right;"></span></a></td>
		</tr>
	</table>
<? if($tipo==1) {?>
	

	<p align="center">
		<div id="datepickerdia"></div>
	</p>	
	<script>
	  $( function() {
	    $( "#datepickerdia" ).datepicker({
  dateFormat: "yy-mm-dd"
});
	  } );

	 </script>
	<p align="center">
		<button type="button" class="btn btn-success" onclick=" regresar(document.getElementById('datepickerdia').value,document.getElementById('datepickerdia').value);">OK</button>
	</p>

<? } ?>
<? if($tipo==2) {?>

	<script type="text/javascript">
		$(function() {
		    var startDate;
		    var endDate;
		    
		    var selectCurrentWeek = function() {
		        window.setTimeout(function () {
		            $('.week-picker').find('.ui-datepicker-current-day a').addClass('ui-state-active')
		        }, 1);
		    }
		    
		    $('.week-picker').datepicker( {
		    	dateFormat: "yy-mm-dd",
		        showOtherMonths: true,
		        selectOtherMonths: true,
		        onSelect: function(dateText, inst) { 
		            var date = $(this).datepicker('getDate');
		            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
		            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
		            var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
		            $('#startDate').text($.datepicker.formatDate( dateFormat, startDate, inst.settings ));
		            $('#endDate').text($.datepicker.formatDate( dateFormat, endDate, inst.settings ));
		            
		            selectCurrentWeek();
		        },
		        beforeShowDay: function(date) {
		            var cssClass = '';
		            if(date >= startDate && date <= endDate)
		                cssClass = 'ui-datepicker-current-day';
		            return [true, cssClass];
		        },
		        onChangeMonthYear: function(year, month, inst) {
		            selectCurrentWeek();
		        }
		    });
		    
		    $('.week-picker .ui-datepicker-calendar tr').live('mousemove', function() { $(this).find('td a').addClass('ui-state-hover'); });
		    $('.week-picker .ui-datepicker-calendar tr').live('mouseleave', function() { $(this).find('td a').removeClass('ui-state-hover'); });
		});
		</script>

	<div class="week-picker" style="margin-top: 10px; padding-left: 30;"></div>

	<script>
    $( "#datepicker" ).datepicker();
    </script>
    <div style="display: none"><span id="startDate"></span>-<span id="endDate"></span></div>
	<p align="center">
		<br>
		<button type="button" class="btn btn-success" onclick=" regresar(document.getElementById('startDate').innerHTML,document.getElementById('endDate').innerHTML);">OK</button>
	</p>

<?}?>

<?if($tipo==3){

$vanio=date("Y");
$vanio2=$vanio-5;
$aniov="";
for($i=$vanio2;$i<=$vanio;$i++)
	{
	if($i==$anio)
		$aniov .="<option selected value='$i'>$i</option>";
	else
		$aniov .="<option value='$i'>$i</option>";
	}

$mesv="";
$mes=date("m");
settype($mes,"integer");
for($i=1;$i<=12;$i++)
	{
	$inicio = $anio."-".completa($i,"0",2,"S")."-01";
	$fin=date("Y-m-t", strtotime($inicio));

	if($i==$mes)
		$mesv .="<option selected value='$inicio*$fin'>".mes($i)."</option>";
	else
		$mesv .="<option value='$inicio*$fin'>".mes($i)."</option>";
	}
?>
<form method="GET" name="edicion" target="_self">
<br>
<table border="0" width="100%" cellspacing="0" cellpadding="0">	
	<tr>
		<td height="25" width="70"><font face="Arial" size="2">Año:</font></td>
		<td>
			<select size="1" class="cenboxfrm" name="anio" onchange="document.edicion.submit();">
				<?echo $aniov;?>
			</select>
		</td>
	</tr>
	<tr>
		<td height="25" width="70"><font face="Arial" size="2">Mes:</font></td>
		<td>
			<select size="1" class="cenboxfrm" name="mes">
				<?echo $mesv;?>
			</select>
		</td>
	</tr>
</table>

<p align="center">
		<br>
		<button type="button" class="btn btn-success" onclick=" regresar(Left(document.edicion.mes.options[document.edicion.mes.selectedIndex].value,10),Right(document.edicion.mes.options[document.edicion.mes.selectedIndex].value,10));">OK</button>
</p>
<?}?>

<? if($tipo==4) {?>
	<span style="display: inline-block; margin: 15px;">
		<div>
    		<input class="cencuadro" type="checkbox" id="antes" name="antes" value="1">
    		<font face="Arial" size="2">Desde el inicio del tiempo</font>
  		</div>
		<div id="datepickerini"></div>
	</span>
	<span style="display: inline-block; margin: 15px;">
		<div>
    		<input class="cencuadro" type="checkbox"  id="despues" name="despues" value="1">
    		<font face="Arial" size="2">Hasta el infinito</font>
  		</div>
	<div id="datepickerfin"></div>
	</span>
	<!--
	<div class="row">
	  	<div class="col-sm-6">
	  		<div id="datepickerini"></div>
		</div>
	  	<div class="col-sm-6">
	  		<div id="datepickerfin"></div>
	  	</div>
	</div>
	-->
	<script>
	  $( function() {
	    $( "#datepickerini" ).datepicker({
  dateFormat: "yy-mm-dd"
  
});
	  } );

	 $( function() {
	    $( "#datepickerfin" ).datepicker({
  dateFormat: "yy-mm-dd"
});
	  } );

	 function valida()
	 	{
	 	 if(document.edicion.antes.checked==true)
	 	 	varinicial="";
	 	 else
	 	 	varinicial=document.getElementById('datepickerini').value;

	 	 if(document.edicion.despues.checked==true) 
	 	 	varfinal="";
	 	 else
	 	 	varfinal=document.getElementById('datepickerfin').value;

	 	 regresar(varinicial,varfinal);
	 	}

	 </script>
	<p align="center">
		<button type="button" class="btn btn-success" onclick="valida();">OK</button>
	</p>

<? } ?>


<? if($tipo==5) {?>

	<script type="text/javascript">
		$(function() {
		    var startDate;
		    var endDate;
		    
		    var selectCurrentWeek = function() {
		        window.setTimeout(function () {
		            $('.week-picker').find('.ui-datepicker-current-day a').addClass('ui-state-active')
		        }, 1);
		    }
		    
		    $('.week-picker').datepicker( {
		    	dateFormat: "yy-mm-dd",
		        showOtherMonths: true,
		        selectOtherMonths: true,
		        onSelect: function(dateText, inst) { 
		            var date = $(this).datepicker('getDate');
		            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 1);
		            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 5);
		            var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
		            $('#startDate').text($.datepicker.formatDate( dateFormat, startDate, inst.settings ));
		            $('#endDate').text($.datepicker.formatDate( dateFormat, endDate, inst.settings ));
		            
		            selectCurrentWeek();
		        },
		        beforeShowDay: function(date) {
		            var cssClass = '';
		            if(date >= startDate && date <= endDate)
		                cssClass = 'ui-datepicker-current-day';
		            return [true, cssClass];
		        },
		        onChangeMonthYear: function(year, month, inst) {
		            selectCurrentWeek();
		        }
		    });
		    
		    $('.week-picker .ui-datepicker-calendar tr').live('mousemove', function() { $(this).find('td a').addClass('ui-state-hover'); });
		    $('.week-picker .ui-datepicker-calendar tr').live('mouseleave', function() { $(this).find('td a').removeClass('ui-state-hover'); });
		});
		</script>

	<div class="week-picker" style="margin-top: 10px; padding-left: 30;"></div>

	<script>
    $( "#datepicker" ).datepicker();
    </script>
    <div style="display: none"><span id="startDate"></span>-<span id="endDate"></span></div>
	<p align="center">
		<br>
		<button type="button" class="btn btn-success" onclick=" regresar(document.getElementById('startDate').innerHTML,document.getElementById('endDate').innerHTML);">OK</button>
	</p>

<?}?>

</div>

<input type="hidden" name="tipo" <?echo "value='$tipo'"?>>
</form>

</body>

</html>