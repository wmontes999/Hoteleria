<?php
	$SessionDAO = new SessionDAO();		
	if (array_key_exists("usuario",$_POST)) {
		$usur_valid = $_POST["usuario"];
		$clav_valid = $_POST["password"];		
		$_SESSION['usur'] = $usur_valid;
		$_SESSION['pass'] = $clav_valid;		
	} else
	{
		$usur_valid = $_SESSION['usur'];
		$clav_valid = $_SESSION['pass'];		
	}
	$_SESSION['usurnom'] = '';
//	$_SESSION['TipoUsuar'] = 'Funcionario';
	$listusur = $SessionDAO->Getusuario($usur_valid,$clav_valid);
	foreach ($listusur as $value) {
		$_SESSION['usurnom'] = $value[2];
	}
		
?>