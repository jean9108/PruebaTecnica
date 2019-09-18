<?php

namespace app\controllers;

use Yii;
use app\models\Hoteles;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;




/**
 * HotelesController implements the CRUD actions for Hoteles model.
 */
class HotelesController extends BaseApiController
{
    public $enableCsrfValidation = false;

    public $modelClass = Hoteles::class;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => AccessControl::class,
                'rules' =>[
                    'actions' => [
                        'allow' => true,
                        'actions' =>['createhotel', 'createtiposhabitaciones'],
                        'roles' => ['?','@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreatehotel(){
        $model = new Hoteles;
        $model->attributes = Yii::$app->request->post();
    
        if($model->validate() && $model->save()){
            return 'Guardado con exito';
        }else{
            return  json_encode($model->getErrors());
        }
        
    }

    public function actionCreatetiposhabitaciones(){
        $model = new Hoteles;
        $model->attributes = Yii::$app->request->post();
        return 'Esta aqui';
    }
    /**
     * Finds the Hoteles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hoteles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Hoteles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
