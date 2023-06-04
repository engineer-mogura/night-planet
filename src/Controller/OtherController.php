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

use Cake\Event\Event;

/**
 * その他の静的ページ
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class OtherController extends AppController
{

    public function beforeFilter(Event $event)
    {
        $this->viewBuilder()->layout('simpleDefault');
        parent::beforeRender($event); //親クラスのbeforeRendorを呼ぶ
        parent::beforeFilter($event);
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    // public function index()
    // {
    //     $this->layout = false;
    //     $this->render();
    // }
    /**
     * Undocumented function
     *
     * @return void
     */
    // public function detail()
    // {
    //     $this->layout = false;
    //     $this->render();
    // }

    /**
     * Undocumented function
     *
     * @return void
     */
    // public function memberShip()
    // {
    //     $this->render();
    // }

    /**
     * Undocumented function
     *
     * @return void
     */
    // public function contract()
    // {
    //     $this->render();
    // }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function faq()
    {
        $this->render();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function terms()
    {
        $this->render();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function privacyPolicy()
    {
        $this->render();
    }

}
