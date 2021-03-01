<?php

namespace App\Controller;

use Cake\Http\Response;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['login']);
    }

    public function login(): ?Response
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }

        return null;
    }

    public function logout(): ?Response
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }
}
