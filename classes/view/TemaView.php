<?php

class TemaView
{

	public function __construct() {}

	public function show($temas)
	{
?>
		<!DOCTYPE html>
		<html lang="es">

		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Temas</title>
			<link rel="stylesheet" type="text/css" href="./css/styles.css">
		</head>

		<body>

			<div class="container">
				<h1>Temas</h1>

				<div class="button-group">
					<button class="btn-add" onclick="location.href='?tema/form'">Agregar
						Tema</button>
					<button class="btn-reload">Recargar</button>
					<button class="btn-nav" onclick="location.href='?'">Autores</button>
					<button class="btn-nav">Temas</button>
					<button class="btn-nav" onclick="location.href='?frase/show'">Frases</button>
				</div>
				<table>
					<thead>
						<tr>
							<th style="width: 50%;">Topic</th>
							<th>Num</th>
							<th>Acciones</th>
						</tr>
					</thead>

					<?php
					foreach ($temas as $tema) {
						$themeId = $tema->id;
						$themeName = $tema->name;
						$themeTotalPhrases = $tema->totalPhrases;

						echo " <tbody>
                                <tr>
                                    <td>$themeName</td>
                                    <td>$themeTotalPhrases</td>
                                    <td>";
						echo '<button style:"widht:20%;" class="btn-edit" onclick="location.href=\'?tema/editForm/' . $themeId . '\'">Editar</button>';
						echo "   <button class=\"btn-delete\" onclick=\"location.href='?tema/deleteTema/" . $themeId . " '\"> Eliminar</button>
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

	public function form($temaList, Tema $tema)
	{
		$name = $tema->__get('name');
		$errors = $tema->errors;

	?>

		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Temas</title>
			<link rel="stylesheet" type="text/css" href="./css/styles.css">
		</head>

		<body>

			<div class="container">
				<h1>Temas</h1>

				<div class="button-group">
					<button class="btn-add" onclick="location.href='?tema/show'">Agregar
						Tema</button>
					<button class="btn-reload">Recargar</button>
					<button class="btn-nav" onclick="location.href='?'">Autores</button>
					<button class="btn-nav">Temas</button>
					<button class="btn-nav" onclick="location.href='?frase/show'">Frases</button>
				</div>

				<div class="form-container">
					<form action="?tema/form" method="POST">
						<label for="name">Nombre:</label> <input type="text" id="name"
							name="name" value="<?= htmlspecialchars($name ?? '') ?>">
						<?php if (!empty($errors['name'])): ?>
							<span class="error"><?= $errors['name'] ?></span>
						<?php endif; ?>

						<button type="submit" class="btn-submit">Guardar</button>
					</form>
				</div>

				<table>
					<thead>
						<tr>
							<th style="width: 50%;">Topic</th>
							<th>Num</th>
							<th>Acciones</th>
						</tr>
					</thead>

					<?php
					foreach ($temaList as $tema) {
						$themeId = $tema->id;
						$themeName = $tema->name;
						$themeTotalPhrases = $tema->totalPhrases;

						echo " <tbody>
									<tr>
										<td>$themeName</td>
										<td>$themeTotalPhrases</td>
										<td>";
						echo '<button style:"widht:20%;" class="btn-edit" onclick="location.href=\'?tema/editForm/' . $themeId . '\'">Editar</button>';
						echo "   <button class=\"btn-delete\" onclick=\"location.href='?tema/deleteTema/" . $themeId . " '\"> Eliminar</button>
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

	public function editForm($temaList, Tema $theme)
	{
		$id = $theme->id;
		$name = $theme->name;

	?>

		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Temas</title>
			<link rel="stylesheet" type="text/css" href="./css/styles.css">
		</head>

		<body>

			<div class="container">
				<h1>Temas</h1>

				<div class="button-group">
					<button class="btn-add" onclick="location.href='?tema/show'">Agregar
						Tema</button>
					<button class="btn-reload">Recargar</button>
					<button class="btn-nav" onclick="location.href='?'">Autores</button>
					<button class="btn-nav">Temas</button>
					<button class="btn-nav" onclick="location.href='?frase/show'">Frases</button>
				</div>

				<div class="form-container">
					<form action="?tema/editForm" method="POST">
						<input type="hidden" name="id" value="<?php echo $id ?>">
						<label for="name">Nombre:</label>
						<input type="text" id="name" name="name" value="<?= htmlspecialchars($name ?? '') ?>">
						<button type="submit" class="btn-submit">Guardar</button>
					</form>
				</div>

				<table>
					<thead>
						<tr>
							<th style="width: 50%;">Topic</th>
							<th>Num</th>
							<th>Acciones</th>
						</tr>
					</thead>

					<?php
					foreach ($temaList as $tema) {
						$themeId = $tema->id;
						$themeName = $tema->name;
						$themeTotalPhrases = $tema->totalPhrases;

						echo " <tbody>
									<tr>
										<td>$themeName</td>
										<td>$themeTotalPhrases</td>
										<td>";
						echo '<button style:"widht:20%;" class="btn-edit" onclick="location.href=\'?tema/editForm/' . $themeId . '\'">Editar</button>';
						echo "   <button class=\"btn-delete\" onclick=\"location.href='?tema/deleteTema/" . $themeId . " '\"> Eliminar</button>
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
