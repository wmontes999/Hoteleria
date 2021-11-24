<?php
class DatosESDAO {
     function __construct() {
        
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Realizar Consulta
      public function Getconstabl($Nombre,$Tabla,$Result) {
        $cnn = Conexion::Conectarse();
        try {
            $query = $cnn->prepare("SELECT $Nombre from $Tabla where ($Nombre = '$Result')");
            $query->execute();
			return $query->fetchAll();
        } catch (Exception $ex) {
            echo "Error:";            
        }finally {
            $cnn = null;
        }    
     }	 
/// Generar Maximo Valor
      public function MaxValor($Campo,$Tabla) {
        $cnn = Conexion::Conectarse();

        try {
            $query = $cnn->prepare("SELECT MAX($Campo) + 1 as MAX FROM $Tabla");
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $ex) {
            echo "Error:";
            
        }finally {
            $cnn = null;
        }    
     } 
/// Creacion de Registro
        public function Crear_Registro($tabla,$matriz) {
        $cnn = Conexion::Conectarse();
		$cad_mov = "";
		foreach ($matriz as $indice => $valgen) 
		{
			if ($matriz[$indice] == Null) {$cad_mov = $cad_mov.",Null";} else {
				$cad_mov = $cad_mov.",'".$matriz[$indice]."'";			
			}
		}
		$cad_mov = substr($cad_mov,1,strlen($cad_mov));	
        try {
            $query = $cnn->prepare("insert into $tabla values($cad_mov)");
            $query->execute();
			$id = $cnn->lastInsertId();
			return $id;
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage() .
            "En la línea: " . $ex->getLine();
        }finally {
            $cnn = null;
        }
    }
/// Modificacion de Registro
        public function Modificar_Registro($tabla,$Inic_matriz,$matriz,$where) {
        $cnn = Conexion::Conectarse();
		$cad_mov = "";
		foreach ($matriz as $indice => $valgen) {$cad_mov = $cad_mov.",".$Inic_matriz[$indice]." = '".$matriz[$indice]."'";}
		$cad_mov = substr($cad_mov,1,strlen($cad_mov));
        try {
            $query = $cnn->prepare("update $tabla set $cad_mov $where");
            $query->execute();
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage() .
            "En la línea: " . $ex->getLine();
        }finally {
            $cnn = null;
        }
    }
//// Eliminacion de Registro
        public function Eliminar_Registro($tabla,$where) {
        $cnn = Conexion::Conectarse();
        try {
            $query = $cnn->prepare("delete from $tabla $where");
            $query->execute();
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage() .
            "En la línea: " . $ex->getLine();
        }finally {
            $cnn = null;
        }
    }
}//function
/// Obtener Validacion de Tabla 
function Getvaltabl($Nombre,$Tabla,$Result) {
	$DatosESDAO = new DatosESDAO();
	$VarTabl = $DatosESDAO -> Getconstabl($Nombre,$Tabla,$Result);		  
	$Nombres_Tabl = "";
	foreach ($VarTabl as $value)
	{
		$Nombres_Tabl = $value[0];
	}
	if ($Nombres_Tabl <> "") {
		return true;
	}else{
		return false;
	}
}
function datos_empresa(){
	$DatosESDAO = new DatosESDAO();
	$VarEmpr = $DatosESDAO -> GetEmpresa();
	foreach ($VarEmpr as $value)
	{
		$Nombres_Empr = $value[1];
		$Dir_Empr     = $value[2];
		$RIF_Empr     = $value[4];
		$Tel_Empr     = $value[5];
	}
	return "$Nombres_Empr
			<br>RIF: $RIF_Empr
			<br>$Dir_Empr
			<br>Barquisimeto
			<br>Tlfno: $Tel_Empr";
}
function datos_pagos(){
 return '
<div class="item active selected" data-value="0">
	<i class="money icon"></i> Efectivo
</div>
<div class="item" data-value="Tarjeta">
	<i class="payment icon"></i> Tarjeta
</div>
<div class="item" data-value="Vaucher">
	<i class="browser icon"></i> Transferencia
</div>
<div class="item" data-value="Exoneración">
	<i class="asterisk icon"></i> Exoneración
</div> 
 ';	
}
function cuadro($t,$l,$w,$h,$nombre,$titulo,$contenido)
{
	$html = "
<div id='$nombre' align='center' style='
 position:absolute;
 top:$t%;
 left:$l%;
 width:".$w."%;
 height:".$d."px;
 background-color:#D0D0D0;
 overflow:auto; 
 border:double;
 -webkit-box-shadow: -16px 12px 8px -2px rgba(41,39,41,0.66);
 -moz-box-shadow: -16px 12px 8px -2px rgba(41,39,41,0.66);
 box-shadow: -16px 12px 8px -2px rgba(41,39,41,0.66);
'>
  <table width='100%' border='0' cellpadding='0' cellspacing='0' bordercolor='#000000' align='center'>
    <tr style='background:rgba(0,0,255,1);color:#FFFFFF;'>
      <td colspan='4'><div align='center'><strong>$titulo</strong></div></td>
    </tr>
    <tr style='color:#000000;font-size:14px' align='justify'>
      <td>$contenido</td>
    </tr>
    </table>      
</div>	";
 return $html;
}
function mes($mes_val){
	if ($mes_val == "01"){return "Enero";}
	if ($mes_val == "02"){return "Febrero";}
	if ($mes_val == "03"){return "Marzo";}
	if ($mes_val == "04"){return "Abril";}
	if ($mes_val == "05"){return "Mayo";}
	if ($mes_val == "06"){return "Junio";}
	if ($mes_val == "07"){return "Julio";}
	if ($mes_val == "08"){return "Agosto";}
	if ($mes_val == "09"){return "Septiembre";}
	if ($mes_val == "10"){return "Octubre";}
	if ($mes_val == "11"){return "Noviembre";}
	if ($mes_val == "12"){return "Diciembre";}
}
function dia($fecha){
	$regfech= substr($fecha,6,4)."/".substr($fecha,3,2)."/".substr($fecha,0,2);
	$i = strtotime($regfech);
	$Val_Dia = Array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
	$j = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i),date("d",$i), date("Y",$i)) , 0 );
	return $Val_Dia[$j];
}
function cargar_semestre()
{
	$DatosESDAO = new DatosESDAO();	
	$CargSem = $DatosESDAO -> GetCierreSem(date("Y"));
	$Id_Val = "";
	foreach ($CargSem as $value){
		$Id_Val = $value[0];
	}
	if ($Id_Val == "")
	{
	 $Id_Sem = Null;
	 $matriz = array($Id_Sem, '1', date("Y"), '0');	
	 $AgrProd = $DatosESDAO -> Crear_Registro("tbl_cierre_sem",$matriz);
	 $Id_Sem = Null;
	 $matriz = array($Id_Sem, '2', date("Y"), '0');	
	 $AgrProd = $DatosESDAO -> Crear_Registro("tbl_cierre_sem",$matriz);	 
	}
}
function act_semestre()
{
	$DatosESDAO = new DatosESDAO();	
	$An_Ant = date("Y")-1;
	$CargSem = $DatosESDAO -> GetCierreSem($An_Ant);
	$Id_Val = "";
	$Sta = "";
	foreach ($CargSem as $value){
		$Id_Val = $value[0];
		$Sta = $value[3];
	}
	if ($Sta == "0")
	{
		$where = "where (An = '$An_Ant')";
		$Inic_matriz = array("Sta");	
		$matriz = array("1");		
		$ModProd = $DatosESDAO -> Modificar_Registro("tbl_cierre_sem",$Inic_matriz,$matriz,$where);
	}
}
function subir_archivo()
{
	if($_FILES['file']['name'] != ''){
		 $archivo = $_FILES['file']['name']; 
		 if($archivo !=""){
		 @copy($_FILES['file']['tmp_name'],'..\archivos\resp_'.$archivo);}
		 return '..\archivos\resp_'.$archivo;
	} else {
		return '';
	}
}
function reg_bitac($usur,$modulo,$accion)
{
	$DatosESDAO = new DatosESDAO();
	$Fecha = date("d/m/Y");
	$Hora = date("h:i:s a");
	$RegFecha = date("Ymd");
	$IdBit = Null;
	$matriz = array($IdBit, $usur, $Fecha, $Hora, $modulo, $accion, $RegFecha);	
	$AgrProd = $DatosESDAO -> Crear_Registro("tbl_bitacora",$matriz);
}
?>