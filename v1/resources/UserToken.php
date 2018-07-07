<?php

namespace app\modules\api\v1\resources;

use dektrium\user\models\Token;

/**
 * Class UserToken
 * @package app\modules\api\v1\resources
 */
class UserToken extends Token
{
    /**
     * Return current fields
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'token' => 'code',
        ];
    }
}
