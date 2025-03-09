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

        if (!count($this->fraseList)) {
                $this->model->loadDatabase();
                self::readXmlFile();
                $this->fraseList = $this->model->selectAll();
                $this->view->show($this->fraseList);
        } else {
                $this->fraseList = $this->model->selectAll();
                $this->view->show($this->fraseList);
        }
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
            // Guardo el id de la frase que me ha llegado por GET
            $fraseId = (int) $params[0];
        }

        foreach ($this->fraseList as $value) {

            // Busco la frase en mi lista que tiene el mismo id, que 
            // el id que me ha llegado por get, para mostrar su informacion
            // en los inputs de la vista
            if ($value->id === $fraseId) {
                $this->frase->__set('id', $value->id);
                $this->frase->__set('texto', $value->texto);
                $this->frase->__set('tema', $value->tema);
                $this->frase->__set('autor', $value->autor);
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $this->frase->__set("id", $params["id"]);

            if (empty($params["name"])) {
                $this->frase->errors["name"] = "Campo obligatorio";
            } else {
                $fraseTexto = filter_var($params["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("texto", $fraseTexto);
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
     * Método para cargar el script de reinicio de la base de datos, además luego de volver a crear la base de datos
     * llama al método que lee el xml e inserta los datos.
     * @return void
     */
    public function loadDatabase()
    {
        $this->model->loadDatabase();
        self::readXmlFile();
        $this->show();
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
        // Lista de objetos Frase para insertar
        $phrasesList = [];

        // Compruebo si el fichero existe 
        if (file_exists('../assets/frases.xml')) {
            $xmlObject =  simplexml_load_file('../assets/frases.xml');

            // Bucle para recorrer el xml 
            foreach ($xmlObject as $value) {
                // Desestructuro las variables del xml para que sea más legible el código 
                $url = $value->attributes()->url;
                $authorName = $value->nombre;
                $authorDescription = $value->descripcion;
                $authorTotalPhrases = count($value->frases->frase);

                /**
                 *  Estaba teniendo problemas de repetidos por no convertir a String los nonbres de temas, 
                 * la función in_array no estaba analizando bien los datos de la lista 
                 */
                $themeName = (string) $value->frases->frase->tema;

                /**
                 * Compruebo si el tema existe, para guardar todos los "nombres de temas" en un
                 * array, sin repetidos , luego recorreré este mismo array, y crearé los objetos
                 */
                if ($themeName !== "" && !in_array($themeName, $themeNames)) {
                    $themeNames[] = $themeName;
                }

                // Compruebo si el autor existe en el array 
                if (!in_array($authorName, $authorList)) {
                    $author = new Autor();
                    $author->url = $url;

                    $author->name = $authorName;
                    $author->description = $authorDescription;
                    $author->phrases = $authorTotalPhrases;

                    $this->autorModel->insert($author);
                    $author->id = $this->autorModel->getLastInsertId();

                    /**
                     * En cada autor, recorro sus frases, y creo los objetos Frase
                     * para asociar cada frase a un autor
                     */
                    foreach ($value->frases->frase as $p) {
                        $phrase = new Frase();
                        $phrase->texto = (string) $p->texto;
                        $phrase->tema = $value->frases->frase->tema;
                        $phrase->autor = $author;
                        $phrasesList[] = $phrase;
                    }

                    array_push($authorList, $author);
                }
            }

            // Aquí recorro el array que no tiene temas repetidos, y creo los objetos
            foreach ($themeNames as $themeName) {
                $theme = new Tema();
                $theme->name = $themeName;
                $this->temaModel->insert($theme);
                array_push($themeList, $theme);
            }

            foreach ($phrasesList as $phrase) {
                // Guardo las frases en una lista que usaré para insertar en la BD
                $this->model->insert($phrase);
            }
        } else {
            echo "archivo no encontrado";
        }
    }
}
