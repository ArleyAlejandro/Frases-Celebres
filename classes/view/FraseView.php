<?php

class FraseView
{

    public function show($frases)
    {
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Frases</title>
<link rel="stylesheet" type="text/css" href="./css/styles.css">
</head>
<body>

	<div class="container">
		<h1>Frases</h1>

		<div class="button-group">
			<button class="btn-add" onclick="location.href='?frase/form'">Agregar
				Frase</button>
			<button class="btn-reload">Recargar</button>
			<button class="btn-nav" onclick="location.href='?autor/show'">Autores</button>
			<button class="btn-nav" onclick="location.href='?tema/show'">Temas</button>
			<button class="btn-nav">Frases</button>
		</div>
		<table>
			<thead>
				<tr>
					<th>Frase</th>
					<th>Autor</th>
					<th>Tema</th>
					<th>Acciones</th>
				</tr>
			</thead>
                    
            <?php
        foreach ($frases as $frase) {
            $frase["id"] = 1;
            $autor = $frase["autor_nombre"];
            $tema = $frase["tema"];

            echo " <tbody>
                                <tr>
                                    <td>" . $frase["texto"] . "</td>
                                      <td>$autor</td>
                                      <td>$tema</td>
                                    <td>";
            echo '<button class="btn-edit" onclick="location.href=\'?frase/editForm/' . $frase['id'] . '\'">Editar</button>';
            echo "   <button class=\"btn-delete\" onclick=\"location.href='?frase/deleteAutor/" . $frase['id'] . " '\"> Eliminar</button>
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

    public function form($frasesList, Frase $fraseObject, $temas, $autores)
    {
//         echo "<pre>";
//         var_dump($temas);
//         echo "</pre>";
//         die;
//         $frase = $fraseObject->__get('name');
        // $description = $autor->__get('description');
        // $errors = $frase->errors;
        
        

        ?>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Frases</title>
<link rel="stylesheet" type="text/css" href="./css/styles.css">
</head>
<body>

	<div class="container">
		<h1>Frases</h1>

		<div class="button-group">
			<button class="btn-add" onclick="location.href='?frase/show'">Agregar
				Frase</button>
			<button class="btn-reload">Recargar</button>
			<button class="btn-nav" onclick="location.href='?autor/show'">Autores</button>
			<button class="btn-nav" onclick="location.href='?tema/show'">Temas</button>
			<button class="btn-nav">Frases</button>
		</div>

		<div class="form-container">
			<form action="?frase/form" method="POST">
				<label for="name">Nombre:</label> <input type="text" id="name"
					name="name" value="<?= htmlspecialchars($name ?? '') ?>">
                        <?php if (!empty($errors['name'])): ?>
                            <span class="error"><?= $errors['name'] ?></span>
                        <?php endif; ?>
                        
                <label for="author">Autor:</label> <input type="text"
					id="author" name="author"
					value="<?= htmlspecialchars($author ?? '') ?>">
                        <?php if (!empty($errors['author'])): ?>
                            <span class="error"><?= $errors['author'] ?></span>
                        <?php endif; ?>
                        
                 <label for="topic">Tema:</label> <input
					type="text" id="topic" name="topic"
					value="<?= htmlspecialchars($topic ?? '') ?>">
                        <?php if (!empty($errors['"topic"'])): ?>
                            <span class="error"><?= $errors['"topic"'] ?></span>
                        <?php endif; ?>
   	
        				<button type="submit" class="btn-submit">Guardar</button>
			</form>
		</div>

		<table>
			<thead>
				<tr>
					<th>Frase</th>
					<th>Autor</th>
					<th>Tema</th>
					<th>Acciones</th>
				</tr>
			</thead>
                    
            <?php
        foreach ($frasesList as $frase) {
            $frase["id"] = 1;
            $autor = $frase["autor_nombre"];
            $tema = $frase["tema"];

            echo " <tbody>
                                <tr>
                                    <td>" . $frase["texto"] . "</td>
                                      <td>$autor</td>
                                      <td>$tema</td>
                                    <td>";
            echo '<button class="btn-edit" onclick="location.href=\'?frase/editForm/' . $frase['id'] . '\'">Editar</button>';
            echo "   <button class=\"btn-delete\" onclick=\"location.href='?frase/deleteAutor/" . $frase['id'] . " '\"> Eliminar</button>
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

    public function editForm()
    {}
}

