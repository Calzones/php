<?PHP
	// Establece la conexion con la base de datos
	// Control de error en caso de que ocurra un error
	// Devuelve un objeto mysqli
	function conectar(){
		$mysqli = new mysqli ( "localhost", "root", "root", "peluqueria");
		if ($mysqli->connect_errno) {
			echo "Fallo la conexi�n con MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
		return $mysqli;
	}
	
	// Obtiene el contenido de una plantilla html.
	// Devuelve una string.
	function getTemplate($pagina) {
		return file_get_contents ('../htmlCode/'. $pagina . '.html');
	}
	
	// Obtiene el contenido de una plantilla html.
	// Sustituye un parametro concreto por una string pasada por parametro.
	// Devuelve una string.
	function getTemplateTocho($pagina, $remplazar, $mensaje) {
		return str_replace($remplazar, $mensaje, getTemplate($pagina));
	}
	
	// Obtiene el contenido de una plantilla html.
	// Sustituye multiples parametros por una string para cada uno.
	// Devuelve una string.
	function getTemplateReContraTocho($pagina, $cajita){
		$html = getTemplate($pagina);
		foreach($cajita as $remplazar=>$mensaje){
			$html = str_replace($remplazar, $mensaje, $html);
		}
		return $html;
	}
	
	// Hace una consulta a la base de datos.
	// Busca una coincidencia con un usuario y contrase�a concretos.
	// Devuelve un numero mayor o menor a 0.
	function inicioSesion($nombre, $contrase�a) {
		return conectar ()->query( "SELECT * FROM usuario WHERE nombre LIKE '$nombre' AND contrasenia LIKE '$contrase�a'");;
	}
	
	// Hace una consulta a la base de datos.
	// Busca una coincidencia con un usuario y contrase�a concretos.
	// Devuelve un numero mayor o menor a 0.
	function getCita($fecha, $hora){
		return conectar()->query("SELECT * FROM citas WHERE fecha LIKE '$fecha' AND hora LIKE '$hora'");
	}
	
	// Funcion super compleja construida con algoritmos sovieticos de la nasa rusa
	// Llama a la funcion date
	// Devuelve una string con la fecha y hora del dia de hoy
	function fecha($cadena){
		return date($cadena);
	}

	// Realiza un insert en la base de datos
	// En la tabla citas
	// No devuelve nada
	function setCita($usuario, $fecha, $hora, $motivo){
		conectar()->query("INSERT INTO citas (usuario, fecha, hora, motivo) VALUES('" . $usuario . "','" . $fecha . "','" . $hora . "','" . $motivo ."')");
	}
	
	// Hace una consulta a la base de datos.
	// Busca una coincidencia con un usuario.
	// Devuelve la hora, fecha y motivo de las citas de un usuario.
	function getMisCitas($usuario){
		$mySQLi = conectar();
		$mySQLi->real_query("SELECT hora, fecha, motivo FROM citas WHERE usuario LIKE '$usuario'");
		$resultado = $mySQLi->use_result();
		
		$misCitas = "<table><th>Hora</th><th>Fecha</th><th>Motivo</th>";
		
		while ($fila = $resultado->fetch_assoc()) {
			$misCitas .= "<tr><td>" . $fila['hora'] . "</td>";
			$misCitas .= "<td>" . $fila['fecha'] . "</td>";
			$misCitas .= "<td>" . $fila['motivo'] . "</td></tr>";
		}
		
		$misCitas .= "</table>";
		
		$cajita = array (
				"{usuario}" => $usuario,
				"{misCitas}" => $misCitas,
		);
		
		echo getTemplateReContraTocho("misCitas", $cajita);
	}
?>













