<?php

namespace app\modules\api\v1\resources;

/**
 * @inheritdoc
 */
class UserSettings extends \app\models\user\UserSettings
{
    /**
     * Return current fields
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'name',
            'description',
            'currency',
            'currency_value_from',
            'currency_value_to',
            'show_price',
            'search_title',
            'search_description',
            'show_description',
            'sound_notification',
            'parsers' => function () {
                return $this->parsers ?: '{}';
            },
            'filters'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilters()
    {
        return $this->hasMany(UserFilter::className(), ['settings_id' => 'id']);
    }
}
