<?php

namespace DUT\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use DUT\Models\Article;
use DUT\Models\Commentaire;
use DUT\Models\Image;
use DUT\Models\Utilisateurs;


class ArticleController {

    

    public function __construct() {
        
    }

    public function listArticles(Application $app) {
        
        if(!isset($_SESSION['id'])){
            $_SESSION['id']=0;
        }
        
        $entityManager = $app['em'];
        $twig=$app['twig'];
        $repository = $entityManager->getRepository('DUT\\Models\\Article');
        $articles=$repository->findBy(array(),array('id'=>'DESC'));
        $repository= $entityManager->getRepository('DUT\\Models\\Image');
        $images=$repository->findAll();
        $repository= $entityManager->getRepository('DUT\\Models\\Utilisateurs');
        $utilisateur=$repository->find($_SESSION['id']);
        
        
        $html=$twig->render('liste.twig', ['articles' => $articles,'images'=>$images, 'utilisateur'=>$utilisateur,'session'=>$_SESSION['id']]);
        
        return new Response($html);
    }

    public function AfficheArticle($index, Application $app) {
        $entityManager = $app['em'];
        $twig=$app['twig'];
        $repository = $entityManager->getRepository('DUT\\Models\\Article');
        $article=$repository->find($index);
        $repository= $entityManager->getRepository('DUT\\Models\\Utilisateurs');
        $utilisateurs=$repository->findAll();
        $utilisateur=$repository->find($_SESSION['id']);
        $repository= $entityManager->getRepository('DUT\\Models\\Image');
        $image=$repository->findOneBy(array('article'=>$index));
        $repository= $entityManager->getRepository('DUT\\Models\\Commentaire');
        $commenatires=$repository->findAll();
        
        
        $html=$twig->render('Article.twig', ['article' => $article,'image' => $image,'utilisateurs'=>$utilisateurs,'utilisateur'=>$utilisateur,'session'=>$_SESSION['id'],'commentaires'=>$commenatires]);
        
        return new Response($html);
    }
    
    
    
    
    public function createAction(Request $request, Application $app) {
        $entityManager = $app['em'];
        $twig=$app['twig'];
        $directory='images';
        $titre=$request->get('titre', null);
        $file=$request->files->get('image', null);
        $filename=$request->get('nom',null);
        $filename=$filename.'.jpg';   
        $repository = $entityManager->getRepository('DUT\\Models\\Article');
        $articles=$repository->findAll();
        $idnew=1;
            foreach ($articles as $article){
                $idnew=$article->getId();
            }
            $idnew++;
        
        
        if(!is_null($titre) && !is_null($file) && !is_null($filename)){
            
            $move=$file->move($directory,$filename);
            $directory=$directory.'/'.$filename;
            
            $item=new Article($titre);
            $item->setId($idnew);
            $item->setContenu($request->get('editeur'));
            $item->setAuteur(2);
            $entityManager->persist($item);
            
            
            
            
            $newPicture=new Image($filename,$directory,$idnew);
            $entityManager->persist($newPicture);
            $entityManager->flush();
            
            $message = "votre article a bien été crée!  ";
            
        }
        else{
            $message="";
        }
        $html = $twig->render('Create.twig',['message' => $message]);
        return new Response($html);
    }
    
