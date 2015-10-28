<?php

namespace CMS\Controller;

use Framework\Controller\Controller;

/**
 * Class ProfileController
 *
 * @package CMS\Controller
 * @author JuraZubach
 * @since 1.0
 */
class ProfileController extends Controller
{
    public function getAction()
    {
        return $this->render('profile.html', array('profile' => 'Profile info'));
    }

    public function updateAction()
    {
        //TODO:Обновить информацию о профиле.

    }
}