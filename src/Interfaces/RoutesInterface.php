<? namespace RbMowatt\Router\Interfaces;

interface RoutesInterface {

    public function addRoute( string $controller, string $route) : void;
    
    public function getRoutes() : array;

    public function match( string $path) : ?array;

}
