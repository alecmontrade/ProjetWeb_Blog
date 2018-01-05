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
class Image {
   
    protected $id;
    protected $article;
    protected $nom;
    protected $chemin;
    
    
    
    
    function __construct($nom,$chemin,$article) {
        $this->nom=$nom;
        $this->chemin=$chemin;
        $this->article=$article;
    }

    function getId() {
        return $this->id;
    }

    function getArticle() {
        return $this->article;
    }

    function getNom() {
        return $this->nom;
    }

    function getChemin() {
        return $this->chemin;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setArticle($article) {
        $this->article = $article;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setChemin($chemin) {
        $this->chemin = $chemin;
    }




}