<?php

    define('MUS_FUNDS_PATH', plugin_dir_path(__FILE__));

    require_once ( MUS_FUNDS_PATH.'class-mus-funds-ref.php');

   

    class MuseumFundsRest extends WP_REST_Controller {

     public $namespace;		

     function __construct(){
        $this->namespace = 'museum-funds/v1';
    }

    function mus_getReferences($request){
        $param = (int) isset($request['id']) ? $request['id'] : 0;
        $mus_dbRef = new MusFundsReference();
        return json_encode($mus_dbRef->mus_getReferences($param));
    }

    function mus_getReferencesValues($request){
        $param = (int) isset($request['id']) ? $request['id'] : 0;
        $mus_dbRef = new MusFundsReference();
        return json_encode($mus_dbRef->mus_getReferencesValues($param));
    }

    function mus_updateReferences($request){
        return 'cdcdcdcdc';
    }

    function mus_getCheckRestPermition($request){
        return is_user_logged_in();
    }

    function mus_getListEndpoints(){
        $listEndpoints = array(
            'get_references'=>array(
                'endpoint' => 'references',
                'rest' => array(
                   array(
                    'method'  => 'POST',
                    'callback' => [$this,'mus_getReferences'],
                   // 'permission_callback' => [$this,'mus_getCheckRestPermition']
                   ),
                    array(
                        'method'  => 'POST',
                        'callback' => [$this,'mus_updateReferences'],
                        //'permission_callback' => [$this,'mus_getCheckRestPermition']
                    ),
                )
            ),

            'get_reference'=>array(
                'endpoint' => '/references/(?P<id>\d+)',
                'rest' => array(
                   array(
                    'method'  => 'GET',
                    'callback' => [$this,'mus_getReferences'],
                    //'permission_callback' => [$this,'mus_getCheckRestPermition']
                   ),
                    array(
                        'method'  => 'POST',
                        'callback' => [$this,'mus_updateReferences'],
                        //'permission_callback' => [$this,'mus_getCheckRestPermition']
                    ),
                )
            ),

            'add_references'=>array(
                'endpoint' => '/references/add',
                'rest' => array(

                    array(
                        'method'  => 'POST',
                        'callback' => [$this,'mus_updateReferences'],
                        //'permission_callback' => [$this,'mus_getCheckRestPermition']
                    ),
                )
            ),

            'get_reference_value'=>array(
                'endpoint' => '/references/value/(?P<id>\d+)',
                'rest' => array(
                    array(
                        'method'  => 'GET',
                        'callback' => [$this,'mus_getReferencesValues'],
                        //'permission_callback' => [$this,'mus_getCheckRestPermition']
                    )
                )
            ),
        );

        return $listEndpoints;
    }

    function mus_register_routes($listEndpoints){

        foreach($listEndpoints as $endPoint){
            register_rest_route($this->namespace, $endPoint['endpoint'], $endPoint['rest'] );
        }

    }

}