    public function commentAction(Request $request, Application $app) {
        $entityManager = $app['em'];
        $twig=$app['twig'];
        $comment=$request->get('comment', null);
        $id=$request->get('id',null);
        
        $repository = $entityManager->getRepository('DUT\\Models\\Article');
        $article=$repository->find($id);
        $repository = $entityManager->getRepository('DUT\\Models\\Utilisateurs');
        $auteur=$repository->find($_SESSION['id']);
        $url = $app['url_generator']->generate('home');
        if(!is_null($comment) && !is_null($article) && !is_null($auteur)){
            
            $item=new Commentaire($comment,$article->getId(),$auteur->getId());
            
            
            
            $entityManager->persist($item);
            $entityManager->flush();
            
        }
        $repository = $entityManager->getRepository('DUT\\Models\\Article');
        $article=$repository->find($id);
        $repository= $entityManager->getRepository('DUT\\Models\\Utilisateurs');
        $utilisateurs=$repository->findAll();
        $utilisateur=$repository->find($_SESSION['id']);
        $repository= $entityManager->getRepository('DUT\\Models\\Image');
        $image=$repository->findOneBy(array('article'=>$id));
        $repository= $entityManager->getRepository('DUT\\Models\\Commentaire');
        $commenatires=$repository->findAll();

        $html = $twig->render('Article.twig', ['article' => $article,'image' => $image,'utilisateurs'=>$utilisateurs,'utilisateur'=>$utilisateur,'session'=>$_SESSION['id'],'commentaires'=>$commenatires]);
        

        return new Response($html);
    }
    
    
    
    
    
    
    public function searchAction($key, Application $app) {
        $entityManager = $app['em'];
        $twig=$app['twig'];
        $repository = $entityManager->getRepository('DUT\\Models\\Article');
        $articles=$repository->find($key);
        
        
        $html=$twig->render('Article.twig', ['articles' => $articles]);
        
        return new Response($html);
    }
    

    public function deleteArticle($index, Application $app) {
        $entityManager = $app['em'];
        $repository = $entityManager->getRepository('DUT\\Models\\Article');
        $articleToRemove = $entityManager->find('DUT\\Models\\Article', $index);
        $entityManager->remove($articleToRemove);
        $entityManager->flush();
        $repository = $entityManager->getRepository('DUT\\Models\Image');
        $imageToRemove = $repository->findOneBy(array('article'=>$index));
        $entityManager->remove($imageToRemove);
        $entityManager->flush();

        $repository = $entityManager->getRepository('DUT\\Models\Commentaire');
        $commentsToRemove = $repository->findBy(array('id_article'=>$index));
        foreach($commentsToRemove as $comment){
            $commenttoremove=$repository->findOneBy(array('id_article'=>$index));
            $entityManager->remove($commenttoremove);
            $entityManager->flush();
        }

        $url = $app['url_generator']->generate('home');

        return $app->redirect($url);
    }
    
    
    public function deleteComment($index, Application $app) {
        $entityManager = $app['em'];
        $repository = $entityManager->getRepository('DUT\\Models\\Commentaire');
        $commentToRemove = $entityManager->find('DUT\\Models\\Commentaire', $index);
        $entityManager->remove($commentToRemove);
        $entityManager->flush();


        $url = $app['url_generator']->generate('home');

        return $app->redirect($url);
    }
    
    public function modifier($index, Application $app) {
        $entityManager = $app['em'];
        $twig=$app['twig'];
        $repository = $entityManager->getRepository('DUT\\Models\\Article');
        $article= $repository->find($index);
        $repository = $entityManager->getRepository('DUT\\Models\\Utilisateurs');
        $utilisateur= $repository->find($_SESSION['id']);
        $message="";
        

        $html = $twig->render('modif.twig', ['article' => $article,'utilisateur'=>$utilisateur,'session'=>$_SESSION['id'],'message'=>$message]);
        

        return new Response($html);
    }
    
    public function modif(Request $request, Application $app) {
        $entityManager = $app['em'];
        $twig=$app['twig'];
        $newtitle=$request->get("titre",null);
        $newcontenu=$request->get("editeur",null);
        $id=$request->get("id",null);
        
        $repository = $entityManager->getRepository('DUT\\Models\\Article');
        $articletochange= $repository->find($id);
        var_dump($newcontenu);
        if(!is_null($newtitle) && !is_null($newcontenu) && !is_null($articletochange)){
            $articletochange->setTitre($newtitle);
            $articletochange->setContenu($newcontenu);
            $entityManager->persist($articletochange);
            $entityManager->flush();
            $url = $app['url_generator']->generate('home');
            return $app->redirect($url);
        }
        else{
            $message="erreur dans la modification de votre article";
            $repository = $entityManager->getRepository('DUT\\Models\\Article');
            $article= $repository->find($index);
            $repository = $entityManager->getRepository('DUT\\Models\\Utilisateurs');
            $utilisateur= $repository->find($_SESSION['id']);
            $html = $twig->render('modif.twig', ['article' => $article,'utilisateur'=>$utilisateur,'session'=>$_SESSION['id'],'message'=>$message]);
        }
        
        
       
    }
}