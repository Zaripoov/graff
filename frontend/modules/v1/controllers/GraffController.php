<?php


namespace frontend\modules\v1\controllers;


use frontend\modules\v1\models\Dijkstra;
use frontend\modules\v1\models\Links;
use frontend\modules\v1\models\Notes;
use Yii;
use yii\filters\Cors;
use yii\rest\ActiveController;

class GraffController extends ActiveController
{

    public $modelClass = Links::class;

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

        $links = Links::find()->all();

        return $links;
    }

    public function actionCreate(){
        $link = new Links();
        $nodes = Notes::find()->all();
        if($link->load(Yii::$app->getRequest()->getBodyParams(), '')){

            foreach ($nodes as $node){
                if($link['start_point'] == $node['point']){
                    $link['start_point'] = $node['id'];
                }
                if($link['end_point'] == $node['point']){
                    $link['end_point'] = $node['id'];
                }
            }

            if($link->save()){
                $message =  ['message' => 'Добавлено'];
            }else{
                $message = ['message' => 'Что-то пошло не так'];
            }
            return $message;
        }

        return Yii::$app->response->statusCode = 422;
    }

    public function actionUpdate($id){
        $link = Links::findOne($id);

        if($link->load(Yii::$app->getRequest()->getBodyParams(), '')){
            if($link->update()){
                $message = ['message' => 'Изменено'];
            }else{
                $message = ['message' => 'Что-то пошло не так'];
            }
            return $message;
        }
        return Yii::$app->response->statusCode = 422;
    }

    public function actionDelete($id){
        $link = Links::findOne($id)->delete();

        if($link){
            $message = ['message' => 'Удалено'];
            return $message;
        }

        return Yii::$app->response->statusCode = 422;
    }

    public function actionSearchWay($start, $finish){

        $nodes = Notes::find()->all();
        $links = Links::find()->all();

        $startIndex = $start;
        $finishIndex = $finish;

        foreach ($nodes as $node){
            if($node['point'] == $startIndex){
                $startIndex = $node['id'];
            }
            if($node['point'] == $finishIndex){
                $finishIndex = $node['id'];
            }
        }

        $dijkstra = new Dijkstra($startIndex, $finishIndex, $nodes, $links);

        return  ['paths' => $dijkstra->pathSequence(), 'shortWay' => $dijkstra->shortStroke()];



    }


}