<?php

namespace Todo\Controllers;

use Todo\Repositories\UserRepository;
use Todo\Repositories\TodoRepository;

class TodosController extends Controller {

    protected $currentUser = false;
    protected $currentTodos = null;

    public function index() {
        
    }

    public function onLoad() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('users', 'login');
        }
        if ($this->currentUser == FALSE) {
            $this->currentUser = \Todo\Repositories\UserRepository::create()
                    ->getOneById($_SESSION['user_id']);
        }
        if ($this->currentTodos == null) {
            $this->currentTodos = \Todo\Repositories\TodoRepository::create()
                    ->getTodoItem($_SESSION['user_id']);
        }

        $this->view->items = $this->currentTodos;
        $this->view->username = $this->currentUser->getUsername();
        $this->view->partial('authHeader');
    }

    public function add() {
        $this->view->error = false;
        if (isset($_POST['add'])) {
            $user_id = $_SESSION['user_id'];
            $todo_item = $_POST['todo_item'];
            if ($todo_item == '') {
                $this->view->error = "Add item is failed!Tray again!";
                return;
            }
            $todo = \Todo\Repositories\TodoRepository::create()->add($user_id, $todo_item);
            $this->redirect('todos');
        }
    }

    public function delete() {
        $this->view->error = false;
        $hasTodoId = false;
        
        foreach ($this->currentTodos as $item) {
            if ($item['id'] == $this->request->getParams()) {
                $hasTodoId = true;
                break;
            }
        }
        
        $todo_id = $this->request->getParams();
        $user_id = $_SESSION['user_id'];
        $deletedTodos = \Todo\Repositories\TodoRepository::create()
                ->deleteTodoItem($todo_id['id'], $user_id);
        if (!$deletedTodos) {
            $this->view->error = "Deleted item is failed!";
        }
        $this->redirect('todos');
    }

}
