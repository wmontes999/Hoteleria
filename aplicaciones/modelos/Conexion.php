<?php
date_default_timezone_set('America/La_Paz');
class Conexion {
	
     public static function Conectarse() {
        $conexion = null;
        try {
			$TipoConexion = "1";
			$host = "localhost";
			$usur = "root";
			$pass = "123456";
			$basdat = "dbhotel";
			if ($TipoConexion == "1") { $conexion = new PDO('mysql:host='.$host.';dbname='.$basdat, $usur, $pass);}
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $pdoe) {
            echo 
           "Error: " .substr($pdoe, 0, 122)  .
              
            " En la línea: " . $pdoe->getLine();
        }  
        return $conexion;
    }
    
}
?>