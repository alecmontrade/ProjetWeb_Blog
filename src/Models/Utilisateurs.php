<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DUT\Models;

/**
 * Description of Utilisateurs
 *
 * @author p1606602
 */
class Utilisateurs {
    protected $id;
    protected $mail;
    protected $pseudo;
    protected $mdp;
    protected $commentaires;
    
    
    function __construct() {
        $this->commentaires= new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getMail() {
        return $this->mail;
    }

    function getPseudo() {
        return $this->pseudo;
    }

    function getMdp() {
        return $this->mdp;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setMail($mail) {
        $this->mail = $mail;
    }

    function setPseudo($pseudo) {
        $this->pseudo = $pseudo;
    }

    function setMdp($mdp) {
        $this->mdp = $mdp;
    }
    
    function getCommentaires() {
        return $this->commentaires;
    }

    function setCommentaires($commentaires) {
        $this->commentaires = $commentaires;
    }



}
