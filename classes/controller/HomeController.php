<?php

class HomeController{

    public function __construct(){}

    public function show($params = null){
        
        $vHome = new HomeView();
        $vHome->show();
        
    }
}

