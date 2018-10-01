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
use yii\validators\Validator;

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
    public function actionUrlform(){
        $form = new UrlForm();
        if($form->load(Yii::$app->request->post()) && $form->validate()){
            $url = Html::encode($form->url);
            $type = Html::encode($form->type);
            $interval = Html::encode($form->interval);
            $form->file = UploadedFile::getInstance($form, 'file');
            $rules = $form->validators;
            $new_rules = Validator::createValidator($form, ['url', 'file'], [function ($attribute){
                if(empty($this->url) && empty($this->file)){
                    $this->addError($attribute, 'Заполните хотя-бы одно поле');
                }
            }], ['skipOnEmpty' => false]);
            $rules->append($new_rules);
            $form->validate();
            if(!empty($url)){
                echo('Выполнено условие если не пусто &nbsp');
                $url = explode(PHP_EOL, $url);
                $mess = 'Error!';
                if($form->file !== ""){
                    var_dump($form->file);
                }
            }
            if(!empty($form->file)){
                echo('Выполнено условие если не пусто');
                $txt_url = file_get_contents($form->file->tempName);
                $txt_url = explode(PHP_EOL, $txt_url);
                $data = [];
                foreach ($txt_url as $item){
                    $data[] = [
                        $item,
                        $interval,
                    ];
                }
                Yii::$app->db->createCommand()->batchInsert('url_info', ['url', 'ckeck_interval'], $data)->execute();
                print_r($data);
            }
        }
        return $this->render('urlform', ['form' => $form, 'mess' => $mess]);
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
