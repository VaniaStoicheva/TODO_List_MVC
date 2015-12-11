<?php

namespace Todo\Models;
use Todo\Repositories\UserRepository;
class User{
    private $id;
    private $username;
    private $password;
    
    public function __construct($username,$password,$id=null) {
        $this->setId($id);
        $this->setPassword($password);
        $this->setUsername($username);
    }
    /**
     * 
     * @return type
     */
    function getId() {
        return $this->id;
    }
/**
 * 
 * @return type
 */
    function getUsername() {
        return $this->username;
    }
/**
 * 
 * @return type
 */
    function getPassword() {
        return $this->password;
    }
/**
 * 
 * @param type $id
 */
    function setId($id) {
        $this->id = $id;
    }
/**
 * 
 * @param type $username
 */
    function setUsername($username) {
        $this->username = $username;
    }
/**
 * 
 * @param type $password
 */
    function setPassword($password) {
        $this->password = md5($password);
    }

    function save(){
        return \Todo\Repositories\UserRepository::create()->save($this);
    }
}
