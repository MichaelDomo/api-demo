<?php

namespace app\modules\api\base\forms;

use yii\base\Model;

/**
 * Class UpdateFormAbstract
 * @package app\modules\api\base\forms
 */
abstract class UpdateFormAbstract extends Model
{
    /**
     * Update model.
     *
     * @return \yii\db\ActiveQuery
     */
    abstract public function update();
}
