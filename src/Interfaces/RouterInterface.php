<? namespace RbMowatt\Router\Interfaces;

interface RouterInterface {

    /**
     * Registers a resource controller with the Router
     * 
     * @param string $path
     * @return null
     */
    public static function resource( string $path ) : void;

    /**
     * 
     * @param string $path
     * @return mixed
     */
    public function dispatch(string $path, $body = null);
}
