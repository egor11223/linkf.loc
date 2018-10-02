<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UrlForm;
use yii\web\UploadedFile;
use yii\helpers\Html;
use GuzzleHttp\Client;
use yii\helpers\Url;
use Caxy\HtmlDiff\HtmlDiff;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionTestdiff(){
    }
    public function actionGeturl()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://amakids.ru/');
        $body = $res->getBody();
        $html1 = '<h1>Big dice</h1>';
        $html2 = '<h5>Big box</h5>';
        $htmldiff = new HtmlDiff($html1, $html2);
        $content = $htmldiff->build();
        return $this->render('geturl', ['content' => $content]);
    }
    public function actionUrlform(){
        $form = new UrlForm();
        if($form->load(Yii::$app->request->post()) && $form->validate()){
            $url = Html::encode($form->url);
            $type = Html::encode($form->type);
            $interval = Html::encode($form->interval);
            $form->file = UploadedFile::getInstance($form, 'file');
            $date = new \DateTime();
            if(!empty($url)){
                $url = explode(PHP_EOL, $url);
                $data = [];
                foreach ($url as $item){
                    if(!empty($item)){
                        $data[] = [
                            $item,
                            $interval,
                            $date->format('Y-m-d H:i:s'),
                        ];
                    }
                }
                Yii::$app->db->createCommand()->batchInsert('url_info', ['url', 'ckeck_interval', 'create_date'], $data)->execute();
            }
            if(!empty($form->file)){
                $txt_url = file_get_contents($form->file->tempName);
                $txt_url = explode(PHP_EOL, $txt_url);
                $data = [];
                foreach ($txt_url as $item){
                    $data[] = [
                        $item,
                        $interval,
                        $date->format('Y-m-d H:i:s'),
                    ];
                }
                Yii::$app->db->createCommand()->batchInsert('url_info', ['url', 'ckeck_interval', 'create_date'], $data)->execute();
                print_r($data);
            }
        }
        return $this->render('urlform', ['form' => $form]);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * Login action.
     *
     * @return Response|string
     *//*
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }*/

    /**
     * Logout action.
     *
     * @return Response
     */
    /*public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }*/

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
/*    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }*/

    /**
     * Displays about page.
     *
     * @return string
     */
/*    public function actionAbout()
    {
        return $this->render('about');
    }*/
}
