<?php
require_once( "egcc.php" );
fnSessionStart();
if($_SESSION["codigo"]){
	fnRedirect( "default.php" );
	return;
}
if( !isset($_POST["seguro"]) ) {
	fnRedirect( "default.php" );
	return;
}
$seguro = $_POST["seguro"];
if( $seguro != $_SESSION["seguro"] ) {
	fnRedirect( "default.php?op=1" );
	return;
}
$email = $_POST["email"];
$clave = $_POST["clave"];
$cn = fnConnect($msg);
$sql = "select idcliente, nomcliente from cliente2 ";
$sql .= "where email = '$email' and clave = '$clave'";
$rs = mysql_query($sql,$cn);
$rows = mysql_num_rows( $rs );
if( $rows == 0 ){
	fnRedirect( "default.php?op=10&nroerror=1" );
	return;
}
$_SESSION["codigo"] = mysql_result($rs,0,0);
$_SESSION["nombre"] = mysql_result($rs,0,1);
fnRedirect( "default.php" );
?>