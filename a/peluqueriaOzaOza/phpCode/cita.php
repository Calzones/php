<?PHP
	require "medotos.php";
	session_start();
	
	$fechaMal = isset($_POST["select"]) ? $_POST["select"] : '';
	if($fechaMal != ''){
		$_SESSION["fechaMal"] = $fechaMal;
	}
	$horaS = isset($_POST["reserva"]) ? $_POST["reserva"] : '';
	
	$usuario = $_SESSION["nombre"];
	$hora = "";
	$tabla = "";
	$fecha = "";
	
	$_SESSION["fechaMal"] = isset($_POST["select"]) ? $_POST["select"] : '';
	
	if($_SESSION["fechaMal"] != ''){
		list($anio, $mes, $dia) = split('[/.-]', $_SESSION["fechaMal"]);
		$fecha = $dia . "/" . $mes . "/" . $anio;
	
		$tabla = "<div class='divTabla'><table class='tabla'><th>Hora</th><th>$fecha</th>";
		for($i = 8; $i < 17; $i ++){
			$hora = $i . ":00";
			$tabla .=  "<tr>";
			if (getCita($fecha, $hora)->num_rows == 0){
				$tabla .= "<td>" . $hora . "</td><td><input type='radio' id='si' name='reserva' value='" . $hora . "'></td>";
			}else{
				$tabla .= "<td>" . $hora . "</td><td><label>Ta reservao manaso</label></td>";
			}
			$tabla .= "</tr>";
		}
		$tabla .= "</table></div>";
		if($horaS != ''){
			setCita($usuario, $fecha, $horaS);
		}
	}
		
	$array = array (
			"{usuario}" => $usuario,
			"{tabla}" => $tabla,
	);
	echo getTemplateReContraTocho("cita", $array);
?>