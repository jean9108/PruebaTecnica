<?php

namespace app\controllers;

use Yii;

use app\models\Hoteles;
use yii\web\Controller;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * HotelesController implements the CRUD actions for Hoteles model.
 */
class HotelesController extends Controller
{
    
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => AccessControl::class,
                'rules' =>[
                    'actions' => [
                        'allow' => true,
                        'actions' =>['index','view', 'create', 'update', 'delete'],
                        'roles' => ['?','@'],
                    ],
                ],
            ],
        ];
    }

    /* ============================================================
      ================ Trae los hoteles de la BD ============
     ============================================================ */
    public function actionIndex(){
        $model = Hoteles::find()
        ->where('estado = :estado')
        ->addParams([':estado' => 'Activo'])
        ->all();

        if(!empty($model)){
            $hoteles = ArrayHelper::map($model, 'id_hotel', 'nombre');
            $data =[
                'status' => 'success',
                'code' => '200',
                'habitaciones' => $hoteles,
            ];
        }else{
            $data =[
                'status' => 'error',
                'code' => '400',
                'message' => 'No se encontró ningún hotel',
            ];
        }

        return $data;
    }

    /* ============================================================
    ==================   Trae el hotel escogido  ==================
     ============================================================ */
    public function actionView($id){
        $model = Hoteles::find()
            ->where('id_hotel = :id_hotel')
            ->addParams(['id_hotel' => $id])
            ->one();

        if(!empty($model)){
            $data =[
                'status' => 'success',
                'code' => '200',
                'hotel' => $model,
            ];
        }else{
            $data =[
                'status' => 'error',
                'code' => '400',
                'message' => 'No se encontró ningún hotel',
            ];
        }

        return $data;
    }

    /*==========================================================================
    ====================== Creación de Hoteles ===============================
    ==========================================================================*/

    public function actionCreate(){
        $date = new \DateTime('now');

        $request = Yii::$app->request;
        $hotel = json_decode($request->post('json'),true);

        $model = new Hoteles;
        $model->scenario = 'crear_hotel';

        $model->attributes = $hotel;
        $model->fecha_creacion = date_format($date, 'Y-m-d H:i:s');

        if($model->validate() && $model->save()){
            $data =[
                'status' => 'success',
                'code' => '200',
                'message' => 'Registro de hotel completa',
            ]; 
        }else{
            $data =[
                'status' => 'error',
                'code' => '400',
                'errors' => $model->getErrors()
            ]; 
        }
        
        return $data;
    }

    /*==========================================================================
    ====================== Actualización de Hoteles =============================
    ==========================================================================*/
    public function actionUpdate($id){

        $date = new \DateTime('now');
        $request = Yii::$app->request;
        $hotel = json_decode($request->post('json'),true);

        if(!empty($hotel)){
            $model = Hoteles::findOne($id);
            $model->scenario = 'modificar_hotel';

            $model->attributes = $hotel;
            $model->fecha_actualizacion = date_format($date, 'Y-m-d H:i:s');

            if($model->validate() && $model->save()){
                $data =[
                    'status' => 'success',
                    'code' => '200',
                    'message' => 'Actualización de hotel completa',
                ]; 
            }else{
                $data =[
                    'status' => 'error',
                    'code' => '400',
                    'errors' => $model->getErrors()
                ]; 
            }
        }else{
            $data =[
                'status' => 'error',
                'code' => '400',
                'message' => 'No se ha podido actualizar el hotel',
            ]; 
        }

        return $data;
    }

     /*==========================================================================
    ====================== Borrado de Hoteles =============================
    ==========================================================================*/
    public function actionDelete($id){
        $model = Hoteles::findOne($id);
        $model->estado = 'Inactivo';
        $model->save();

        $data =[
            'status' => 'success',
            'code' => '200',
            'message' => 'El hotel ha sido eliminado',
        ];

        return $data;
    }


    protected function findModel($id)
    {
        if (($model = Hoteles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
