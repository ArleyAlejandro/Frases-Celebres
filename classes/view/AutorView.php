<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

class AutorView
{

	public function __construct() {}

	public function show($autores)
	{
?>
		<!DOCTYPE html>
		<html lang="es">

		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Autores</title>
			<link rel="stylesheet" type="text/css" href="./css/styles.css">
		</head>

		<body>

			<div class="container">
				<h1>Autores</h1>

				<div class="button-group">
					<button class="btn-add" onclick="location.href='?autor/form'">Agregar
						Autor</button>
					<button class="btn-reload" onclick="location.href='?frase/loadDatabase'">Recargar</button>
					<button class="btn-nav">Autores</button>
					<button class="btn-nav" onclick="location.href='?tema/show'">Temas</button>
					<button class="btn-nav" onclick="location.href='?frase/show'">Frases</button>
				</div>
				<table>
					<thead>
						<tr>
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
                                    <td>$autor->name</td>
                                    <td>$autor->description</td>
                                    <td>$autor->phrases</td>
                                    <td>";
						echo '<button class="btn-edit" onclick="location.href=\'?autor/editForm/' . $autor->id . '\'">Editar</button>';
						echo "   <button class=\"btn-delete\" onclick=\"location.href='?autor/deleteAutor/" . $autor->id . " '\"> Eliminar</button>
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

	public function form($authorList, Autor $autor)
	{
		$name = $autor->name;
		$description = $autor->description;
		$errors = $autor->errors;

	?>

		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title> Autores</title>
			<link rel="stylesheet" type="text/css" href="./css/styles.css">
		</head>

		<body>

			<div class="container">
				<h1>Autores</h1>
				<div class="button-group">
					<button class="btn-add" onclick="location.href='?autor/show'">Agregar
						Autor</button>
					<button class="btn-reload" onclick="location.href='?frase/loadDatabase'">Recargar</button>
					<button class="btn-nav">Autores</button>
					<button class="btn-nav" onclick="location.href='?tema/show'">Temas</button>
					<button class="btn-nav" onclick="location.href='?frase/show'">Frases</button>
				</div>
				<div class="form-container">
					<form action="?autor/form" method="POST">
						<label for="name">Nombre:</label> <input type="text" id="name"
							name="name" value="<?= htmlspecialchars($name ?? '') ?>">
						<?php if (!empty($errors['name'])): ?>
							<span class="error"><?= $errors['name'] ?></span>
						<?php endif; ?>

						<label for="description">Descripción:</label> <input
							type="text" id="description" name="description"
							value="<?= htmlspecialchars($description ?? '') ?>">
						<?php if (!empty($errors['description'])): ?>
							<span class="error"><?= $errors['description'] ?></span>
						<?php endif; ?>

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

					foreach ($authorList as $autor) {

						echo " <tbody>
                                <tr>
                                   <td>$autor->id</td>
                                   <td>$autor->name</td>
                                    <td>$autor->description</td>
                                    <td>$autor->phrases</td>
                                                    <td>";
						echo '<button class="btn-edit" onclick="location.href=\'?autor/editForm/' . $autor->id . '\'">Editar</button>';
						echo "<button class=\"btn-delete\"> Eliminar</button>
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

	public function editForm($authorList, $author)
	{
		$id = $author->id;
		$name = $author->name;
		$description = $author->description;

	?>

		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Autores</title>
			<link rel="stylesheet" type="text/css" href="./css/styles.css">
		</head>

		<body>

			<div class="container">
				<h1>Autores</h1>

				<div class="button-group">
					<button class="btn-add" onclick="location.href='?autor/show'">
						Agregar Autor</button>
					<button class="btn-reload" onclick="location.href='?frase/loadDatabase'">Recargar</button>
					<button class="btn-nav">Autores</button>
					<button class="btn-nav" onclick="location.href='?tema/show'">Temas</button>
					<button class="btn-nav" onclick="location.href='?frase/show'">Frases</button>
				</div>

				<div class="form-container">
					<form action="?autor/editForm" method="POST">
						<input type="hidden" name="id" value="<?php echo $id ?>">
						<label for="name">Nombre: </label> <input type="text" id="name"
							name="name" value="<?php echo $name ?>">
						<label for="description">Descripción:</label>
						<input type="text" id="description" name="description"
							value="<?php echo $description ?>">

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

					foreach ($authorList as $autor) {

						echo " <tbody>
                        <tr>
                            <td>$autor->id</td>
                                   <td>$autor->name</td>
                                    <td>$autor->description</td>
                                    <td>$autor->phrases</td>
                                           <td>
                    <button class=\"btn-edit\" onclick=\"location.href='?autor/editForm/" . $autor->id. " '\">Editar</button>                   
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
