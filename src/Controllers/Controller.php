<?php 

namespace App\Controllers;


abstract class Controller
{
    protected function render(string $fichier, array $donnees = [])
    {
        extract($donnees);

        require_once ROOT . "/src/Views/" . $fichier . ".php";
    }

    public function error404()
    {
        $this->render("error/404");
    }
}