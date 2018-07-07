<?php

namespace app\modules\api\v1\controllers;

use app\modules\api\base\actions\CreateAction;
use app\modules\api\base\controllers\ActiveController;
use app\modules\api\v1\models\UserFilterCreateForm;
use app\modules\api\v1\resources\UserFilter;
use Yii;
use yii\rest\OptionsAction;
use yii\web\NotFoundHttpException;
use yii\rest\ViewAction;

/**
 * UserFilterController
 */
class UserFilterController extends ActiveController
{
    public $modelClass = UserFilter::class;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions['options'] = ['class' => OptionsAction::class];
        $actions['view'] = [
            'modelClass' => $this->modelClass,
            'class' => ViewAction::class
        ];
        $actions['create'] = [
            'modelClass' => $this->modelClass,
            'formClass' => UserFilterCreateForm::className(),
            'class' => CreateAction::className(),
        ];

        return $actions;
    }

    /**
     * @return static[]
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        return $this->findAllModels();
    }

    /**
     * @param $id
     * @return bool
     * @throws \yii\db\StaleObjectException
     * @throws \Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        return $model->delete();
    }

    /**
     * @return static[]
     * @throws NotFoundHttpException
     */
    private function findAllModels()
    {
        $model = UserFilter::findAll([
            'settings_id' => Yii::$app->user->getIdentity()->settings_id,
        ]);

        if (null === $model) {
            throw new NotFoundHttpException(Yii::t('api', 'Filters not found!'));
        }

        return $model;
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    private function findModel($id)
    {
        $model = UserFilter::findOne([
            'settings_id' => Yii::$app->user->getIdentity()->settings_id,
            'id' => $id,
        ]);

        if (null === $model) {
            throw new NotFoundHttpException(Yii::t('api', 'Filter not found!'));
        }

        return $model;
    }
}
