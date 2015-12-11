<?php

namespace Todo\Controllers;

class Controller {

    /**
     *
     * @var \Todo\View
     */
    protected $view;
    protected $controllerName;
    /**
     *
     * @var \Todo\Request;
     */
    protected $request;
    
    protected function index(){
        $this->view->url('home');
    }

    protected function onLoad() {
        
    }

    public function __construct(
            \Todo\View $view, 
            \Todo\Request $request, 
            $controllerName) {
        $this->view = $view;
        $this->request=$request;
        $this->controllerName = $controllerName;
        $this->onLoad();
    }

    public function redirect($controller = null, $action = null, $params = array()) {
        $requestUri = explode('/', $_SERVER['REQUEST_URI']);
        $url = "//" . $_SERVER['HTTP_HOST'] . "/";
        foreach ($requestUri as $key => $uri) {
            if ($uri == $this->controllerName) {
                break;
            }
            $url.="$uri";
        }
        if ($controller) {
            $url.="/$controller";
        }
        if ($action) {
            $url.="/$action";
        }
        foreach ($params as $key => $param) {
            $url.="/$key/$params";
        }
        header('Location:' . $url);
        exit;
    }

}
