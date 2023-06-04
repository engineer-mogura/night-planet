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
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Mailer\MailerAwareTrait;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\ForbiddenException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class EntryController extends AppController
{
    use MailerAwareTrait;

    public $components = array('Security');

    public function beforeFilter(Event $event)
    {
        $this->viewBuilder()->layout('simpleDefault');
        $this->Security->setConfig('blackHoleCallback', 'blackhole');
        // $this->Auth->allow(['signup','verify','logout']);
        parent::beforeRender($event); //親クラスのbeforeRendorを呼ぶ
        parent::beforeFilter($event);
    }

    /**
     * Displays a view
     *
     * @param array ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function display(...$path)
    {
        $count = count($path);
        if (!$count) {
            return $this->redirect('/entry');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if ($path[0] == 'signup') {
            if ($this->request->getQuery('action') == 'signup') {
                $this->setAction('signup');
            }
            $owner = $this->Owners->newEntity();
            $masterCodesFind = array('area','genre');
            $selectList = $this->Util->getSelectList($masterCodesFind, $this->MasterCodes, false);
            $this->set(compact('selectList', 'owner'));
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    {
        $this->layout = false;
        $this->render();
    }

    public function signup()
    {
        // レイアウト上書き
        $this->viewBuilder()->layout('simpleDefault');

        // 登録ボタン押下時
        if ($this->request->is('post')) {
            // バリデーションは新規登録用を使う。
            $owner = $this->Tmps->newEntity($this->request->getData(), ['validate' => 'ownerRegistration']);

            if (!$owner->errors()) {

                if ($this->Tmps->save($owner)) {

                    $email = new Email('default');
                    $email->setFrom([MAIL['FROM_SUBSCRIPTION'] => MAIL['FROM_NAME']])
                        ->setSubject($owner->name."様、メールアドレスの認証を完了してください。")
                        ->setTo($owner->email)
                        ->setBcc(MAIL['FROM_INFO_GMAIL'])
                        ->setTemplate("auth_send")
                        ->setLayout("simple_layout")
                        ->emailFormat("html")
                        ->viewVars(['owner' => $owner])
                        ->send();
                    $this->log($email,'debug');
                    $this->Flash->success('ご指定のメールアドレスに認証メールを送りました。認証を完了してください。');
                    return $this->render('send_auth_email');
                }

            }
            // 入力エラーがあれば、メッセージをセットして返す
            $this->Flash->error(__('入力内容に誤りがあります。'));
        }

        $masterCodesFind = array('age');
        $selectList = $this->Util->getSelectList($masterCodesFind, $this->MasterCodes, true);
        $this->set(compact('owner', 'selectList'));
        $this->render();
    }

    public function blackhole($type)
    {
        switch ($type) {
          case 'csrf':
            $this->Flash->error(__('不正な送信が行われました'));
            $this->redirect(array('controller' => 'entry', 'action' => $this->action));
            break;
          default:
            $this->redirect(array('controller' => 'entry', 'action' => 'display'));
            break;
        }
    }
}
