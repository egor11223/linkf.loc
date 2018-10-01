<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "url_info".
 *
 * @property int $id
 * @property string $create_date
 * @property string $url
 * @property string $first_url_file
 * @property string $last_url_file
 * @property string $last_check_date
 * @property int $ckeck_interval
 * @property string $status
 * @property string $meta_title
 * @property string $meta_description
 */
class Url extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'url_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_date', 'url', 'first_url_file', 'last_url_file', 'last_check_date', 'ckeck_interval', 'status', 'meta_title', 'meta_description'], 'required'],
            [['create_date', 'last_check_date'], 'safe'],
            [['ckeck_interval'], 'integer'],
            [['url'], 'string', 'max' => 250],
            [['first_url_file', 'last_url_file'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 75],
            [['meta_title'], 'string', 'max' => 350],
            [['meta_description'], 'string', 'max' => 550],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'create_date' => 'Create Date',
            'url' => 'Url',
            'first_url_file' => 'First Url File',
            'last_url_file' => 'Last Url File',
            'last_check_date' => 'Last Check Date',
            'ckeck_interval' => 'Ckeck Interval',
            'status' => 'Status',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
        ];
    }
}
