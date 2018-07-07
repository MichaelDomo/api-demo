<?php

namespace app\modules\api\v1\models;

use Yii;
use app\modules\api\v1\resources\UserSettings;

/**
 * @inheritdoc
 */
class ProjectSearchForm extends \app\forms\ProjectSearchForm
{
    /**
     * @return UserSettings
     */
    public function getSettings()
    {
        if (null === $this->settings) {
            /** @var \app\modules\api\v1\models\ApiUserIdentity $user */
            $user = Yii::$app->user->getIdentity();
            $this->settings = UserSettings::findOne($user->settings_id);
        }

        return $this->settings;
    }

    /**
     * @inheritdoc
     */
    public function build($model)
    {
        return $this->colorFilters(parent::build($model));
    }
}
