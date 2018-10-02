<?
namespace app\controllers;
use Yii;
use app\models\Url;
use yii\web\Controller;

class AjaxController extends Controller{
/*    public function actionIndex()
    {
        if(Yii::$app->request->isAjax){
            $pk = Yii::$app->request->post('row_id');
            foreach ($pk as $key => $value)
            {
                $sql = "DELETE FROM url_info WHERE id = $value";
                $query = Yii::$app->db->createCommand($sql)->execute();
            }
            return $this->redirect(['urltable/index']);
        }else{
            return 'Бууу!';
        }

    }*/
}
?>