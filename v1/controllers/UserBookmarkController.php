<?php

namespace app\modules\api\v1\controllers;

use app\modules\api\base\actions\CreateAction;
use app\modules\api\base\controllers\ActiveController;
use app\modules\api\v1\models\UserBookmarkCreateForm;
use app\modules\api\v1\resources\UserBookmark;
use Yii;
use yii\rest\OptionsAction;
use yii\web\NotFoundHttpException;
use yii\rest\ViewAction;

/**
 * UserFilterController
 */
class UserBookmarkController extends ActiveController
{
    public $modelClass = UserBookmark::class;

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
            'formClass' => UserBookmarkCreateForm::className(),
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
     * @param $projectId
     * @return bool
     * @throws \yii\db\StaleObjectException
     * @throws \Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($projectId)
    {
        $model = $this->findModelByProjectId($projectId);

        return $model->delete();
    }

    /**
     * @return static[]
     * @throws NotFoundHttpException
     */
    private function findAllModels()
    {
        $model = UserBookmark::findAll([
            'user_id' => Yii::$app->user->getId()
        ]);

        if (null === $model) {
            throw new NotFoundHttpException(Yii::t('api', 'Bookmarks not found!'));
        }

        return $model;
    }

    /**
     * @param $projectId
     * @return array|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    private function findModelByProjectId($projectId)
    {
        $model = UserBookmark::findOne([
            'user_id' => Yii::$app->user->getId(),
            'project_id' => $projectId,
        ]);

        if (null === $model) {
            throw new NotFoundHttpException(Yii::t('api', 'Bookmark not found!'));
        }

        return $model;
    }
}
