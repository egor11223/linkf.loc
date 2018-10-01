<?php
namespace app\models;

use Yii;
use yii\base\Model;

class UrlForm extends Model
{
    public $url;
    public $interval;
    public $type;
    public $file;

    public function rules(){
        return [
            ['url', 'url', 'defaultScheme' => ['http', 'https']],
            ['file', 'file', 'extensions' => 'csv, txt'],
/*            [['url', 'file'],  function($attribute){
                if(empty($this->url) && empty($this->file)){
                    $this->addError($attribute, 'Заполните хотя-бы одно поле');
                }
            }, 'skipOnEmpty' => false],*/
            ['interval', 'required', 'message' => 'Введите интервал'],
            ['interval', 'integer', 'message' => 'Только цифры'],
            ['type', 'required', 'message' => 'Выберите единицу измерения'],
        ];
    }
    public function attributeLabels()
    {
        return[
            'url' => 'URL',
            'interval' => 'Интервал',
            'type' => 'Единица измерения',
            'file' => 'Загрузить CSV&TXT файл',
        ];
    }
}
?>