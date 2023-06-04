<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;
use App\Helper\helper;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/3/en/views.html#the-app-view
 */
class AppView extends View
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
        // UserHelper.php �ǂݍ���
        $this->loadHelper('User');
        $this->loadHelper('Form', [
        'templates' => 'app_form',
      ]);

        $this->assign('title', $this->viewVars['title']);
        // URL���X�v���b�g
        $arrayUrl = explode(DS, rtrim($this->request->url, DS));
        // ��̏ꍇ�̓g�b�v�y�[�W�ɂȂ�
        if (empty($arrayUrl[0])) {
            $arrayUrl[0] = AREA['okinawa']['path'];
        }
        // ���[�U�[
        if ($arrayUrl[0] == PATH_ROOT['USER']) {
            // �p��������ݒ肷��
            $this->setMyPageBreadcrumb($arrayUrl);
        } else if (array_key_exists($arrayUrl[0], AREA) || $arrayUrl[0] == 'search'
            || $arrayUrl[0] == 'news') {
            // �p��������ݒ肷��
            $this->setBreadcrumb($arrayUrl);
        }
    }
    /**
     * �p��������ݒ肷��
     *
     * @param array $breadcrumbList
     * @return void
     */
    public function setMyPageBreadcrumb($breadcrumbList)
    {
        // ���̉�ʂ��g�b�v�y�[�W�̏ꍇ
        if ($this->viewVars['next_view'] == 'mypage') {
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS],
                ['title' => helper::encode('�}�C�y�[�W'), 'url' => ['controller' => $breadcrumbList[1], 'action' => 'mypage']]
            ]);
        } else if ($this->viewVars['next_view'] == 'profile') {
            // ���̉�ʂ��v���t�B�[���y�[�W�̏ꍇ
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS],
                ['title' => helper::encode('�}�C�y�[�W'), 'url' => ['controller' => $breadcrumbList[1], 'action' => 'mypage']],
                ['title' => helper::encode('�v���t�B�[��'), 'url' => ['controller' => $breadcrumbList[1], 'action' => 'profile']]
            ]);
        } else if ($this->viewVars['next_view'] == 'shop_favo') {
            // ���̉�ʂ��X�܂��C�ɓ���y�[�W�̏ꍇ
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS],
                ['title' => helper::encode('�}�C�y�[�W'), 'url' => ['controller' => $breadcrumbList[1], 'action' => 'mypage']],
                ['title' => helper::encode('�X�܂��C�ɓ���'), 'url' => ['controller' => $breadcrumbList[1], 'action' => 'shop_favo']]
            ]);
        } else if ($this->viewVars['next_view'] == 'cast_favo') {
            // ���̉�ʂ��X�^�b�t���C�ɓ���y�[�W�̏ꍇ
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS],
                ['title' => helper::encode('�}�C�y�[�W'), 'url' => ['controller' => $breadcrumbList[1], 'action' => 'mypage']],
                ['title' => helper::encode('�X�^�b�t���C�ɓ���'), 'url' => ['controller' => $breadcrumbList[1], 'action' => 'cast_favo']]
            ]);
        }
}
    /**
     * �p��������ݒ肷��
     *
     * @param array $breadcrumbList
     * @return void
     */
    public function setBreadcrumb($breadcrumbList)
    {
        // ���̉�ʂ��G���A�̃g�b�v�y�[�W�̏ꍇ
        if ($this->viewVars['next_view'] == 'news') {
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS],
                ['title' => helper::encode('�j���[�X'), 'url' => ['controller' => $breadcrumbList[0], 'action' => 'index']]
            ]);
        } else if ($this->viewVars['next_view'] == 'area') {
        // ���̉�ʂ��G���A�̃g�b�v�y�[�W�̏ꍇ
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS],
                ['title' => AREA[$breadcrumbList[0]]['label'], 'url' => ['controller' => $breadcrumbList[0], 'action' => 'index']]
            ]);
        } else if ($this->viewVars['next_view'] == 'genre') {
        // ���̉�ʂ��G���A�̃W�������̏ꍇ
            // ���X�g�ɒǉ�
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS]
                , ['title' => AREA[$breadcrumbList[0]]['label']
                    , 'url' => ['controller' => $breadcrumbList[0]]],
            ]);
            // ���X�g�̍Ō�ɒǉ�
            $this->Breadcrumbs->add(
                GENRE[$breadcrumbList[1]]['label'],
                "#!",
                ['class' => 'breadcrumbs-tail']
            );
        } else if ($this->viewVars['next_view'] == PATH_ROOT['SHOP']) {
            // ���̉�ʂ��X�܂̏ꍇ
                // ���X�g�ɒǉ�
                $this->Breadcrumbs->add([
                    ['title' => '<i class="material-icons">home</i>', 'url' => DS]
                    , ['title' => $this->viewVars['shopInfo']['area']['label']
                        , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']]]
                    , ['title' => $this->viewVars['shopInfo']['genre']['label']
                        ,'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                             .DS . $this->viewVars['shopInfo']['genre']['path']]],
                ]);
                // ���X�g�̍Ō�ɒǉ�
                $this->Breadcrumbs->add(
                    $this->viewVars['shop']['name'],
                    "#!",
                    ['class' => 'breadcrumbs-tail']
                );
            } else if ($this->viewVars['next_view'] == PATH_ROOT['REVIEW']) {
            // ���̉�ʂ����r���[�̏ꍇ
                // ���X�g�ɒǉ�
                $this->Breadcrumbs->add([
                    ['title' => '<i class="material-icons">home</i>', 'url' => DS]
                    , ['title' => $this->viewVars['shopInfo']['area']['label']
                        , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']]]
                    , ['title' => $this->viewVars['shopInfo']['genre']['label']
                        ,'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                            .DS . $this->viewVars['shopInfo']['genre']['path']]]
                    , ['title' => $this->viewVars['shopInfo']['name']
                        , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                            .DS . $this->viewVars['shopInfo']['genre']['path']
                            .DS . $this->viewVars['shopInfo']['id']]],
                ]);
                // ���X�g�̍Ō�ɒǉ�
                $this->Breadcrumbs->add(
                    SHOP_MENU_NAME['REVIEW'],
                    "#!",
                    ['class' => 'breadcrumbs-tail']
                );
            } else if ($this->viewVars['next_view'] == PATH_ROOT['CAST']) {
            // ���̉�ʂ��X�^�b�t�̏ꍇ
            // ���X�g�ɒǉ�
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS]
                , ['title' => $this->viewVars['shopInfo']['area']['label']
                    , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']]]
                , ['title' => $this->viewVars['shopInfo']['genre']['label']
                    ,'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                        .DS . $this->viewVars['shopInfo']['genre']['path']]]
                , ['title' => $this->viewVars['shopInfo']['name']
                    , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                        .DS . $this->viewVars['shopInfo']['genre']['path']
                        .DS . $this->viewVars['shopInfo']['id']]],
            ]);
            // ���X�g�̍Ō�ɒǉ�
            $this->Breadcrumbs->add(
                $this->viewVars['shop']['casts'][0]['nickname'],
                "#!",
                ['class' => 'breadcrumbs-tail']
            );
        } else if ($this->viewVars['next_view'] == PATH_ROOT['DIARY']) {
        // ���̉�ʂ����L�̏ꍇ
            // ���X�g�ɒǉ�
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS]
                , ['title' => $this->viewVars['shopInfo']['area']['label']
                    , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']]]
                , ['title' => $this->viewVars['shopInfo']['genre']['label']
                    ,'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                    .DS . $this->viewVars['shopInfo']['genre']['path']]]
                , ['title' => $this->viewVars['shopInfo']['name']
                    , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                    .DS . $this->viewVars['shopInfo']['genre']['path']
                    .DS . $this->viewVars['shopInfo']['id']]]
                , ['title' => $this->viewVars['cast']['nickname']
                    , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                    .DS . PATH_ROOT['CAST']
                    .DS . $this->viewVars['cast']['id']]],
            ]);
            // ���X�g�̍Ō�ɒǉ�
            $this->Breadcrumbs->add(
                helper::encode('���L'),
                "#!",
                ['class' => 'breadcrumbs-tail']
            );
        } else if ($this->viewVars['next_view'] == PATH_ROOT['GALLERY']) {
        // ���̉�ʂ��M�������[�̏ꍇ
            // ���X�g�ɒǉ�gallery
            $this->Breadcrumbs->add([
                ['title' => GENRE[$this->request->query['genre']]['label'],
                    'url' => ['controller' => $breadcrumbList[0], 'action' => 'genre/',
                    '?'=> ['genre' =>$this->request->query['genre']]]],
                ['title' => $this->request->query['name'],
                    'url' => ['controller' => $breadcrumbList[0], 'action' => 'shop/'.$this->request->query['shop'],
                    '?' => ['shop' => $this->request->query['shop'],'genre' => $this->request->query['genre'], 'name' => $this->request->query['name']]]],
                ['title' => $this->request->query['nickname'],
                    'url' => ['controller' => $breadcrumbList[0], 'action' => 'cast/'.$this->request->query['cast'],
                    '?' => ['shop' => $this->request->query['shop'], 'cast' => $this->request->query['cast'], 'genre' => $this->request->query['genre'] , 'name' => $this->request->query['name'],
                    'nickname' => $this->request->query['nickname']]]],
            ]);
            // ���X�g�̍Ō�ɒǉ�
            $this->Breadcrumbs->add(
                helper::encode('�M�������['),
                "#!",
                ['class' => 'breadcrumbs-tail']
            );
        } else if ($this->viewVars['next_view'] == PATH_ROOT['NOTICE']) {
        // ���̉�ʂ����m�点�̏ꍇ
            // ���X�g�ɒǉ�
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS]
                , ['title' => $this->viewVars['shopInfo']['area']['label']
                    , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']]]
                , ['title' => $this->viewVars['shopInfo']['genre']['label']
                    ,'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                    .DS . $this->viewVars['shopInfo']['genre']['path']]]
                , ['title' => $this->viewVars['shopInfo']['name']
                    , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                    .DS . $this->viewVars['shopInfo']['genre']['path']
                    .DS . $this->viewVars['shopInfo']['id']]],
            ]);
            // ���X�g�̍Ō�ɒǉ�
            $this->Breadcrumbs->add(
                helper::encode('���m�点'),
                "#!",
                ['class' => 'breadcrumbs-tail']
            );
        } else if ($this->viewVars['next_view'] == 'search') {
        // ���̉�ʂ������̏ꍇ
            // ���X�g�ɒǉ�
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS],
            ]);
            // ���X�g�̍Ō�ɒǉ�
            $this->Breadcrumbs->add(
                helper::encode('����'),
                "#!",
                ['class' => 'breadcrumbs-tail']
            );
        }

    }
}
