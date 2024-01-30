<?php

namespace App\Controller\Component;

use RuntimeException;
use Cake\Controller\Component;
// Composer を使用して Google Cloud の依存関係を組み込む
use Google\Cloud\RecaptchaEnterprise\V1\Event;
use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\TokenProperties\InvalidReason;
use Google\Cloud\RecaptchaEnterprise\V1\RecaptchaEnterpriseServiceClient;

/**
 * CakePHP3 S3Client Component
 *            with
 *      AWS SDK for PHP3
 * @see https://aws.amazon.com/jp/sdk-for-php/
 * @see https://github.com/aws/aws-sdk-php
 * @see https://www.ritolab.com/posts/104
 * @see https://qiita.com/reflet/items/3e0f07bc9d64314515c1
 * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/index.html
 */
class GoogleRecaptchaComponent extends Component {
    protected $_defaultConfig = [];

    protected $recaptchaKey;
    protected $token;
    protected $project;
    protected $action;

    public function initialize(array $config) {

    }

/**
  * 評価を作成して UI アクションのリスクを分析する。
  * @param string $recaptchaKey サイト / アプリに関連付けられた reCAPTCHA キー
  * @param string $token クライアントから取得した生成トークン。
  * @param string $project Google Cloud プロジェクト ID
  * @param string $action トークンに対応するアクション名。
  */
  function create_assessment($request) {

    $this->project = env('GOOGLE_PROJECT_ID', 'not defind!');
    $this->recaptchaKey = env('GOOGLE_RE_CAPTCHA_KEY', 'not defind!');
    $this->token = $request->getData('recaptcha_token');
    $this->action = $request->getData('recaptcha_action');

    // reCAPTCHA クライアントを作成する。
    // TODO: クライアント生成コードをキャッシュに保存するか（推奨）、メソッドを終了する前に client.close() を呼び出す。
    // GOOGLE_APPLICATION_CREDENTIALS 環境変数で指定
    putenv('GOOGLE_APPLICATION_CREDENTIALS=' . CONFIG . 'googles/service-account-credentials.json');
    $client = new RecaptchaEnterpriseServiceClient();
    $projectName = $client->projectName($this->project);

    // 追跡するイベントのプロパティを設定する。
    $event = (new Event())
      ->setSiteKey($this->recaptchaKey)
      ->setToken($this->token);

    // 評価リクエストを作成する。
    $assessment = (new Assessment())
      ->setEvent($event);

    try {
      $response = $client->createAssessment(
        $projectName,
        $assessment
      );

      // トークンが有効かどうかを確認する。
      if ($response->getTokenProperties()->getValid() == false) {
        $this->log('The CreateAssessment() call failed because the token was invalid for the following reason: '
             . '[score: ' . $response->getTokenProperties()->getInvalidReason() . ' ]', 'error');
        return false;
      }

      // 想定どおりのアクションが実行されたかどうかを確認する。
      if ($response->getTokenProperties()->getAction() == $this->action) {
        // リスクスコアと理由を取得する。
        // 評価の解釈の詳細については、以下を参照:
        // https://cloud.google.com/recaptcha-enterprise/docs/interpret-assessment
        $score = floor(round($response->getRiskAnalysis()->getScore(), 4) * 10) / 10;
        if ($score > 0.8) {
            return true;
        } else {
            $this->log('reCAPTCHA スコアチェックエラー[score: ' . $score . ' ]', 'error');
            return false;
        }

      } else {
        $this->log('The action attribute in your reCAPTCHA tag does not match the action you are expecting to score' . $response->getTokenProperties()->getAction() , 'error');
        return false;
      }
    } catch (exception $e) {
        $this->log('CreateAssessment() call failed with the following error: [ ' . $e . ']', 'error');
        return false;
    }
  }
}
