<?php

namespace app\modules\api\v1\models;

use app\modules\api\v1\resources\Profile;
use app\modules\api\v1\resources\UserSettings;
use app\modules\api\base\forms\UpdateFormAbstract;
use Yii;

/**
 * Class ProfileUpdateForm
 * @package app\modules\api\v1\models
 *
 * @property \app\modules\api\v1\resources\Profile $profile
 */
class ProfileUpdateForm extends UpdateFormAbstract
{
    public $settingsId;
    private $_profile;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['settingsId', 'required'],
            ['settingsId', 'integer'],
            ['settingsId', 'validateSettingsId']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'settingsId' => Yii::t('api', 'Settings')
        ];
    }

    /**
     * @param $attribute
     */
    public function validateSettingsId($attribute)
    {
        if (null === ($user = Yii::$app->user) || $this->hasErrors()) {
            return;
        }

        $existSettings = UserSettings::find()
            ->andFilterWhere([
                'id' => $this->settingsId,
                'user_id' => $user->id,
            ])
            ->exists();

        if (!$existSettings) {
            $this->addError($attribute, Yii::t('api', 'Try to change undefined settings'));
        }
    }

    /**
     * @return null
     * @throws \yii\base\InvalidParamException
     */
    public function update()
    {
        if ($this->validate() && ($profile = $this->getProfile())) {
            $profile->settings_id = $this->settingsId;

            return $profile->save() ? $profile : false;
        }

        return false;
    }

    /**
     * @return Profile
     */
    private function getProfile()
    {
        if (null === $this->_profile) {
            $this->_profile = Profile::findOne(Yii::$app->user->id);
        }

        return $this->_profile;
    }
}
