<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace DUT\Models;


/**
 * Description of Item
 *
 * @author p1606602
 */
class Article {
   
    protected $id;
    protected $auteur;
    protected $titre;
    protected $contenu;
    protected $commentaires;
    
    
    
    function __construct($titre) {
        $this->commentaires= new \Doctrine\Common\Collections\ArrayCollection();
        $this->titre=$titre;
    }

    function getId() {
        return $this->id;
    }

    function getAuteur() {
        return $this->auteur;
    }

    function getTitre() {
        return $this->titre;
    }

    function getContenu() {
        return $this->contenu;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setAuteur($auteur) {
        $this->auteur = $auteur;
    }

    function setTitre($titre) {
        $this->titre = $titre;
    }

    function setContenu($contenu) {
        $this->contenu = $contenu;
    }


    
    function getCommentaires() {
        return $this->commentaires;
    }

    function setCommentaires($commentaires) {
        $this->commentaires = $commentaires;
    }




}
