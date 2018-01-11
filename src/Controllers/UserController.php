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
        $twig = $app['twig'];
        $erreur="Vous n'avez pas rempli les champs";
        $erreur1="Le pseudo existe dÃ©jÃ ";
        $erreur2="Les mots de passe ne correspondent pas";
        $pseudo = $request->get('pseudo', null);
        $mail = $request->get('mail', null);
        $mdp = $request->get('mdp', null);
        $mdp1 = $request->get('mdp1', null);
        $repository = $entityManager->getRepository('DUT\\Models\\Utilisateurs');
        $userExists=$repository->findOneBy(array('pseudo'=>$pseudo));
        $url = $app['url_generator']->generate('home');
        if(!is_null($userExists)){
                      $html1=$twig->render('inscription.twig', ['erreur1' => $erreur1]);
                  return new Response($html1);
                    }
        elseif (empty($pseudo)  || empty($mail) || empty($mdp) || empty($mdp1)) {
           $html=$twig->render('inscription.twig', ['erreur' => $erreur]);
          return new Response($html);
        }
        elseif($mdp1!=$mdp){
              $html2=$twig->render('inscription.twig', ['erreur2' => $erreur2]);
          return new Response($html2);
        }else{
           
            $user = new Utilisateurs($mail,$pseudo, sha1($mdp));
            $entityManager->persist($user);
            $entityManager->flush();
            return $app->redirect($url);
      }
     }


    public function conn(Request $request,Application $app){
      $entityManager = $app['em'];
      $twig = $app['twig'];
      $erreur="Le Mot de passe ou le pseudo est incorrect !";
      $erreur1="Vous n'avez pas rempli tout les champs";
      $url = $app['url_generator']->generate('home');
      $pseudo = $request->get('pseudo', null);
      $mdp = $request->get('mdp', null);
      $repository = $entityManager->getRepository('DUT\\Models\\Utilisateurs');

      if(empty($pseudo) || empty($mdp)){
          $html1=$twig->render('Connexion.twig', ['erreur1'=>$erreur1]);
          return new Response($html1);
          }
      
      $user=$repository->findOneBy(array('pseudo'=>$pseudo));
      if(isset($user)){
        if($user->getPseudo()==$pseudo && $user->getMdp()== sha1($mdp)){
          $_SESSION['id']=$user->getId();
        }
        else{
          $html=$twig->render('Connexion.twig', ['erreur' => $erreur]);
          return new Response($html);
        }
      }
    
      return $app->redirect($url);
    }

    
    public function deconnexion(Application $app){
        
        $_SESSION['id']=0;
        var_dump($_SESSION);
        $url = $app['url_generator']->generate('home');
        return $app->redirect($url);
    }

}
