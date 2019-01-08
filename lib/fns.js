function Left(str, n){
	if (n <= 0)
	    return "";
	else if (n > String(str).length)
	    return str;
	else
	    return String(str).substring(0,n);
}
function Right(str, n){
    if (n <= 0)
       return "";
    else if (n > String(str).length)
       return str;
    else {
       var iLen = String(str).length;
       return String(str).substring(iLen, iLen - n);
    }
}

function Len(str){
       return String(str).length;
}	

function crearXMLHttpRequest() 
{
  var xmlHttp=null;
  if (window.ActiveXObject) 
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  else 
    if (window.XMLHttpRequest) 
      xmlHttp = new XMLHttpRequest();
  return xmlHttp;
}

function httpraiz()
{
var ruta=window.location.href.substring(0,window.location.href.lastIndexOf('/'));
return ruta.substring(0,ruta.lastIndexOf('/'));
}

function abre(nombre,url,vwidth,vheight,vscrollbar)
 {
	var settings="toolbar=no,location=no,directories=no,"+
	"status=no,menubar=no,scrollbars="+vscrollbar+","+
	"resizable=no,width="+vwidth+",height="+vheight+",top=150,left=150";
	nuevaventana=window.open(url,nombre,settings);	
	nuevaventana.focus();
	//if (window.focus) {newwindow.focus()}

}

function formatCurrency(num)
	{
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num))
		num = "0";
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10)
		cents = "0" + cents;
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
		num = num.substring(0,num.length-(4*i+3))+','+ num.substring(num.length-(4*i+3));
	return (((sign)?'':'-') + '$' + num + '.' + cents);
	}
	
function redondea(num)
	{
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num))
		num = "0";
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10)
		cents = "0" + cents;
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
		num = num.substring(0,num.length-(4*i+3))+','+ num.substring(num.length-(4*i+3));
	return (((sign)?'':'-')  + num + '.' + cents);
	}	
	
function hoy(completa)
	{
	var d=new Date();
	if(completa==true)
		return d.getDate()+'/'+d.getMonth()+'/'+d.getFullYear()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
	else
		return d.getDate()+'/'+d.getMonth()+'/'+d.getFullYear();
	}

function esnumero(value)
	{
	/*if (!/^([0-9])*$/.test(numero))
		return false;
	else
		return true;*/
	if (value == null || !value.toString().match(/^[-]?\d*\.?\d*$/)) return false;
		  return true;
	}	
	
function chkentrada(textonuevo){
    var st = textonuevo;

        patron =/[\n"']/; // Añade todos los caracteres no aceptados
	if(patron.test(st)){
		alert("Caracter invalido: "+Right(textonuevo,1));
		return false;
	}
        return true;
    
}

function proceder(fecha1,fecha2)
	{
	var anio1=fecha1.substring(0,4);
	var mes1=fecha1.substring(5,7);
	var dia1=fecha1.substring(8,10);
	var anio2=fecha2.substring(0,4);
	var mes2=fecha2.substring(5,7);
	var dia2=fecha2.substring(8,10);
	
	var date1 = new Date(Number(anio1),Number(mes1),Number(dia1));
	var date2 = new Date(Number(anio2),Number(mes2),Number(dia2));
	
	if(date2<=date1)
		return false;
	else
		return true;
	}