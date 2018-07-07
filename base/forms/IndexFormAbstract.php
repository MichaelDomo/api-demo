<?php

namespace app\modules\api\base\forms;

use yii\base\Model;

/**
 * Class IndexFormAbstract
 * @package app\modules\api\base\forms
 */
abstract class IndexFormAbstract extends Model
{
    /**
     * Query building.
     *
     * @param \yii\db\ActiveRecord $model
     *
     * @return \yii\db\ActiveQuery
     */
    abstract public function buildQuery($model);
}
