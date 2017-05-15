<?php

namespace app\controllers;


use app\services\serializer\Serializer;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    public $serializer = Serializer::class;

    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => $this->verbs(),
            ],
        ];
    }

    protected function getRequest()
    {
        return \Yii::$app->getRequest();
    }

    protected function getResponse()
    {
        return \Yii::$app->getResponse();
    }
}