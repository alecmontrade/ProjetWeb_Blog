<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DUT\Models;

/**
 * Description of Commentaire
 *
 * @author p1606602
 */
class Commentaire {
    protected $id;
    protected $id_utilisateur;
    protected $id_article;
    protected $contenu;
    
    function __construct($contenu,$article,$auteur) {
        $this->id_article=$article;
        $this->id_utilisateur=$auteur;
        $this->contenu=$contenu;
    }

    function getId() {
        return $this->id;
    }

    function getIdAuteur() {
        return $this->id_utilisateur;
    }

    function getIdArticle() {
        return $this->id_article;
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

    function setArticle($article) {
        $this->article = $article;
    }

    function setContenu($contenu) {
        $this->contenu = $contenu;
    }


}
