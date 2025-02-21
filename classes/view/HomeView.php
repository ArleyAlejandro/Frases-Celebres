<?php

class HomeView {
    
    public function __construct() {}
    
    public function show() {
        ?>
        
      <table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Autor</th>
            <th>Descripción</th>
            <th>Frase</th>
            <th>Tema</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Abécassis, Armand</td>
            <td>Profesor francés.</td>
            <td>El ser humano tiene un pie en la tierra y un pie en el más allá...</td>
            <td>Esperanza</td>
            <td>
                <button>Editar</button>
                <button >Eliminar</button>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>Achard, Marcel</td>
            <td>Dramaturgo y guionista francés.</td>
            <td>Para ser feliz en el amor uno debe saber, sin cegarse...</td>
            <td>Amor</td>
            <td>
                <button>Editar</button>
                <button>Eliminar</button>
            </td>
        </tr>
    </tbody>
</table>

<button>Recargar</button>
<button>Autores</button>
<button>Temas</button>
<button>Frases</button>
        <?php        
    }
}        
        ?>
