<?php

namespace Todo\Models;

use Todo\Models\User;

class Todo {

    private $id;

    /**
     *
     * @var  User
     */
    private $user;
    private $todo_item;

    public function __construct($id, User $user, $todo_item) {
        $this->setId($id);
        $this->setUser($user);
        $this->setTodo_item($todo_item);
    }

    function getId() {
        return $this->id;
    }

    function getUser() {
        return $this->user;
    }

    function getTodo_item() {
        return $this->todo_item;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUser(User $user) {
        $this->user = $user;
    }

    function setTodo_item($todo_item) {
        $this->todo_item = $todo_item;
    }

    
    function save() {
        return \Todo\Repositories\TodoRepository::create()->add($this);
    }

}
