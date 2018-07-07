<?php

namespace app\modules\api\v1\models;

use app\modules\api\v1\resources\UserCode;
use yii\base\Model;

/**
 * Class UserCodeCreateForm
 * @package app\modules\api\v1\models
 *
 * @property \yii\db\ActiveRecord|null $user
 */
class UserCodeCreateForm extends Model
{
    public $email;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('api', 'Email')
        ];
    }

    /**
     * @throws \yii\base\InvalidParamException
     * @return UserCode|null|array
     */
    public function create()
    {
        if ($this->validate() && $this->getUser()) {
            if ($code = $this->getUser()->code) {
                return $code;
            } else {
                $code = new UserCode();
                $code->user_id = $this->getUser()->id;

                return $code->save() ? $code : null;
            }
        }

        return null;
    }

    /**
     * Find user by [[email]]
     * @return ApiUserIdentity|null|array
     */
    protected function getUser()
    {
        if (null === $this->_user) {
            $this->_user = ApiUserIdentity::findIdentityByEmail($this->email);
        }
        return $this->_user;
    }
}
