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
        $this->view->show($this->fraseList);

                // echo "<pre>";
                // var_dump($this->fraseList);
                // echo "</pre>";
                // die;
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
                $this->frase->__set("name", $frase);
                //                 echo "ok";
            }


            if (empty($params["author"])) {
                $this->frase->errors["author"] = "Campo obligatorio";
            } else {
                $author = filter_var($params["author"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("author", $author);

                //                 $author = $this->autorModel->selectOneByName($author);
                //                $authorId = $author[0]["id"];

                //                 $this->frase->__set("author_id", $authorId);

                //                 echo "<pre>";
                //                 var_dump($authorId);
                //                 echo "</pre>";
                //                 die;

            }


            if (empty($params["topic"])) {
                $this->frase->errors["topic"] = "Campo obligatorio";
            } else {
                $frase = filter_var($params["topic"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("topic", $frase);
            }


            if (empty($this->frase->errors)) {
                $this->model->insert($this->frase);
                header("Location: ?frase/show");
                exit();
                //                 echo "<pre>";
                //                 var_dump($this->frase);
                //                 echo "</pre>";
                //                 die;

            } else {
                echo "hay errores";
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
            // echo "<pre>";
            // var_dump($params[0]);
            // echo "</pre>";
            // die;    
            // $this->frase->__set("id", $params[0]);
        }

        $fraseInfo = $this->model->selectOne($this->frase->__get("id"));
        // $fraseInfo = $this->model->selectOne(1);

        echo "<pre>";
        var_dump($fraseInfo);
        echo "</pre>";
        die;

        // var_dump($this->model->selectOne(1));

        // echo "<pre>";
        // var_dump($fraseInfo);

        // die;

        //                 echo 
        //         die;
        //         echo "<pre>";
        //         echo $frase_id;
        //         echo "</pre>";
        //         die;



        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($params["name"])) {
                $this->frase->errors["name"] = "Campo obligatorio";
            } else {
                $frase = filter_var($params["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("name", $frase);
                //                 echo "ok";
            }


            if (empty($params["author"])) {
                $this->frase->errors["author"] = "Campo obligatorio";
            } else {
                $author = filter_var($params["author"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("author", $author);

                //                 $author = $this->autorModel->selectOneByName($author);
                //                $authorId = $author[0]["id"];

                //                 $this->frase->__set("author_id", $authorId);

                //                 echo "<pre>";
                //                 var_dump($authorId);
                //                 echo "</pre>";
                //                 die;

            }


            if (empty($params["topic"])) {
                $this->frase->errors["topic"] = "Campo obligatorio";
            } else {
                $frase = filter_var($params["topic"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("topic", $frase);
            }


            if (empty($this->frase->errors)) {
                // $this->model->insert($this->frase);
                // header("Location: ?frase/show");
                // exit();
                //                 echo "<pre>";
                //                 var_dump($this->frase);
                //                 echo "</pre>";
                //                 die;

                echo "no hay errores";
            } else {
                echo "hay errores";
            }
        }

        // Mando una lista de autores y temas a la ista, para mostrarlos
        // en los inputs de tipo select.
        $this->view->editForm($this->fraseList, $this->frase, $temas, $autores, $fraseInfo);
    }
}
