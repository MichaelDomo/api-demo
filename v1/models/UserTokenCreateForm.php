<?php

namespace app\modules\api\v1\models;

use app\modules\api\v1\resources\UserToken;
use Yii;
use yii\base\Model;

/**
 * Class UserTokenCreateForm
 * @package app\modules\api\v1\models
 *
 * @property \app\modules\api\v1\models\ApiUserIdentity|\yii\db\ActiveRecord|null $user
 */
class UserTokenCreateForm extends Model
{
    public $code;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['code', 'required'],
            ['code', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('api', 'Code')
        ];
    }

    /**
     * @return UserToken|null
     * @throws \yii\base\InvalidParamException
     */
    public function create()
    {
        if ($this->validate() && $this->getUser()) {
            $token = new UserToken();
            $token->user_id = $this->getUser()->id;
            $token->type = UserToken::TYPE_AUTH;

            return $token->save() ? $token : null;
        }

        return null;
    }

    /**
     * Find user by [[code]]
     *
     * @return ApiUserIdentity|null|\yii\db\ActiveRecord
     */
    protected function getUser()
    {
        if (null === $this->_user) {
            $this->_user = ApiUserIdentity::findIdentityByCode($this->code);
        }
        return $this->_user;
    }
}
