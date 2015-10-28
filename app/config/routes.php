<?php

return array(
    'home'           => array(
        'pattern'    => '/',
        'controller' => 'Blog\\Controller\\PostController',
        'action'     => 'index'
    ),
    'testredirect'   => array(
        'pattern'    => '/test_redirect',
        'controller' => 'Blog\\Controller\\TestController',
        'action'     => 'redirect',
    ),
    'test_json' => array(
        'pattern'    => '/test_json',
        'controller' => 'Blog\\Controller\\TestController',
        'action'     => 'getJson',
    ),
    'signin'         => array(
        'pattern'    => '/signin',
        'controller' => 'Blog\\Controller\\SecurityController',
        'action'     => 'signin'
    ),
    'login'          => array(
        'pattern'    => '/login',
        'controller' => 'Blog\\Controller\\SecurityController',
        'action'     => 'login'
    ),
    'logout'         => array(
        'pattern'    => '/logout',
        'controller' => 'Blog\\Controller\\SecurityController',
        'action'     => 'logout'
    ),
    'profile'        => array(
        'pattern'    => '/profile',
        'controller' => 'CMS\\Controller\\ProfileController',
        'action'     => 'get'
    ),
    'update_profile' => array(
        'pattern'       => '/profile',
        'controller'    => 'CMS\\Controller\\ProfileController',
        'action'        => 'update',
        '_requirements' => array(
            '_method' => 'POST'
        )
    ),
    'add_post'       => array(
        'pattern'    => '/posts/add',
        'controller' => 'Blog\\Controller\\PostController',
        'action'     => 'add',
        'security'   => array('ROLE_USER'),
    ),
    'show_post'      => array(
        'pattern'       => '/posts/{id}',
        'controller'    => 'Blog\\Controller\\PostController',
        'action'        => 'show',
        '_requirements' => array(
            'id' => '\d+'
        )
    ),
    'edit_post'      => array(
        'pattern'       => '/posts/{id}/edit',
        'controller'    => 'CMS\\Controller\\BlogController',
        'action'        => 'edit',
        'security'   => array('ROLE_USER'),
        '_requirements' => array(
            'id'      => '\d+',
            '_method' => 'POST'
        )
    ),
    'delete_post'      => array(
        'pattern'       => '/posts/{id}/delete',
        'controller'    => 'CMS\\Controller\\BlogController',
        'action'        => 'delete',
        'security'   => array('ROLE_USER'),
        '_requirements' => array(
            'id'      => '\d+',
        )
    )
);