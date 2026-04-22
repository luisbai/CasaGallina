<html>
	<body>
		<h2>Datos de contacto de descarga de publicación</h2>

		<p><b>Publicación Descargada</b>: {!! $publicacion->titulo !!}</p>
		<p><b>Nombre</b>: {{ $input['nombre'] }} <br/>
		<b>Correo</b>: {{ $input['email'] }} <br/>
		<b>Teléfono</b>: {{ $input['telefono'] }} <br/>
		<b>Organización</b>: {{ $input['organizacion'] }}</p>
	</body>
</html>