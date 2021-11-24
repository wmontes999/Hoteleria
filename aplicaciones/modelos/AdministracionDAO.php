<?php
require_once "../modelos/DatosESDAO.php";
class AdministracionDao extends DatosESDAO {
     function __construct() {
        
    }
/// Obtener Usuarios
      public function GetUsuarios() {
        $cnn = Conexion::Conectarse();

        try {
            $query = $cnn->prepare("SELECT dni, nombre, usuario, Tipo, email, usur from tbl_usuarios");
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $ex) {
            echo "Error:";
            
        }finally {
            $cnn = null;
        }
    
     }
      public function GetUsuariosEst() {
        $cnn = Conexion::Conectarse();

        try {
            $query = $cnn->prepare("SELECT dni, nombre, usuario, email, usur from tbl_usu_alum");
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $ex) {
            echo "Error:";
            
        }finally {
            $cnn = null;
        }
    
     }
	 
/// Obtener Hoteles
      public function GetHoteles() {
        $cnn = Conexion::Conectarse();

        try {
            $query = $cnn->prepare("SELECT Id_Hotel,Nombre,Direccion,Ciudad,NIT,NumHab from tbl_Hoteles order by Id_Hotel Asc");
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $ex) {
            echo "Error:";
            
        }finally {
            $cnn = null;
        }
    
     }
	 
/// Obtener Habitacion
      public function GetTipHabit() {
        $cnn = Conexion::Conectarse();

        try {
            $query = $cnn->prepare("select Id_Mov_Acom, CONCAT(tip.Nombre,' ',aco.Nombre) as NombreHab from tbl_movacom mov 
inner join tbl_tiphab tip on mov.Id_TipHab = tip.Id_TipHab 
inner join tbl_acomodacion aco on aco.Id_Acomod = mov.Id_Acomod order by Id_Mov_Acom");
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $ex) {
            echo "Error:";
            
        }finally {
            $cnn = null;
        }
    
     }
	 
/// Obtener Habitacion
      public function GetTipHabitValid($Valor_1,$Valor_2) {
        $cnn = Conexion::Conectarse();

        try {
            $query = $cnn->prepare("select Id_Habitacion from tbl_Habitacion where (Id_Hotel = '$Valor_1') and (Id_Mov_Acom = '$Valor_2')");
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $ex) {
            echo "Error:";
            
        }finally {
            $cnn = null;
        }
    
     }
	 
      public function GetTipHabitSum($Valor_1) {
        $cnn = Conexion::Conectarse();

        try {
            $query = $cnn->prepare("select Sum(Cantidad) as Cantidad from tbl_Habitacion where (Id_Hotel = '$Valor_1')");
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $ex) {
            echo "Error:";
            
        }finally {
            $cnn = null;
        }
    
     }	 
	 
/// Permisos de Usuario
      public function GetCoor($Tabla) {
        $cnn = Conexion::Conectarse();
        try {
            $query = $cnn->prepare("SELECT * from $Tabla");
            $query->execute();
			return $query->fetchAll();
        } catch (Exception $ex) {
            echo "Error:";
            
        }finally {
            $cnn = null;
        }    
     }

      public function GetUsurCoor($Tabla,$Campo,$usuario,$Id_Coor) {
        $cnn = Conexion::Conectarse();
        try {
            $query = $cnn->prepare("SELECT $Campo from $Tabla where usur = '$usuario' and $Campo = '$Id_Coor'");
            $query->execute();
			return $query->fetchAll();
        } catch (Exception $ex) {
            echo "Error:";
            
        }finally {
            $cnn = null;
        }    
     }
	function GetFechBit()
	{
			$cnn = Conexion::Conectarse();
			try {
				$query = $cnn->prepare("select distinct regfecha from tbl_bitacora order by regfecha desc");
				$query->execute();
				return $query->fetchAll();
			} catch (Exception $ex) {
				echo "Error:";
				
			}finally {
				$cnn = null;
			}    	
	}
	function GetBitacr($Fecha)
	{
			$cnn = Conexion::Conectarse();
			try {
				$query = $cnn->prepare("select bit.hora,bit.modulo,bit.accion from tbl_bitacora bit 
				inner join tbl_usuarios usr on usr.usur = bit.usur where (bit.regfecha = '$Fecha')");
				$query->execute();
				return $query->fetchAll();
			} catch (Exception $ex) {
				echo "Error:";
				
			}finally {
				$cnn = null;
			}    	
	}


}
?>