<? namespace RbMowatt\Router;

use Exception;
use RbMowatt\Router\Exceptions\RouterException;
use RbMowatt\Router\Interfaces\RouterInterface;

class Router implements RouterInterface {

    private $_routes;
    private $_bodyData;

    public function __construct(){
        $this->_routes = Routes::getInstance();
    }

    /**
     * Registers a resource controller with the Router
     * 
     * Let's have the Routes Object dice em and store them
     * 
     * @param string $path
     * @return null
     */
    public static function resource( string $path )  : void
    {
        Routes::getInstance()->addRoute(self::toController($path), explode('.', $path));
    }

    /**
     * 
     * @param string $path
     * @return mixed
     */
    public function dispatch(string $path, $body = null) {
        try
        {
            $this->_bodyData = $body ?? file_get_contents('php://input');
            //the total number of sections the url is divided into based on '/' delimiter
            $totalParts = count(array_filter(explode('/', $path)));
            //lets see if we can find a route match 
            if(!$match =  $this->_routes->match(rtrim($path, '/')))
            {
                throw new RouterException('Route Does Not Exist');
            }
            //if we can lets send the result to a method which will apply the result based on request method
            if(class_exists($match['controller']))
            {
                return $this->apply(new $match['controller'](), $match['args'], $totalParts);
            }
            throw new RouterException('class does not exist');
        }
        catch( Exception $e )
        {
            throw new RouterException($e);
        }
    }

    /**
     * @param string $path
     * @return array
     */
    protected function parseBody() : array
    {
        $data = $this->_bodyData ;
        $req = [];
        foreach(explode('&', $data) as $value){
            $data = explode('=', $value);
            $req[$data[0]] = $data[1];
        }
        return $req;
    }

    /**
     * After we have parsed the controller and param data we will sniff the request method to see which method
     * should be called on the controller and call it
     * 
     * @param object $controller
     * @param array $params
     * @param int $totalParts
     * @return mixed
     */
    protected function apply( $controller, array $params, int $totalParts)
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT':
                case 'PATCH':
                    //we'll make the request data the final param here
                    array_push($params, $this->parseBody());
                    return call_user_func_array( array($controller, 'update'), $params);
                case 'POST':
                    //lets parse the body and send it as a param
                    array_push($params, $this->parseBody());
                    return call_user_func_array( array($controller, 'create'), $params);
                case 'GET':
                    //if the url can be split into an even number of sections that means there is an argument for each directive and hence its a get call
                    //otherwise it should be directed to the get method
                    $method = $totalParts % 2 ?  'index' : 'get';
                    return call_user_func_array( array($controller, $method), $params);
                case 'DELETE':
                    return call_user_func_array( array($controller, 'delete'), $params);
                default:
                    throw new RouterException('Invalid Request Method');
            }
        }
        catch( Exception $e){
            return  new RouterException($e->getMessage());
        }
    }
    /**
     * This method will take the dot delimited path and extract the applicable controller name
     * 
     * @param string $path
     * @return string
     */
    protected static function toController( string $path) : string
    {
        $controllerName = implode('',
            array_map(function($part){return ucfirst($part);}, 
                explode('.', $path))
        );
        return $controllerName . 'Controller';
    }


     /**
     * @throws Exception
     */
    protected function pageNotFound()
    {
        throw new RouterException('Page Not Found');
    }
}
