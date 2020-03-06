<?php

/*
Plugin Name: Museum Funds
Description:
Version: 0.1
Author: Grodno Museum
License:
*/

//    define('MUS_FUNDS_PATH', __FILE__);

//    require_once (MUS_FUNDS_PATH.'class-museum-funds-rest.php');

define('MUS_FUNDS_PATH', plugin_dir_path(__FILE__));

require_once ( MUS_FUNDS_PATH.'class-mus-funds-ref.php');


    function mus_add_Role(){
        $server_permition = get_role('subscriber');
        add_role( 'mus_admin', 'Администратор(музей)', $server_permition->capabilities );
        add_role( 'mus_funds', 'Музейные фонды', $server_permition->capabilities );
        add_role( 'mus_movement_object', 'Движение предметов', $server_permition->capabilities );
    }

    function mus_delete_Role(){
        remove_role( 'mus_admin');
        remove_role( 'mus_funds' );
        remove_role( 'mus_movement_object' );
    }

    add_action('init','mus_add_Role');
    register_activation_hook( __FILE__, 'mus_add_Role');
    register_deactivation_hook( __FILE__, 'mus_delete_Role' );
    register_uninstall_hook(__FILE__,'mus_delete_Role');


    /*
     *  Rest API
     */

function mus_getReferences(WP_REST_Request $request){
    $param = (int) isset($request['id']) ? $request['id'] : 0;
    $mus_dbRef = new MusFundsReference();
    return $mus_dbRef->mus_getReferences($param);
}

function mus_getReferencesValues(WP_REST_Request $request){
    $refId = (int) isset($request['ref_id']) ? $request['ref_id'] : 0;
    $refValueId = (int) isset($request['ref_value_id']) ? $request['ref_value_id'] : 0;
    $mus_dbRef = new MusFundsReference();
    return $mus_dbRef->mus_getReferencesValues($refId, $refValueId);
}

function mus_updateReferences(WP_REST_Request $request){

    $param = (int) isset($request['id']) ? $request['id'] : 0;
    $mus_dbRef = new MusFundsReference();

    $value = array(
        'id' =>     $param,
        'ref_name' => $request->get_param('Name'),
        'ref_title' => $request->get_param('Title'),
        'ref_description' => $request->get_param('Description'),
    );

    return $mus_dbRef->mus_updateReferencesValues($value);
}

function mus_updateReferencesValues(WP_REST_Request $request){

    $refId = (int) isset($request['ref_id']) ? $request['ref_id'] : 0;
    $refValueId = (int) isset($request['ref_value_id']) ? $request['ref_value_id'] : 0;
    $mus_dbRef = new MusFundsReference();

    $value = array(
        'ref_id' =>  $refId,
        'ref_value_id' => $refValueId,
        'ref_value' => $request->get_param('Value'),
        'ref_value_order' => $request->get_param('ValueOrder'),
    );


    return $mus_dbRef->mus_updateReferencesValues($value);
}

function mus_getCheckRestPermition(WP_REST_Request $request){
    return is_user_logged_in();
}

add_action( 'rest_api_init', function(){

    /*
     *  1. GET: Get references list.
     *  2. POST: Create new references.
     */

	register_rest_route( 'museum-funds/v1', '/references', array(
		array(
			'methods'  => 'GET',
			'callback' => 'mus_getReferences',
            //'permission_callback' => 'mus_getCheckRestPermition'
		),
		array(
			'methods'  => 'POST',
			'callback' => 'mus_updateReferences',
			'args'     => array(
                'ID' => array(
                    'type'     => 'integer',
                    'required' => false,
                ),
				'Name' => array(
					'type'     => 'string',
					'required' => true,
				),
                'Title' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
                'Description' => array(
                    'type'     => 'string',
                    'required' => false,
                ),
			),
            //'permission_callback' => 'mus_getCheckRestPermition'
			
		)
	) );

    /*
     *  1. GET: Get current references.
     *  2. POST: Modify references.
     */

    register_rest_route( 'museum-funds/v1', '/references/(?P<id>\d+)', array(
        array(
            'methods'  => 'GET',
            'callback' => 'mus_getReferences',
            'permission_callback' => 'mus_getCheckRestPermition'
        ),
        array(
            'methods'  => 'POST',
            'callback' => 'mus_updateReferences',
            'args'     => array(
                'Name' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
                'Title' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
                'Description' => array(
                    'type'     => 'string',
                    'required' => false,
                ),
            ),
            'permission_callback' => 'mus_getCheckRestPermition'
        )
    ) );

    /*
     *  1. GET: Get references values.
     *  2. POST: Create mew value for references.
     */

    register_rest_route( 'museum-funds/v1', '/references/(?P<ref_id>\d+)/values', array(
        array(
            'methods'  => 'GET',
            'callback' => 'mus_getReferencesValues',
        ),
        array(
            'methods'  => 'POST',
            'callback' => 'mus_updateReferencesValues',
            'args'     => array(
                'Value' => array(
                    'type'     => 'string', // значение параметра должно быть строкой
                    'required' => true,     // параметр обязательный
                ),
                'ValueOrder' => array(
                    'type'     => 'integer', // значение параметра должно быть строкой
                    'required' => true,     // параметр обязательный
                ),
            )

        )
    ) );

    register_rest_route( 'museum-funds/v1', '/references/(?P<ref_id>\d+)/values/(?P<ref_value_id>\d+)', array(
        array(
            'methods'  => 'GET',
            'callback' => 'mus_getReferencesValues',
        ),
        array(
            'methods'  => 'POST',
            'callback' => 'mus_updateReferencesValues',
            'args'     => array(
                'Value' => array(
                    'type'     => 'string', // значение параметра должно быть строкой
                    'required' => true,     // параметр обязательный
                ),
                'ValueOrder' => array(
                    'type'     => 'integer', // значение параметра должно быть строкой
                    'required' => true,     // параметр обязательный
                ),
            )

        )
    ) );

} );


   /* add_filter('jwt_auth_cors_allow_headers',
        function(){
           header("Access-Control-Allow-Origin: *");
           header('Access-Control-Allow-Credentials: true');
           header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
           header( 'Access-Control-Allow-Headers : Content-Type, X-Auth-Token, Origin');
    });*/

?>