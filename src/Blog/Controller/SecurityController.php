<?php

namespace Blog\Controller;

use Framework\Controller\Controller;
use Framework\DI\Service;
use Framework\Exception\DatabaseException;
use Framework\Response\ResponseRedirect;
use Blog\Model\User;

/**
 * Class SecurityController
 *
 * @package Blog\Controller
 * @author JuraZubach
 * @since 1.0
 */
class SecurityController extends Controller
{
    public function loginAction()
    {
        if (Service::get('security')->isAuthenticated()) {
            $redirect = new ResponseRedirect($this->generateRoute('home'));
            $redirect->send();
        }
        $errors = array();

        if ($this->getRequest()->isPost()) {

            if ($user = User::findByEmail($this->getRequest()->post('email'))) {
                if ($user->password == md5($this->getRequest()->post('password'))) {
                    Service::get('security')->setUser($user);
                    if($user->name == 'Guest')
                    {
                        $returnUrl = Service::get('session')->returnUrl;
                        unset(Service::get('session')->returnUrl);
                        return $this->redirect(!is_null($returnUrl) ? $returnUrl : $this->generateRoute('home'), 'info',
                            'You are login in as '.$user->name.'. You can only view the posts!');
                    }
                    $returnUrl = Service::get('session')->returnUrl;
                    unset(Service::get('session')->returnUrl);
                    return $this->redirect(!is_null($returnUrl) ? $returnUrl : $this->generateRoute('home'), 'info',
                        'You are login in as '.$user->name.'. You can view, add, edit and delete the posts!');
                }
            }

            array_push($errors, 'Invalid username or password');
        }

        return $this->render('login.html', array('errors' => $errors));
    }

    public function logoutAction()
    {
        Service::get('security')->clear();
        return $this->redirect($this->generateRoute('home'));
    }

    public function signinAction()
    {
        if (Service::get('security')->isAuthenticated()) {
            $redirect = new ResponseRedirect($this->generateRoute('home'));
            $redirect->send();
        }
        $errors = array();

        if ($this->getRequest()->isPost()) {
            try{
                $user           = new User();
                $user->email    = $this->getRequest()->post('email');
                $user->password = md5($this->getRequest()->post('password'));
                $user->role     = 'ROLE_USER';
                $user->save();
                return $this->redirect($this->generateRoute('home'));
            } catch(DatabaseException $e){
                $errors = array($e->getMessage());
            }
        }

        return $this->render('signin.html', array('errors' => $errors));
    }
}