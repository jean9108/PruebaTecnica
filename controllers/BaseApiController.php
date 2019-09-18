<?php 
namespace app\controllers;

use yii\rest\ActiveController;

/*======================================================
============== Clase Generica para API=================
====================================================== */

class BaseApiController extends ActiveController{
    
    public $serializer = [
        'class' => 'yii\rest\Serializer', 
    ];

    public function checkAccess($action, $model = null, $params=[]){
        return true;
    }

    public function behaviors(){
        return [
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formatParam' => 'format',
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON
                ],
            ]
        ];
    }
}
?>