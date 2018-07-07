<?php

namespace app\modules\api\v1\resources;

use yii\helpers\ArrayHelper;
use yii2tech\filedb\ActiveRecord;

/**
 * Class Currency
 * @package app\modules\api\v1\resources
 */
class Currency extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function fileName()
    {
        return 'Currency';
    }

    /**
     * @param $q
     * @return array
     */
    public static function findByQueryList($q)
    {
        $currencies = self::find()
            ->andFilterWhere(['LIKE', 'value', $q])
            ->all();

        return ArrayHelper::getColumn($currencies, 'value');
    }
}
