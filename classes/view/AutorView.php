<?php

class AutorView
{

    public function __construct()
    {}

    public function show($autores)
    {
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Autores</title>
<link rel="stylesheet" type="text/css" href="./css/styles.css">
</head>
<body>

	<div class="container">
		<h1>Lista de Autores</h1>

		<div class="button-group">
			<button class="btn-add" onclick="location.href='?autor/createForm'">
				Agregar Autor</button>
			<button class="btn-reload">Recargar</button>
			<button class="btn-nav">Autores</button>
			<button class="btn-nav">Temas</button>
			<button class="btn-nav">Frases</button>
		</div>

		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Autor</th>
					<th>Descripción</th>
					<th>Num</th>
					<th>Acciones</th>
				</tr>
			</thead>
                    
                    <?php

        foreach ($autores as $autor) {

            echo " <tbody>
                        <tr>
                            <td>" . $autor["id"] . "</td>
                            <td>" . $autor["name"] . "</td>
                            <td>" . $autor["description"] . "</td>
                            <td>" . $autor["total_frases"] . "</td>
                            <td>
                                <button class=\"btn-edit\" onclick=\"location.href='?autor/editForm'\"> Editar</button>
                                <button class=\"btn-delete\"> Eliminar</button>
                            </td>   
                        </tr>
                    </tbody>";
        }

        ?>
                    
		</table>
	</div>

</body>
</html>
<?php
    }

    public function createForm($autores)
    {
        ?>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Autores</title>
<link rel="stylesheet" type="text/css" href="./css/styles.css">
</head>
<body>

	<div class="container">
		<h1>Lista de Autores</h1>

		<div class="button-group">
			<button class="btn-add" onclick="location.href='?autor/show'">
				Agregar Autor</button>
			<button class="btn-reload">Recargar</button>
			<button class="btn-nav">Autores</button>
			<button class="btn-nav">Temas</button>
			<button class="btn-nav">Frases</button>
		</div>

		<div class="form-container">
			<form action="procesar_autor.php" method="POST">
				<label for="nombre">Nombre:</label> <input type="text" id="nombre"
					name="nombre" required> <label for="descripcion">Descripción:</label>
				<input type="text" id="descripcion" name="descripcion" required>

				<button type="submit" class="btn-submit">Guardar</button>
			</form>
		</div>

		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Autor</th>
					<th>Descripción</th>
					<th>Num</th>
					<th>Acciones</th>
				</tr>
			</thead>
			 <?php

        foreach ($autores as $autor) {

            echo " <tbody>
                        <tr>
                            <td>" . $autor["id"] . "</td>
                            <td>" . $autor["name"] . "</td>
                            <td>" . $autor["description"] . "</td>
                            <td>" . $autor["total_frases"] . "</td>
                            <td>
                                <button class=\"btn-edit\" onclick=\"location.href='?autor/editForm'\"> Editar</button>
                                <button class=\"btn-delete\"> Eliminar</button>
                            </td>   
                        </tr>
                    </tbody>";
        }

        ?>
		</table>
	</div>

</body>
</html>
<?php
    }

    public function editForm($autores)
    {
        ?>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Autores</title>
<link rel="stylesheet" type="text/css" href="./css/styles.css">
</head>
<body>

	<div class="container">
		<h1>Lista de Autores</h1>

		<div class="button-group">
			<button class="btn-add" onclick="location.href='?autor/show'">
				Agregar Autor</button>
			<button class="btn-reload">Recargar</button>
			<button class="btn-nav">Autores</button>
			<button class="btn-nav">Temas</button>
			<button class="btn-nav">Frases</button>
		</div>

		<div class="form-container">
			<form action="procesar_autor.php" method="POST">
				<label for="nombre">Nombre:</label> <input type="text" id="nombre"
					name="nombre" required> <label for="descripcion">Descripción:</label>
				<input type="text" id="descripcion" name="descripcion" required>

				<button type="submit" class="btn-submit">Guardar</button>
			</form>
		</div>

		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Autor</th>
					<th>Descripción</th>
					<th>Num</th>
					<th>Acciones</th>
				</tr>
			</thead>
			 <?php

        foreach ($autores as $autor) {

            echo " <tbody>
                        <tr>
                            <td>" . $autor["id"] . "</td>
                            <td>" . $autor["name"] . "</td>
                            <td>" . $autor["description"] . "</td>
                           <td>" . $autor["total_frases"] . "</td>
                            <td>
                                <button class=\"btn-edit\" onclick=\"location.href='?'\"> Editar</button>
                                <button class=\"btn-delete\"> Eliminar</button>
                            </td>   
                        </tr>
                    </tbody>";
        }

        ?>
		</table>
	</div>

</body>
</html>




<?php
    }
}

