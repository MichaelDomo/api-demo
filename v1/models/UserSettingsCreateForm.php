<?php

namespace app\modules\api\v1\models;

use app\modules\api\base\forms\CreateFormAbstract;
use app\modules\api\v1\resources\UserSettings;
use Yii;
use yii\web\ServerErrorHttpException;

/**
 * Class UserSettingsCreateForm
 * @package app\modules\api\v1\models
 *
 * @property \yii\web\User $user
 */
class UserSettingsCreateForm extends CreateFormAbstract
{
    public $name;
    public $description;

    private $user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'trim'],
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['description', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('api', 'Name'),
            'description' => Yii::t('api', 'Description'),
        ];
    }

    /**
     * @return UserSettings
     * @throws ServerErrorHttpException
     */
    public function create()
    {
        if ($this->getUser()) {
            $model = new UserSettings();
            $model->name = $this->name;
            $model->description = $this->description;
            $model->user_id = $this->getUser()->id;

            return $model->save() ? $model : null;
        }

        return null;
    }

    /**
     * @return \yii\web\User
     */
    public function getUser()
    {
        if (null === $this->user) {
            $this->user = Yii::$app->user;
        }

        return $this->user;
    }
}
