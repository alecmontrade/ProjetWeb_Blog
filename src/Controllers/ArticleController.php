<?php

namespace DUT\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use DUT\Models\Item;
use DUT\Services\SessionStorage;


class ArticleController {

    protected $storage;

    public function __construct() {
        $this->storage = new SessionStorage();
    }

    public function listAction(Application $app) {
        $entityManager = $app['em'];
        $twig=$app['twig'];
        $repository = $entityManager->getRepository('DUT\\Models\\Item');
        $items=$repository->findAll();
        $html=$twig->render('liste.twig', ['items' => $items]);
        
        return new Response($html);
    }

    public function createAction(Request $request, Application $app) {
        $entityManager = $app['em'];
        $repository = $entityManager->getRepository('DUT\\Models\\Item');
        $newrow = new Item($request->get('title'));
        $url = $app['url_generator']->generate('home');

        if (!is_null($request->get('title'))) {
            $entityManager->persist($newrow); 
            $entityManager->flush();

            return $app->redirect($url);
        }

        $html = '<h2>Ajouter</h2><form action="create" method="post">';
        $html .= '<label for="input">Nom</label><input id="input" type="text" name="title">';
        $html .= '<button>Valider</button></form>';

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
