<?php

namespace app\modules\api\v1\resources;

use dektrium\user\models\Code;

/**
 * Class UserCode
 * @package app\modules\api\v1\resources
 */
class UserCode extends Code
{
    /**
     * Return current fields
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'code',
            'expired_at' => function () {
                return date(DATE_RFC3339, $this->expired_at);
            },
        ];
    }
}
