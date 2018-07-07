<?php

namespace app\modules\api\v1\resources;

/**
 * Class UserBookmark
 * @package app\modules\api\v1\resources
 */
class UserBookmark extends \app\models\user\UserBookmark
{
    /**
     * Return current fields
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'project',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
}
