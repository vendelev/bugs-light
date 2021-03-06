<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\ORM\Query;
use Cake\Routing\Router;
use Closure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Auth', [
//            'authorize'=> 'Controller',
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'pass'
                    ],
//                    'finder' => 'auth'
                ]
            ],
            'loginAction' => Router::url(['controller' => 'users', 'action' => 'login']),
            // If unauthorized, return them to page they were just on
//            'unauthorizedRedirect' => Router::url(['controller' => 'users', 'action' => 'login'])
        ]);

        $this->Auth->allow([]);

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->set('currentUser', $this->Auth->user());

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    protected function getWithDeletedClosure(): Closure
    {
        return Closure::fromCallable(
            static function (Query $query) {
                return $query->applyOptions(['withDeleted']);
            }
        );
    }

    protected function getRequestAllData(): array
    {
        /** @var array $data */
        $data = $this->request->getData();

        return $data;
    }
}
