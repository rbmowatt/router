<?php

require_once('./example/controllers.php');

use RbMowatt\Router\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    const PATIENTS_CONTROLLER = 'PatientsController';
    const PATIENTS_METRICS_CONTROLLER = 'PatientsMetricsController';

    public function setUp(){ 
        Router::resource('patients');
        Router::resource('patients.metrics');
    }

    public function testIndex()
    {
        $router = new Router;
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $response = json_decode($router->dispatch('/patients'));
        
        $this->assertTrue($response->method === 'index');
        $this->assertTrue($response->class === self::PATIENTS_CONTROLLER );
    }

    public function testGet()
    {
        $router = new Router;
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $response = json_decode($router->dispatch('/patients/1'));
        
        $this->assertTrue($response->method === 'get');
        $this->assertTrue($response->class === self::PATIENTS_CONTROLLER );
        $this->assertTrue($response->data->patient_id == 1);
    }


    public function testUpdate()
    {
        $router = new Router();
        $_SERVER['REQUEST_METHOD'] = 'PATCH';
        $response = json_decode($router->dispatch('/patients/1', 'key_1=val_1&key_2=val_2'));
        
        $this->assertTrue($response->method === 'update');
        $this->assertTrue($response->class === self::PATIENTS_CONTROLLER );
        $this->assertTrue($response->data->patient_id == 1);
        $this->assertTrue($response->data->body->key_1 === 'val_1');
        $this->assertTrue($response->data->body->key_2 === 'val_2');
    }

    public function testCreate()
    {
        $router = new Router();
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $response = json_decode($router->dispatch('/patients', 'key_1=val_1&key_2=val_2'));

        $this->assertTrue($response->method === 'create');
        $this->assertTrue($response->class === self::PATIENTS_CONTROLLER );
        $this->assertTrue($response->data->body->key_1 === 'val_1');
        $this->assertTrue($response->data->body->key_2 === 'val_2');
    }

    public function testNestedIndex()
    {
        $router = new Router;
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $response = json_decode($router->dispatch('/patients/1/metrics'));
        
        $this->assertTrue($response->method === 'index');
        $this->assertTrue($response->class === self::PATIENTS_METRICS_CONTROLLER );
        $this->assertTrue($response->data->patient_id == 1);
        $this->assertTrue($response->data->metric_id == null);
    }

    public function testNestedGet()
    {
        $router = new Router;
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $response = json_decode($router->dispatch('/patients/1/metrics/2'));
        
        $this->assertTrue($response->method === 'get');
        $this->assertTrue($response->class === self::PATIENTS_METRICS_CONTROLLER );
        $this->assertTrue($response->data->patient_id == 1);
        $this->assertTrue($response->data->metric_id == 2);
    }

    public function testNestedUpdate()
    {
        $router = new Router;
        $_SERVER['REQUEST_METHOD'] = 'PATCH';
        $response = json_decode($router->dispatch('/patients/1/metrics/2', 'key_1=val_1&key_2=val_2'));
        
        $this->assertTrue($response->method === 'update');
        $this->assertTrue($response->class === self::PATIENTS_METRICS_CONTROLLER );
        $this->assertTrue($response->data->patient_id == 1);
        $this->assertTrue($response->data->metric_id == 2);
        $this->assertTrue($response->data->body->key_1 === 'val_1');
        $this->assertTrue($response->data->body->key_2 === 'val_2');
    }

    public function testNestedCreate()
    {
        $router = new Router;
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $response = json_decode($router->dispatch('/patients/1/metrics', 'key_1=val_1&key_2=val_2'));
        
        $this->assertTrue($response->method === 'create');
        $this->assertTrue($response->class === self::PATIENTS_METRICS_CONTROLLER );
        $this->assertTrue($response->data->patient_id == 1);
        $this->assertTrue($response->data->body->key_1 === 'val_1');
        $this->assertTrue($response->data->body->key_2 === 'val_2');
    }
}
?>