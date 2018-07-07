<?php

namespace app\modules\api\v1\models;

use app\modules\api\base\forms\CreateFormAbstract;
use app\modules\api\v1\resources\Profile;
use app\modules\api\v1\resources\UserFilter;
use app\modules\api\v1\resources\UserSettings;
use Yii;

/**
 * Class UserFilterCreateForm
 * @package app\modules\api\v1\models
 *
 * @property \app\modules\api\v1\resources\UserSettings $settings
 */
class UserFilterCreateForm extends CreateFormAbstract
{
    public $value;
    private $_settings;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['value', 'required'],
            ['value', 'string', 'max' => 255],
            ['value', 'validateValue'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'value' => Yii::t('api', 'Value')
        ];
    }

    /**
     * @param $attribute
     */
    public function validateValue($attribute)
    {
        if (null === ($settingsId = $this->getSettings()->id) || $this->hasErrors()) {
            return;
        }

        $existFilter = UserFilter::find()
            ->andWhere([
                'settings_id' => $settingsId,
                'value' => $this->value,
            ])
            ->exists();

        if ($existFilter) {
            $this->addError($attribute, Yii::t('api', 'You already have this filter.'));
        }
    }

    /**
     * @return UserFilter|null
     * @throws \yii\base\InvalidParamException
     */
    public function create()
    {
        if ($this->validate() && $this->getSettings()) {
            $model = new UserFilter();
            $model->settings_id = $this->getSettings()->id;
            $model->value = $this->value;

            return $model->save() ? $model : null;
        }

        return null;
    }

    /**
     * @return UserSettings
     */
    public function getSettings()
    {
        if (null === $this->_settings) {
            /** @var Profile $user */
            $user = Yii::$app->user->getIdentity();
            $this->_settings = UserSettings::findOne($user->settings_id);
        }

        return $this->_settings;
    }
}
