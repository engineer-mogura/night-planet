<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\OutSideSqlComponent;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $components = array('Util', 'OutSideSql', 'Instagram');
    public function initialize() {
        parent::initialize();
        $this->loadComponent('S3Client');
        $this->s3Backet = env('AWS_BUCKET');
        $this->loadComponent('Flash');
        $this->AccessMonths  = TableRegistry::get('access_months');
        $this->AccessWeeks   = TableRegistry::get('access_weeks');
        $this->AccessYears   = TableRegistry::get('access_years');
        $this->CastLikes     = TableRegistry::get('cast_likes');
        $this->CastSchedules = TableRegistry::get('cast_schedules');
        $this->Casts         = TableRegistry::get('casts');
        $this->Coupons       = TableRegistry::get('coupons');
        $this->DiaryLikes    = TableRegistry::get('diary_likes');
        $this->Diarys        = TableRegistry::get('diarys');
        $this->Jobs          = TableRegistry::get('jobs');
        $this->MasterCodes   = TableRegistry::get('master_codes');
        $this->NewPhotosRank = TableRegistry::get('new_photos_rank');
        $this->Owners        = TableRegistry::get('owners');
        $this->Reviews       = TableRegistry::get('reviews');
        $this->ServecePlans  = TableRegistry::get('servece_plans');
        $this->ShopInfoLikes = TableRegistry::get('shop_info_likes');
        $this->ShopInfos     = TableRegistry::get('shop_infos');
        $this->ShopLikes     = TableRegistry::get('shop_likes');
        $this->ShopOptions   = TableRegistry::get('shop_options');
        $this->Shops         = TableRegistry::get('shops');
        $this->Snss          = TableRegistry::get('snss');
        $this->Tmps          = TableRegistry::get('tmps');
        $this->Updates       = TableRegistry::get('updates');
        $this->Users         = TableRegistry::get('users');
        $this->WorkSchedules = TableRegistry::get('work_schedules');
    }

    public function beforeFilter(Event $event) {
        $masterCodesFind = array('area', 'genre');
        $selectList = $this->Util->getSelectList($masterCodesFind, $this->MasterCodes, false);
        $this->set(compact('selectList'));
        $this->viewBuilder()->layout('userDefault');

        // 認証済クッキーがあればユーザ情報を取得する
        if (!empty($user = (array) json_decode($this->request->getCookie('_auth_info')))) {
            if ($this->Users->exists(['id' => $user['id']])) {
                $user = $this->Users->get($user['id']);
                // ユーザに関する情報をセット
                $userInfo = $this->Util->getUserInfo($user);

                $exist = $this->S3Client->doesObjectExist(PATH_ROOT['USERS'] . DS . $user->file_name);
                // ファイルが存在したら、画像をセット
                if ($exist) {
                    $userInfo = $userInfo + array('icon' => PATH_ROOT['URL_S3_BUCKET'] . DS . PATH_ROOT['USERS'] . DS . $user->file_name);
                } else {
                    // 共通アイコン画像をセット
                    $userInfo = $userInfo + array('icon' => PATH_ROOT['NO_IMAGE02']);
                }
                $this->set(compact("userInfo"));
            }
        }
    }
}
