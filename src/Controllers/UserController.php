<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DUT\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use DUT\Models\Article;


/**
 * Description of UserController
 *
 * @author p1606602
 */
class UserController {
    //put your code here

      public function __construct() {
        
    }

    public function inscription(Application $app){
 	$twig=$app['twig'];
	$html=$twig->render('inscription.twig');

	return new Response($html);
    }

     public function add(Application $app){

     	
     }

}
