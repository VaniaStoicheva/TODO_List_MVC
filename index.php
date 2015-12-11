<?php

session_start();
//ini_set('display_errors', 1);
//include class
$scriptName = explode('/', $_SERVER['SCRIPT_NAME']);
$requestUri = explode('/', $_SERVER['REQUEST_URI']);

spl_autoload_register(function($className) {
    $classPathSplited = explode('\\', $className);

    $vendor = $classPathSplited[0];
    $classPath = str_replace($vendor . '\\', '', $className);

    $classPath = str_replace('\\', '/', $classPath);
//  if (!is_readable($classPath.'.php')) {
//        throw new \Exception();
//    }

    require_once $classPath . '.php';
});

//configs
$configName = getenv('CONFIG_NAME');

/**
 * @var \Todo\Configs\DbConfig $dbConfigClass
 */
$dbConfigClass = '\\Todo\Configs\\' . $configName . '\\DbConfig';

Todo\Db::setInstance(
        $dbConfigClass::USER, $dbConfigClass::PASS, $dbConfigClass::DBNAME, $dbConfigClass::HOST
);

//controllers and actions in url
/**
 * echo '<pre>' . print_r($_SERVER, true) . '</pre>';
 * [REQUEST_URI] => /Todo/index.php
  [SCRIPT_NAME] => /Todo/index.php
  [PHP_SELF] => /Todo/index.php
 */
$customUri = array();
$controllerIndex = 0;
foreach ($scriptName as $key => $value) {
    if ($value == 'index.php') {
        $controllerIndex = $key;
        break;
    }
}

$actionIndex = $controllerIndex + 1;
$controllerName = $requestUri[$controllerIndex];
$actionName = $requestUri[$actionIndex];

$controllerClassName = "\\Todo\\Controllers\\"
        . ucfirst($controllerName)
        . 'Controller';

//view in View.php
$view = new Todo\View($controllerName, $actionName);

//params delete/id/6/pass/12 $request->[id]->6;[pass]->12;
$request = array();
for ($key = $actionIndex + 1; $key < count($requestUri); $key += 2) {
    if (!isset($requestUri[$key + 1])) {
        break;
    }
    $request[$requestUri[$key]] = $requestUri[$key + 1];
}
//echo '<pre>' . print_r($request, true) . '</pre>';
$requestObject = new \Todo\Request($request);


try {
    $controller = new $controllerClassName($view, $requestObject, $controllerName);
} catch (\Exception $e) {
    echo 'no such controller';
}
if (!$actionName) {
    $actionName = "index";
}
if (!method_exists($controller, $actionName)) {
    die('no such action');
}

$controller->$actionName();
$view->render();

