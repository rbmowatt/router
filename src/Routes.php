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
/**
 * Add A New Controller=>regex pair to the local routes array
 * 
 * @param string $controller
 * @param array $params
 */
  public function addRoute( string $controller, array $params) : void {
      $this->routes[$controller] = self::createRegex($params) ;
  }
  /**
   * Get The stored local routes
   */
  public function getRoutes() : array
  {
      return $this->routes;
  }

  /**
   * This matches the given route against the stored reg ex
   * 
   * @param string $path
   * @return mixed array | null
   */
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

    /**
     * We want to create a regex for each controller/path that will match either [/entity] or [/entity/value]
     * We wil also keep every set of regex under a key mapping the applicable controller
     * 
     * @param array $params
     * @return string
     */
    protected static function createRegex(array $pathEntities) : string
    {
        if(count($pathEntities) === 1 ){ //this is not a nested route so lets make this easy
            $template = "~^(?:/param | /param/(\d+))$~x";
            return str_replace('param', $pathEntities[0], $template);
        }
        //else this is a nested route so we have to loop through our parts and build a more etailed regex
        $argsMatch = '';
        foreach($pathEntities as $entity){
            $argsMatch .= "/$entity/(\d+)";
        }
        $exactMatch = rtrim($argsMatch, '/(\d+)');
        return "~^(?:$exactMatch | $argsMatch )$~x";
    }
}