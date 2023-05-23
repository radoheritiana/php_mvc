<?php 

namespace App\Controllers;

use App\Controllers\Controller;

class MainController extends Controller
{
    /**
     * display index page
     *
     * @return void
     */
    public function index(): void
    {
        $this->render("main/index");
    }
    
}