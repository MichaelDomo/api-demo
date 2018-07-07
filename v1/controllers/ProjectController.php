<?php

namespace app\modules\api\v1\controllers;

use app\modules\api\base\actions\SearchAction;
use app\modules\api\base\controllers\ActiveController;
use app\modules\api\v1\models\ProjectSearchForm;
use yii\rest\ViewAction;
use app\modules\api\v1\resources\Project;

/**
 * ProjectController
 */
class ProjectController extends ActiveController
{
    public $modelClass = Project::class;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions['search'] = [
            'formClass' => ProjectSearchForm::className(),
            'modelClass' => $this->modelClass,
            'class' => SearchAction::className(),
        ];
        $actions['view'] = [
            'modelClass' => $this->modelClass,
            'class' => ViewAction::className(),
        ];

        return $actions;
    }
}
