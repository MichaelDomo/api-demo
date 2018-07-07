<?php

namespace app\modules\api\v1\controllers;

use app\modules\api\base\controllers\Controller;
use app\modules\api\v1\resources\Currency;

/**
 * CurrencyController
 */
class CurrencyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['search'] = ['GET'];

        return $verbs;
    }

    /**
     * @return array|null
     */
    public function actionIndex()
    {
        return Currency::find()->all();
    }

    /**
     * @param $q
     * @return array|\yii2tech\filedb\ActiveRecord[]|null
     */
    public function actionSearch($q)
    {
        return Currency::findByQueryList($q);
    }
}
