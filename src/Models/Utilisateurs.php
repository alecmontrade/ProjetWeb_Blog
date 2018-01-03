<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



namespace DUT\Models;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of Utilisateurs
 *
 * @author p1606602
 */
class Utilisateurs {

    public $id;
    public $mail;
    public $pseudo;
    public $mdp;
    public $commentaires;
    
    
    public function __construct($mail,$pseudo,$mdp) {
        $this->commentaires= new ArrayCollection();
        $this->mail=$mail;
        $this->pseudo=$pseudo;
        $this->mdp=$mdp;
    }

    public function getId() {
        return $this->id;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getPseudo() {
        return $this->pseudo;
    }

    public function getMdp() {
        return $this->mdp;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function setPseudo($pseudo) {
        $this->pseudo = $pseudo;
    }

    public function setMdp($mdp) {
        $this->mdp = $mdp;
    }
    
    public function getCommentaires() {
        return $this->commentaires;
    }

    public function setCommentaires($commentaires) {
        $this->commentaires = $commentaires;
    }



}
