<?php

namespace app\modules\api\v1\controllers;

use app\modules\api\base\actions\CreateAction;
use app\modules\api\base\actions\UpdateAction;
use app\modules\api\base\controllers\ActiveController;
use app\modules\api\v1\models\ApiUserIdentity;
use app\modules\api\v1\models\UserSettingsCreateForm;
use app\modules\api\v1\models\UserSettingsUpdateForm;
use app\modules\api\v1\resources\UserSettings;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class UserSettingsController
 * @package app\modules\api\v1\controllers
 */
class UserSettingsController extends ActiveController
{
    public $modelClass = UserSettings::class;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions['create'] = [
            'modelClass' => $this->modelClass,
            'formClass' => UserSettingsCreateForm::className(),
            'class' => CreateAction::className(),
        ];
        $actions['update'] = [
            'modelClass' => $this->modelClass,
            'formClass' => UserSettingsUpdateForm::className(),
            'class' => UpdateAction::className(),
        ];

        return $actions;
    }


    /**
     * @return UserSettings[]|static[]
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        return $this->findAllModels();
    }

    /**
     * @param null $id
     * @return UserSettings
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id = null)
    {
        return $this->findModel($id);
    }

    /**
     * @param $id
     * @return false|int
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        /** @var $user ApiUserIdentity */
        $user = Yii::$app->user->getIdentity();
        if ((integer) $id === $user->settings_id) {
            Yii::$app->response->statusCode = 422;
            return Yii::t('api', 'You cant delete your current settings');
        }

        $model = $this->findModel($id);
        return $model->delete();
    }

    /**
     * @return static[]|UserSettings[]
     * @throws NotFoundHttpException
     */
    private function findAllModels()
    {
        $models = UserSettings::findAll([
            'user_id' => Yii::$app->user->getId(),
        ]);

        if (null === $models) {
            throw new NotFoundHttpException(Yii::t('api', 'Settings not found'));
        }

        return $models;
    }

    /**
     * @param $id
     * @return UserSettings
     * @throws NotFoundHttpException
     */
    private function findModel($id = null)
    {
        if (null === $id) {
            /** @var $user ApiUserIdentity */
            $user = Yii::$app->user->getIdentity();
            $model = UserSettings::findOne($user->settings_id);
        } else {
            $model = UserSettings::findOne([
                'user_id' => Yii::$app->user->id,
                'id' => $id,
            ]);
        }

        if (null === $model) {
            throw new NotFoundHttpException(Yii::t('api', 'Settings not found'));
        }

        return $model;
    }
}
