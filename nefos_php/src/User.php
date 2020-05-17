<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author Alcohealism
 */
class user {
    public $id, $username, $name, $surname, $email;
    
    function __construct($username, $name, $surname, $email) {
        $this->username = $username;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
    }
    
    function getUsername() {
        return $this->username;
    }

    function getName() {
        return $this->name;
    }

    function getSurname() {
        return $this->surname;
    }

    function getEmail() {
        return $this->email;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setSurname($surname) {
        $this->surname = $surname;
    }

    function setEmail($email) {
        $this->email = $email;
    }
    
    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }


}
