<?php
class sessionDao {
     function __construct() {
        
    }

      public function GetUsuario($user,$clav) {
        $cnn = Conexion::Conectarse();

        try {
            $query = $cnn->prepare("SELECT usu.dni,usu.nombre,usu.usuario,usu.usur,usu.clav,usu.Tipo,usu.email FROM tbl_usuarios usu Where usur=? and clav=?");
                 $query->bindParam(1, $user);
                 $query->bindParam(2, $clav);
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