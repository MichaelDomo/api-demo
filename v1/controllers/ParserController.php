<?php

namespace app\modules\api\v1\controllers;

use app\modules\api\base\controllers\Controller;
use app\modules\api\v1\resources\Parser;
use yii\web\NotFoundHttpException;

/**
 * ParserController
 */
class ParserController extends Controller
{
    /**
     * @return \yii\db\ActiveRecord[]
     */
    public function actionIndex()
    {
        return $this->findAllModels();
    }

    /**
     * @return \yii\db\ActiveRecord[]
     */
    private function findAllModels()
    {
        $records = Parser::findActive();
        $results = [];
        /** @var $record Parser */
        foreach ($records as $key => $record) {
            $results[$record->lang][$record->type][] = $record;
        }
        return $results;
    }

    /**
     * @param $id
     * @return \yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    private function findModel($id)
    {
        $model = Parser::findOne($id);
        if (null === $model) {
            throw new NotFoundHttpException(Yii::t('api', 'Parser not found'));
        }
        return $model;
    }
}
