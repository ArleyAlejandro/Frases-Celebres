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
                    <button class="btn-reload" onclick="location.href='?frase/loadDatabase'">Recargar</button>
                    <button class="btn-nav" onclick="location.href='?autor/show'">Autores</button>
                    <button class="btn-nav" onclick="location.href='?tema/show'">Temas</button>
                    <button class="btn-nav" onclick="location.href='?frase/show'">Frases</button>
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
                        $fraseId = $frase->id;
                        $fraseTexto  =  $frase->texto;
                        $autorNombre = $frase->autor->name;
                        $temaNombre = $frase->tema ?? "null";

                        echo " <tbody>
                                <tr>
                                    <td>$fraseTexto</td>
                                      <td>$autorNombre</td>
                                      <td>$temaNombre</td>
                                    <td>";
                        echo '<button class="btn-edit" onclick="location.href=\'?frase/editForm/' . $fraseId . '\'">Editar</button>';
                        echo "   <button class=\"btn-delete\" onclick=\"location.href='?frase/deleteFrase/" . $fraseId . " '\"> Eliminar</button>
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

    public function form($frasesList, Frase $frase, $temas, $autores)
    {
        $errors = $frase->errors;
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
                    <button class="btn-reload" onclick="location.href='?frase/loadDatabase'">Recargar</button>
                    <button class="btn-nav" onclick="location.href='?autor/show'">Autores</button>
                    <button class="btn-nav" onclick="location.href='?tema/show'">Temas</button>
                    <button class="btn-nav" onclick="location.href='?frase/show'">Frases</button>
                </div>

                <!-- Form de agregar frases -->
                <div class="form-container">
                    <form action="?frase/form" method="POST">

                        <!-- Nombre de la frase -->
                        <label for="name">Nombre:</label> <input type="text" id="name" name="name">

                        <!-- Mensaje de error si existe -->
                        <?php if (!empty($errors['name'])): ?>
                            <span class="error"><?= $errors['name'] ?></span>
                        <?php endif; ?>

                        <!-- Nombre del autor -->
                        <label for="author">Autor:</label> <select name="author" id="author-select">
                            <?php

                            // select con lista de autores
                            foreach ($autores as $autor) {
                                echo '<option value="' . $autor->id . '">' . $autor->name . '</option>';
                            }
                            ?>
                        </select>

                        <!-- Mensaje de error si existe -->
                        <?php if (!empty($errors['author'])): ?>
                            <span class="error"><?= $errors['author'] ?></span>
                        <?php endif; ?>

                        <!-- nombre de la frase -->
                        <label for="topic">Tema:</label> <select name="topic" id="topic">
                            <?php

                            // select con lista de temas
                            foreach ($temas as $tema) {
                                echo '<option value="' . $tema->name . '">' . $tema->name . '</option>';
                            }
                            ?>
                        </select>

                        <!-- Mensaje de error si existe -->
                        <?php if (!empty($errors['topic'])): ?>
                            <span class="error"><?= $errors['topic'] ?></span>
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

                        $fraseId = $frase->id;
                        $fraseTexto  =  $frase->texto;
                        $autorNombre = $frase->autor->name;
                        $temaNombre = $frase->tema ?? "null";
                        echo " <tbody>
                                <tr>
                                    <td>$fraseTexto</td>
                                      <td>$autorNombre</td>
                                      <td>$temaNombre</td>
                                    <td>";
                        echo '<button class="btn-edit" onclick="location.href=\'?frase/editForm/' . $fraseId . '\'">Editar</button>';
                        echo "   <button class=\"btn-delete\" onclick=\"location.href='?frase/deleteAutor/" . $fraseId . " '\"> Eliminar</button>
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

    public function editForm($frasesList, Frase $frase, $temas, $autores)
    {
        $errors = $frase->errors;

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
                    <button class="btn-reload" onclick="location.href='?frase/loadDatabase'">Recargar</button>
                    <button class="btn-nav" onclick="location.href='?autor/show'">Autores</button>
                    <button class="btn-nav" onclick="location.href='?tema/show'">Temas</button>
                    <button class="btn-nav" onclick="location.href='?frase/show'">Frases</button>
                </div>

                <div class="form-container">
                    <form action="?frase/editForm" method="POST">
                        <input type="hidden" name="id" value="<?php echo $frase->id ?>">
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" name="name" value=" <?php echo $frase->texto; ?>">
                        <?php if (!empty($errors['name'])): ?>
                            <span class="error"><?= $errors['name'] ?></span>
                        <?php endif; ?>

                        <label for="author">Autor:</label> <select name="author"
                            id="author-select">
                            <?php

                            foreach ($autores as $autor) {
                                echo '<option value="' . $autor->id. '" ' . (($autor->id == $frase->autor->id) ? 'selected' : '') . '>' .
                                    $autor->name .
                                    '</option>';
                            }

                            ?>
                        </select>

                        <?php if (!empty($errors['author'])): ?>
                            <span class="error"><?= $errors['author'] ?></span>
                        <?php endif; ?>

                        <label for="topic">Tema:</label> <select name="topic"
                            id="topic">
                            <?php

                            foreach ($temas as $tema) {
                                echo '<option value="' . $tema->name . '" ' . ($tema->name == $frase->tema ? 'selected' : '') . '>' .
                                    $tema->name . '</option>';
                            }

                            ?>
                        </select>
                        <?php if (!empty($errors['topic'])): ?>
                            <span class="error"><?= $errors['topic'] ?></span>
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
                        $fraseId = $frase->id;
                        $fraseTexto  =  $frase->texto;
                        $autorNombre = $frase->autor->name;
                        $temaNombre = $frase->tema ?? "null";

                        echo " <tbody>
                            <tr>
                                <td>$fraseTexto</td>
                                  <td>$autorNombre</td>
                                  <td>$temaNombre</td>
                                <td>";
                        echo '<button class="btn-edit" onclick="location.href=\'?frase/editForm/' . $fraseId . '\'">Editar</button>';
                        echo "   <button class=\"btn-delete\" onclick=\"location.href='?frase/deleteFrase/" . $fraseId . " '\"> Eliminar</button>
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
