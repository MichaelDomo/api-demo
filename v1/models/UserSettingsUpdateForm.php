<?php

namespace app\modules\api\v1\models;

use app\modules\api\v1\resources\Currency;
use app\modules\api\v1\resources\Profile;
use app\modules\api\v1\resources\UserSettings;
use paulzi\jsonBehavior\JsonValidator;
use app\modules\api\base\forms\UpdateFormAbstract;
use Yii;

/**
 * Class UserSettingsUpdateForm
 * @package app\modules\api\v1\models
 *
 * @property \app\modules\api\v1\resources\UserSettings $settings
 */
class UserSettingsUpdateForm extends UpdateFormAbstract
{
    public $name;
    public $parsers;
    public $currency;
    public $valueFrom;
    public $valueTo;
    public $showPrice;
    public $searchTitle;
    public $searchDescription;
    public $showDescription;
    public $soundNotification;

    private $settings;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'string'],
            [['valueFrom', 'valueTo'], 'integer'],
            [
                [
                    'showPrice',
                    'searchTitle',
                    'searchDescription',
                    'showDescription',
                    'soundNotification',
                ], 'boolean'
            ],
            [
                'currency',
                'exist',
                'targetClass' => Currency::class,
                'targetAttribute' => 'value',
            ],
            ['parsers', JsonValidator::className()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('api', 'Name'),
            'parsers' => Yii::t('api', 'Parsers'),
            'currency' => Yii::t('api', 'Currency'),
            'valueFrom' => Yii::t('api', 'Value from'),
            'valueTo' => Yii::t('api', 'Value to'),
            'showPrice' => Yii::t('api', 'Show price'),
            'searchTitle' => Yii::t('api', 'Search in title'),
            'searchDescription' => Yii::t('api', 'Search in description'),
            'showDescription' => Yii::t('api', 'Show description'),
            'soundNotification' => Yii::t('api', 'Sound notifications'),
        ];
    }

    /**
     * @return null
     * @throws \yii\base\InvalidParamException
     */
    public function update()
    {
        if ($this->validate() && ($settings = $this->getSettings())) {
            $settings->name = $this->name;
            $settings->parsers = $this->parsers;
            $settings->currency = $this->currency;
            $settings->currency_value_from = $this->valueFrom;
            $settings->currency_value_to = $this->valueTo;
            $settings->show_price = $this->showPrice;
            $settings->search_title = $this->searchTitle;
            $settings->search_description = $this->searchDescription;
            $settings->show_description = $this->showDescription;
            $settings->sound_notification = $this->soundNotification;

            return $settings->save() ? $settings : false;
        }

        return false;
    }

    /**
     * @return UserSettings
     */
    public function getSettings()
    {
        if (null === $this->settings) {
            /** @var Profile $user */
            $user = Yii::$app->user->getIdentity();
            $this->settings = UserSettings::findOne($user->settings_id);
        }

        return $this->settings;
    }
}
