<?php


namespace frontend\modules\v1\controllers;


use frontend\modules\v1\models\Notes;
use Yii;
use yii\filters\Cors;
use yii\rest\ActiveController;

class NotesController extends ActiveController
{

    public $modelClass = Notes::class;

    public function behaviors() {

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),

        ];

        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'formatParam' => '_format',
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
                'xml' => \yii\web\Response::FORMAT_XML
            ],
        ];

        return $behaviors;
    }

    public function actions(){
        $actions = parent::actions();

        unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
    }

    public function actionIndex(){

        $notes = Notes::find()->all();

        return $notes;
    }

    public function actionCreate(){
        $notes = new Notes();

        if($notes->load(Yii::$app->getRequest()->getBodyParams(), '')){
            if($notes->save()){
                $message =  ['message' => 'Добавлено'];
            }else{
                $message = ['message' => 'Что-то пошло не так'];
            }

            return $message;
        }

        return Yii::$app->response->statusCode = 422;
    }

    public function actionUpdate($id){
        $note = Notes::findOne($id);

        if($note->load(Yii::$app->getRequest()->getBodyParams(), '')){
            if($note->update()){
                $message = ['message' => 'Изменено'];
            }else{
                $message = ['message' => 'Что-то пошло не так'];
            }

            return $message;
        }

        return Yii::$app->response->statusCode = 422;

    }

    public function actionDelete($id){
        $note = Notes::findOne($id)->delete();

        if($note){
            $message = ['message' => 'Удалено'];
            return $message;
        }
        return Yii::$app->response->statusCode = 422;
    }



}