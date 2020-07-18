<?
namespace RbMowatt\Router;
use RbMowatt\Router\Interfaces\RoutesInterface;

class Routes implements RoutesInterface {

  private $routes = [];

  private static $instance = null;
     
  public static function getInstance() : Routes
  {
    if (self::$instance == null)
    {
      self::$instance = new Routes();
    }
    return self::$instance;
  }

  public function addRoute( string $controller, string $route) : void {
      $this->routes[$controller] = $route;
  }

  public function getRoutes() : array
  {
      return $this->routes;
  }

  public function match( string $path) : ?array
  {
      foreach($this->routes as $controller=>$regex)
      {
          preg_match($regex, $path, $matches);
          if(count($matches)){
              array_shift($matches);//this is the exact match, now the argments we need so axe it
              return ['controller'=>$controller, 'args'=>array_filter($matches)];
          }
      }
      return null;
  }
}