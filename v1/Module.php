<?php

namespace app\modules\api\v1;

use Yii;
use app\modules\api\v1\models\ApiUserIdentity;

/**
 * Class Module
 * @package app\modules\api\v1
 */
class Module extends \app\modules\api\Module
{
    public $controllerNamespace = 'app\modules\api\v1\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        Yii::$app->user->identityClass = ApiUserIdentity::className();
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;
    }
}
