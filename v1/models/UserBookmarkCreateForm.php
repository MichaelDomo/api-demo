<?php

namespace app\modules\api\v1\models;

use app\modules\api\base\forms\CreateFormAbstract;
use app\modules\api\v1\resources\Profile;
use app\modules\api\v1\resources\Project;
use app\modules\api\v1\resources\UserBookmark;
use Yii;

/**
 * Class UserBookmarkCreateForm
 * @package app\modules\api\v1\models
 *
 * @property \app\modules\api\v1\resources\UserSettings $settings
 */
class UserBookmarkCreateForm extends CreateFormAbstract
{
    public $projectId;
    private $user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['projectId', 'required'],
            [
                'projectId',
                'exist',
                'targetClass' => Project::className(),
                'targetAttribute' => 'id',
            ],
            ['projectId', 'validateUnique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'projectId' => Yii::t('api', 'Project')
        ];
    }

    /**
     * @param $attribute
     */
    public function validateUnique($attribute)
    {
        if (null === ($user = $this->getUser()) || $this->hasErrors()) {
            return;
        }

        $existBookmark = UserBookmark::find()
            ->andWhere([
                'user_id' => $user->id,
                'project_id' => $this->projectId,
            ])
            ->exists();

        if ($existBookmark) {
            $this->addError($attribute, Yii::t('api', 'You already have this bookmark.'));
        }
    }

    /**
     * @return UserBookmark|null
     * @throws \yii\base\InvalidParamException
     */
    public function create()
    {
        if ($this->validate() && $this->getUser()) {
            $model = new UserBookmark();
            $model->user_id = $this->getUser()->id;
            $model->project_id = $this->projectId;

            return $model->save() ? $model : null;
        }

        return null;
    }

    /**
     * @return Profile
     */
    public function getUser()
    {
        if (null === $this->user) {
            $this->user = Profile::findOne(Yii::$app->user->getId());
        }

        return $this->user;
    }
}
