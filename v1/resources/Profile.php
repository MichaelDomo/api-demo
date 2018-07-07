<?php

namespace app\modules\api\v1\resources;

use app\modules\api\v1\models\ApiUserIdentity;

/**
 * Class Profile
 *
 * @package app\modules\api\v1\resources
 *
 * @property UserSettings $settings
 * @property UserSettings[] $settingsList
 * @property UserFilter[] $filters
 * @property UserBookmark[] $bookmarks
 */
class Profile extends ApiUserIdentity
{
    /**
     * Return current fields
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'settings_id',
            'email',
            'username',
            'isAdmin',
            'isPro',
            'settings',
            'bookmarks',
            'settingsList',
        ];
    }

    /**
     * @return UserBookmark[]|null
     */
    public function getBookmarks()
    {
        return $this->hasMany(UserBookmark::className(), ['user_id' => 'id']);
    }

    /**
     * @return UserSettings|null
     */
    public function getSettings()
    {
        return $this->hasOne(UserSettings::className(), ['id' => 'settings_id']);
    }

    /**
     * @return UserSettings[]|null
     */
    public function getSettingsList()
    {
        return $this->hasMany(UserSettings::className(), ['user_id' => 'id']);
    }
}
