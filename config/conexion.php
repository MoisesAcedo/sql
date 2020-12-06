<?php
$serverName = "your_server_name_here, your_server_port_here"; //serverName\instanceName(opcional),puerto
$connectionInfo = array( "Database"=>"your_bbdd_name_here", "UID"=>"oyur_user_bbdd_here", "PWD"=>"your_bbdd_password_here");
global $conn;
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Conexión establecida.<br />";
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>