<?php

class PatientsController { 
    
    public function index(){
        $result = [
            'method' => 'index',
            'class'=>get_class($this),
        ];
        return  json_encode($result);

    }
    public function get($patientId ){
        $result = [
            'method' => 'get',
            'class'=>get_class($this),
            'data'=> ['patient_id'=>$patientId]
        ];
        return json_encode($result);
    }

    public function update($patientId, $request){
        $result = [
            'method' => 'update',
            'class'=>get_class($this),
            'data'=> ['patient_id'=>$patientId, 'body'=>$request]
        ];
       return  json_encode($result);
    }
    public function create($request){
        $result = [
            'method' => 'create',
            'class'=>get_class($this),
            'data'=> ['body'=>$request]
        ];
       return  json_encode($result);
    }
    public function delete($patientId){
        $result = [
            'method' => 'delete',
            'class'=>get_class($this),
            'data'=> ['patient_id'=>$patientId]
        ];
        return  json_encode($result);
    }
}

class PatientsMetricsController { 
    
    public function index($patientId){
        $result = [
            'method' => 'index',
            'class'=>get_class($this),
            'data'=> ['patient_id'=>$patientId]
        ];
        return  json_encode($result);
    }
    public function get($patientId, $metricId){
        $result = [
            'method' => 'get',
            'class'=>get_class($this),
            'data'=> ['patient_id'=>$patientId, 'metric_id'=>$metricId]
        ];
        return json_encode($result);
    } 
    public function update($patientId, $metricId, $request){
        $result = [
            'method' => 'update',
            'class'=>get_class($this),
            'data'=> ['patient_id'=>$patientId, 'metric_id'=>$metricId, 'body'=>$request]
        ];
        return  json_encode($result);

    }
    public function create($patientId, $request){
        $result = [
            'method' => 'create',
            'class'=>get_class($this),
            'data'=> ['patient_id'=>$patientId,'body'=>$request]
        ];
        return  json_encode($result);
    }

    public function delete($patientId, $metricId){
        $result = [
            'method' => 'delete',
            'class'=>get_class($this),
            'data'=> ['patient_id'=>$patientId, 'metric_id'=>$metricId]
        ];
        return  json_encode($result);
    }
}
