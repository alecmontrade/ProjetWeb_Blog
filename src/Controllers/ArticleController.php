<?php

namespace DUT\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use DUT\Models\Article;



class ArticleController {

    

    public function __construct() {
        
    }

    public function listArticles(Application $app) {
        $entityManager = $app['em'];
        $twig=$app['twig'];
        $repository = $entityManager->getRepository('DUT\\Models\\Article');
        $articles=$repository->findAll();
        $html=$twig->render('liste.twig', ['articles' => $articles]);
        
        return new Response($html);
    }

    public function AfficheArticle($index, Application $app) {
        $entityManager = $app['em'];
        $twig=$app['twig'];
        $repository = $entityManager->getRepository('DUT\\Models\\Article');
        $article=$repository->find($index);
        //var_dump($article);
        
        $html=$twig->render('Article.twig', ['article' => $article]);
        
        return new Response($html);
    }
    
    
    
    
    public function createAction(Request $request, Application $app) {
        $entityManager = $app['em'];
        $twig=$app['twig'];
        $titre=$request->get('titre', null);
        
        $url = $app['url_generator']->generate('home');
        if(!is_null($titre)){
            $item=new Article($titre);
            $item->setContenu($request->get('editeur'));
            $item->setAuteur(2);
            $entityManager->persist($item);
            $entityManager->flush();
        }
        

        $html = $twig->render('Create.twig');
        

        return new Response($html);
    }
    
    
    public function searchAction($key, Application $app) {
        $entityManager = $app['em'];
        $twig=$app['twig'];
        $repository = $entityManager->getRepository('DUT\\Models\\Article');
        $articles=$repository->find($key);
        //var_dump($article);
        
        $html=$twig->render('Article.twig', ['articles' => $articles]);
        
        return new Response($html);
    }
    

    public function deleteAction($index, Application $app) {
        $entityManager = $app['em'];
        $repository = $entityManager->getRepository('DUT\\Models\\Item');
        $titleToRemove = $entityManager->find('DUT\\Models\\Item', $index);
        $entityManager->remove($titleToRemove);
        $entityManager->flush();


        $url = $app['url_generator']->generate('home');

        return $app->redirect($url);
    }
    
    public function checkAction($index, Application $app) {
        $entityManager = $app['em'];
        $repository = $entityManager->getRepository('DUT\\Models\\Item');
        $item = $entityManager->find('DUT\\Models\\Item', $index); // 
        if($item->getChecked()==0){
            $item->setChecked(1);
        }
        else {$item->setChecked(0);}
        
        $entityManager->persist($item); // On sauvegarde la modification
        $entityManager->flush();



        $url = $app['url_generator']->generate('home');

        return $app->redirect($url);
    }
}
