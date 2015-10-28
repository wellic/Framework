<?php

namespace Blog\Controller;

use Framework\Controller\Controller;
use Framework\Response\ResponseJson;

/**
 * Class TestController
 *
 * @package Blog\Controller
 * @author JuraZubach
 * @since 1.0
 */
class TestController extends Controller
{
    public function redirectAction()
    {
        return $this->redirect('/');
    }

    public function getJsonAction()
    {
        return new ResponseJson(array('body' => 'Hello World'));
    }
} 