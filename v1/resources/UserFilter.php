<?php

namespace app\modules\api\v1\resources;

/**
 * Class UserFilter
 * @package app\modules\api\v1\resources
 */
class UserFilter extends \app\models\user\UserFilter
{
    /**
     * Return current fields
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'value',
        ];
    }
}
