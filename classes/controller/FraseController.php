<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
class FraseController
{

    private $fraseList;
    private $autorModel;
    private $temaModel;
    private $model;
    private $view;
    private $frase;

    public function __construct()
    {
        $this->model = new FraseModel();
        $this->temaModel = new TemaModel();
        $this->autorModel = new AutorModel();
        $this->frase = new Frase();
        $this->view = new FraseView();
    }

    public function show()
    {
        $this->fraseList = $this->model->selectAll();
        self::readXmlFile();
        $this->view->show($this->fraseList);
    }

    public function form($params)
    {
        $this->fraseList = $this->model->selectAll();
        $temas = $this->temaModel->selectAll();
        $autores = $this->autorModel->selectAll();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($params["name"])) {
                $this->frase->errors["name"] = "Campo obligatorio";
            } else {
                $frase = filter_var($params["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("texto", $frase);
            }

            if (empty($params["author"])) {
                $this->frase->errors["author"] = "Campo obligatorio";
            } else {
                $authorid = filter_var($params["author"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $autor = new Autor();
                $autor->__set("id", $authorid);
                $this->frase->__set("autor", $autor);
            }

            if (empty($params["topic"])) {
                $this->frase->errors["topic"] = "Campo obligatorio";
            } else {
                $frase = filter_var($params["topic"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("tema", $frase);
                echo "tema frase -> ok" . "<br>";
            }

            if (empty($this->frase->errors)) {
                $this->model->insert($this->frase);
                header("Location: ?frase/show");
                exit();
            } else {
                echo "Error al insertar";
            }
        }

        // Mando una lista de autores y temas a la ista, para mostrarlos 
        // en los inputs de tipo select.
        $this->view->form($this->fraseList, $this->frase, $temas, $autores);
    }

    public function editForm($params)
    {

        $this->fraseList = $this->model->selectAll();
        $temas = $this->temaModel->selectAll();
        $autores = $this->autorModel->selectAll();

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $fraseId = (int) $params[0];
        }

        foreach ($this->fraseList as $key => $value) {

            // Busco la frase en mi lista que tiene el mismo id, que 
            // el id que me ha llegado por get, para mostrar su informacion
            // en los inputs de la vista
            if ($value) {
                if ($value->id === $fraseId) {
                    $this->frase->__set('id', $value->id);
                    $this->frase->__set('texto', $value->texto);
                    $this->frase->__set('tema', $value->tema);
                    $this->frase->__set('autor', $value->autor);
                } else {
                    // echo "no hay coincidencia";
                }
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $this->frase->__set("id", $params["id"]);

            if (empty($params["name"])) {
                $this->frase->errors["name"] = "Campo obligatorio";
            } else {
                $fraseTexto = filter_var($params["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("texto", $fraseTexto);
                //                 echo "ok";
            }


            if (empty($params["author"])) {
                $this->frase->errors["author"] = "Campo obligatorio";
            } else {
                $author = filter_var($params["author"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $autor = new Autor();
                $autor->__set("id", $params["author"]);
                $this->frase->__set("autor", $autor);
            }


            if (empty($params["topic"])) {
                $this->frase->errors["topic"] = "Campo obligatorio";
            } else {
                $tema = filter_var($params["topic"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("tema", $tema);
            }


            if (empty($this->frase->errors)) {
                $this->model->update($this->frase);
                // echo "ok";
                header("Location: ?frase/show");
                exit();
            } else {
                echo "hay errores";
            }
        }

        // Mando una lista de autores y temas a la ista, para mostrarlos
        // en los inputs de tipo select.
        $this->view->editForm($this->fraseList, $this->frase, $temas, $autores);
    }

    public function deleteFrase($params)
    {
        $id = $params[0];
        $this->model->delete($id);
        header("location: ?frase/show");
    }
    /**
     * Método que se encarga de leer el xml, e insertar la información en la base de datos 
     * @return void
     */
    public function readXmlFile()
    {   
        // Lista de objetos Autor para insertar
        $authorList = [];
        // Lista de los nombres de temas sin repetidos
        $themeNames = []; 
        // Lista de objetos Tema para insertar
        $themeList = []; 

        // Compruebo si el fichero existe 
        if (file_exists('../assets/frases.xml')) {
            $xmlObject =  simplexml_load_file('../assets/frases.xml');

            foreach ($xmlObject as $value) {
                $url = $value->attributes()->url;
                $authorName = $value->nombre;
                $authorDescription = $value->descripcion;
                $authorTotalPhrases = count($value->frases->frase);

                $phraseText = $value->frases->frase->texto;

                /**
                 *  Estaba teniendo problemas de repetidos por no convertir a String los nonbres de temas, 
                 * la función in_array no estaba analizando bien los datos de la lista 
                 */
                $themeName = (string) $value->frases->frase->tema;
                
                /**
                 * Compruebo si el tema existe, para guardar todos los "nombres de temas" en un
                 * array, sin repetidos , luego recorreré este mismo array, y crearé los objetos
                 */
                if (!in_array($themeName, $themeNames)) {
                    $themeNames[] = $themeName;
                }

                // Compruebo si el autor existe en el array 
                if (!in_array($authorName, $authorList)) {
                    $author = new Autor();
                    $author->url = $url;
                    $author->name = $authorName;
                    $author->description = $authorDescription;
                    $author->phrases = $authorTotalPhrases;

                    array_push($authorList, $author);
                } 

            }

            // Aquí recorro el array que no tiene temas repetidos, y creo los objetos
            foreach ($themeNames as $themeName) {
                $theme = new Tema();
                $theme->name = $themeName;
                array_push($themeList, $theme);
            }

            $this->insertXmlInfo($authorList, $themeList);

            // echo "<pre>";
            // var_dump($themeList);
            // echo "</pre>";
            // die;
            
        } else {
            echo "archivo no encontrado";
        }
    }

    public function insertXmlInfo($authorList, $themeList)
    {
        foreach ($authorList as $author) {
            $this->autorModel->insert($author);
        }

        foreach ($themeList as $theme) {
            $this->temaModel->insert($theme);
        }
    }
}
