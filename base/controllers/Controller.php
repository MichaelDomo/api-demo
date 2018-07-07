<?php

namespace app\modules\api\base\controllers;

use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller as BaseController;
use yii\rest\Serializer;

/**
 * Class Controller
 * @package app\modules\api\base\controllers
 */
class Controller extends BaseController
{
    /**
     * The list of actions not needing token protection.
     * @var array
     */
    public $unsecuredActions = [];

    /**
     * @var string|array the configuration for creating the serializer that formats the response data
     */
    public $serializer = [
        'class' => Serializer::class,
        'collectionEnvelope' => 'items',
    ];

    /**
     * {@inheritdoc}
     */
    public function verbs()
    {
        parent::verbs();
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'search' => ['POST'],
            'create' => ['POST', 'PUT'],
            'update' => ['POST'],
            'delete' => ['DELETE'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        /*$behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::class,
        ];*/

        $behaviors['access']['class'] = AccessControl::class;
        $behaviors['access']['rules'] = [
            [
                'allow' => true,
                'actions' => ['options'],
                'roles' => ['?'],
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ];
        return $behaviors;
    }
}
