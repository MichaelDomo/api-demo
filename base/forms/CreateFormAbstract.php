<?php

namespace app\modules\api\base\forms;

use yii\base\Model;

/**
 * Class CreateFormAbstract
 * @package app\modules\api\base\forms
 */
abstract class CreateFormAbstract extends Model
{
    /**
     * Create model.
     *
     * @return \yii\db\ActiveQuery
     */
    abstract public function create();
}
