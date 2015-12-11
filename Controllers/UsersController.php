<?php

namespace Todo\Controllers;
use Todo\Models\User;
use Todo\Repositories\UserRepository;

class UsersController extends Controller{
    public function login(){
        $this->view->error=false;
        $this->view->users=false;
        if(isset($_POST['login'])){
            $username=$_POST['username'];
            $pass=$_POST['pass'];
          
            $user=UserRepository::create()->getOneByDetails($username, $pass);
            
            if(!$user){
            $this->view->error="Invalid details";
            return;
        }
            $_SESSION['user_id']=$user->getId();
            $this->view->users=$user->getUsername();
            $this->redirect('todos');
        }
    }
    public function register(){
        $this->view->error=false;
         $this->view->users=false;
        if(isset($_POST['register'])){
            $username=$_POST['username'];
            $password=$_POST['pass'];
            if($username==null || strlen($username)<3){
                $this->view->error="Username is invalid";
                return;
            }
            $duplicateUser=  UserRepository::create()->getOneByDetails($username, $password);
            
            if($duplicateUser){
                $this->view->error="Duplicate user";
                return;
               }
               else{
                  $user=new User($username, $password);
                  $user->save();
                
               }
               $_SESSION['user_id']=$user->getId();
            $this->view->users=$user->getUsername();
            $this->redirect('users','login');
        }
    }
    public function logout(){
        session_destroy();
        $this->redirect('users','login');
    }
}

