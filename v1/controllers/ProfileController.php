<?php

namespace app\modules\api\v1\controllers;

use app\modules\api\base\actions\UpdateAction;
use app\modules\api\base\controllers\ActiveController;
use app\modules\api\v1\models\ProfileUpdateForm;
use app\modules\api\v1\resources\Profile;
use Yii;

/**
 * ProfileController
 */
class ProfileController extends ActiveController
{
    public $modelClass = Profile::class;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions['update'] = [
            'modelClass' => $this->modelClass,
            'formClass' => ProfileUpdateForm::className(),
            'class' => UpdateAction::className(),
        ];

        return $actions;
    }

    /**
     * @return \yii\web\IdentityInterface
     */
    public function actionIndex()
    {
        return $this->findModel();
    }

    /**
     * @return \yii\web\IdentityInterface
     */
    private function findModel()
    {
        return Profile::findOne(Yii::$app->user->id);
    }
}
