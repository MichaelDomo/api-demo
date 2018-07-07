<?php

namespace app\modules\api\v1\controllers;

use app\modules\api\v1\models\UserCodeCreateForm;
use app\modules\api\v1\models\UserTokenCreateForm;
use Yii;
use yii\rest\Controller;

/**
 * AuthController
 */
class AuthController extends Controller
{
    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'code-create' => ['POST'],
            'token-create' => ['POST'],
        ];
    }

    /**
     * @return UserCodeCreateForm|\app\modules\api\v1\resources\UserCode|null
     */
    public function actionCodeCreate()
    {
        $model = new UserCodeCreateForm();
        $model->load(Yii::$app->request->bodyParams, '');
        if ($code = $model->create()) {
            return $code;
        }

        return $model;
    }

    /**
     * @return UserTokenCreateForm|\app\modules\api\v1\resources\UserToken|null
     */
    public function actionTokenCreate()
    {
        $model = new UserTokenCreateForm();
        $model->load(Yii::$app->request->bodyParams, '');
        if ($token = $model->create()) {
            return $token;
        }

        return $model;
    }
}
