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
use DUT\Models\Utilisateurs;




/**
 * Description of UserController
 *
 * @author p1606602
 */
class UserController {
    //put your code here


  public function inscription(Application $app){
 	$twig=$app['twig'];
	$html=$twig->render('inscription.twig');

	return new Response($html);

    }

  public function connexion(Application $app){
  $twig=$app['twig'];
  $html=$twig->render('Connexion.twig');

  return new Response($html);
  }

     public function add(Request $request, Application $app){
        
     	$entityManager = $app['em'];
        $pseudo = $request->get('pseudo', null);
        $mail = $request->get('mail', null);
        $mdp = $request->get('mdp', null);

        $url = $app['url_generator']->generate('home');

        if (!is_null($pseudo)  && !is_null($mail) && !is_null($mdp)) {
       
            $user = new Utilisateurs($mail,$pseudo, sha1($mdp));
            var_dump($user->getMail());
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $app->redirect($url);
     }

    public function conn(Request $request,Application $app){
      $entityManager = $app['em'];
      $url = $app['url_generator']->generate('home');
      $pseudo = $request->get('pseudo', null);
      
      $mdp = $request->get('mdp', null);
      $repository = $entityManager->getRepository('DUT\\Models\\Utilisateurs');
      $user=$repository->findOneBy(array('pseudo'=>$pseudo));
      

      if(isset($user)){
        if($user->getPseudo()==$pseudo && $user->getMdp()== sha1($mdp)){
          $_SESSION['id']=$user->getId();
          
        }
      }
      
      return $app->redirect($url);
    }
    
    public function deconnexion(Application $app){
        
        $_SESSION['id']=null;
        var_dump($_SESSION);
        $url = $app['url_generator']->generate('home');
        return $app->redirect($url);
    }

}
