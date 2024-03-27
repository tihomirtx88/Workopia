<?php
namespace Framework;

class Router
{
    protected $routes = [];

    /**
     * Add new route
     *
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return void
     */
    public function registerRoute($method, $uri, $action){
        // Split the action
        list($controller, $controllerMethod)= explode('@', $action);
        
        //Create routes options 
        $this->routes[] = [
            'method'=> $method,
            'uri' => $uri,
            'controller' => $controller, 
            'controllerMethod' => $controllerMethod
        ];
    }
    /**
     * 
     * Add GET Route
     * 
     * @return string $uri
     * @param string $controller
     * @return void
     */
    public function get($uri, $controller){
      $this->registerRoute('GET', $uri, $controller);
    }

    /**
     * Add POST Route
     * @return string $uri
     * @param string $controller
     * @return void
     */
    public function post($uri, $controller){
        $this->registerRoute('POST', $uri, $controller);
    }

    /**
     * Add PUT Route
     * @return string $uri
     * @param string $controller
     * @return void
     */
    public function put($uri, $controller){
        $this->registerRoute('PUT', $uri, $controller);
    }

     /**
     * Add DELETE Route
     * @return string $uri
     * @param string $controller
     * @return void
     */
    public function delete($uri, $controller){
        $this->registerRoute('DELETE', $uri, $controller);
    }

       /**
     * Load error page
     * @param  int $httpCode
     * @return void
     */
    public function error($httpCode = 404){
       
        html_entity_decode($httpCode);
        require basePath("/views/error/{$httpCode}.php");
        exit;
    }

      /**
     * Route request
     * @return string $uri
     * @param string $method
     * @return void
     */

     public function route($uri, $method){
        foreach($this->routes as $route){
           if($route['uri'] === $uri && $route['method'] === $method){
            //  require basePath('App/' . $route['controller']);
            //Extract controller and controller method
            $controller = 'App\\Controllers\\' . $route['controller'];
            $controllerMethod = $route['controllerMethod'];

            //Instanntiate cotroller and call the method 
            $controllerInstance = new $controller();
            $controllerInstance->$controllerMethod();
             return;

           }
        }
        
        $this->error();
     }
}
