<?php

/*
 * Funci�n que se conecta con el servidor
 * y selecciona la base de datos activa.
 * Retorna un mensaje en caso exista error.
*/
function fnConnect( &$msg ){
	$cn=mysql_connect("localhost","webapp21","12345679");
	if(!$cn){
		$msg = "Error en la conexion.";
		return 0;
	}
	$n = mysql_select_db("webapp21",$cn);
	if(!$n){
		$msg = "Base de datos no existe.";
		mysql_close($cn);
		return 0;
	}
	return $cn;
}

/*
 * Funci�n que imprime un mensaje en el navegador.
 * 
*/

function say($cad){
	echo $cad . "\n";
}

/*
 * Funci�n que retorna la fecha actual.
*/
function fnNow(){
	$hoy = getdate(time());
	$fecha = $hoy["mday"]."-".$hoy["mon"]."-".$hoy["year"];
	return $fecha;
}

/*
 * Funci�n que inicia una sesi�n.
*/
function fnSessionStart(){
	session_start();
	if(!isset($_SESSION["codigo"])){
		$_SESSION["codigo"] = "";
	    $_SESSION["nombre"] = "Anonimo";
	    $_SESSION["canasta"] = null;
	    $_SESSION["seguro"] =  fnRnd( 1000, 9999 );
	}
}

/*
 * Funci�n que finaliza una sesi�n.
*/
function fnSessionEnd(){
	session_unset();
	session_destroy();
}

/*
 * Funci�n que muestra un mensaje.
*/
function fnShowMsg($title,$msg){
    say("<table align='center' width='300' border='1'>");
    say("<tr>");
    say("<th>$title</th>");
    say("</tr>");
    say("<tr>");
	say("<td>$msg</td>");    
    say("</tr>");
    say("</table>");
}

/*
 * Funci�n que muestra una l�nea de cabecera.
*/
function fnHeader(){
	$usuario = $_SESSION["nombre"];
	say("<table width='760' cellspacing='0' height='30'>");
    say("<tr>");
    say("<th align=left valign=middle>Cliente: $usuario</th>");
    say("<th align=right valign=middle>Fecha: ".fnNow()."</th>");
    say("</tr>");
    say("</table>");
}

/*
 * Funci�n que muestra un bot�n para regresar a la p�gina anterior.
*/
function fnBack(){
    return "<input type='button' Value='Back' onClick='history.back();'>";
}

function fnRedirect($pagina){
    $cad = "Location: http://" . $_SERVER['HTTP_HOST']
        . dirname($_SERVER['PHP_SELF']) . "/$pagina";
    header( $cad, True );
}

/*
 * Funci�n que retorna un link.
*/
function fnLink($link,$target,$mouseover,$msg){
	$cad = "<A href='$link' target='$target' ";
	$cad .= "onmouseout=\"self.status='';return true\" ";
	$cad .= "onmouseover=\"self.status='$mouseover' ;return true\">";
	$cad .= "$msg</A>";
	return $cad;
}

/*
 * Funci�n que retorna el men� de la aplicaci�n.
*/
function fnMenu(){
	$cad  = "<table border='1' width='100'>";
	$cad .= "<tr><td align='center'>" ;
	if( $_SESSION["codigo"] ) {
		$cad .= fnLink("cerrar.php","","Terminar de Sesion","Terminar");
	} else {
		$cad .= fnLink("default.php?op=1","","Inicio de Sesion","Inicio");
	}
	$cad .= "</td></tr>";

	$cad .= "<tr><td align='center'>" ;
	$cad .= fnLink("default.php?op=2","","Mostrar Catalogo","Catalogo");
	$cad .= "</td></tr>";
	
	if( $_SESSION["codigo"] ) {
		$cad .= "<tr><td align='center'>" ;
		$cad .= fnLink("default.php?op=3","","Mostrar Canasta","Canasta");
		$cad .= "</td></tr>";
	
		$cad .= "<tr><td align='center'>" ;
		$cad .= fnLink("default.php?op=4","","Pagar","Pagar");
		$cad .= "</td></tr>";
	}

	$cad .= "</table>" ;

	return $cad;
}

/*
 * Retorna un numero aleatorio entre $minimo y $maximo.
*/
function fnRnd($minimo, $maximo){
    srand((double)microtime()*1000000);
    $randval = rand($minimo, $maximo);
    return $randval;
}

/*
 * Funci�n que imprime las etiquetas de fin de pagina.
 * 
*/
function fnPageEnd(){
    say("</body>");
    say("</html>");
}
?>