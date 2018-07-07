<?php

namespace app\modules\api\v1\models;

use dektrium\user\models\User;
use Yii;
use app\modules\api\v1\resources\UserToken;
use app\modules\api\v1\resources\UserCode;
use yii\filters\RateLimitInterface;

/**
 * ApiUserIdentity User identity interface
 *
 * @property \yii\db\ActiveQuery $code
 */
class ApiUserIdentity extends User implements RateLimitInterface
{
    /**
     * @var int
     */
    public $rateWindowSize = 3600;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCode()
    {
        return $this->hasOne(UserCode::className(), ['user_id' => 'id'])
            ->andFilterWhere([
                '>', 'expired_at', time()
            ]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->joinWith('tokens t')
            ->andWhere(['t.code' => $token])
            ->andWhere(['t.type' => UserToken::TYPE_AUTH])
            ->one();
    }

    /**
     * @param $code
     * @return User|null|\yii\db\ActiveRecord
     */
    public static function findIdentityByCode($code)
    {
        return static::find()
            ->joinWith('code c')
            ->andWhere(['c.code' => $code])
            ->andWhere(['>', 'c.expired_at', time()])
            ->one();
    }

    /**
     * @param $email
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findIdentityByEmail($email)
    {
        return static::find()
            ->andWhere([
                'email' => $email,
                'blocked_at' => null,
            ])
            ->one();
    }

    /**
     * Returns the maximum number of allowed requests and the window size.
     * @param \yii\web\Request $request the current request
     * @param \yii\base\Action $action the action to be executed
     * @return array an array of two elements. The first element is the maximum number of allowed requests,
     * and the second element is the size of the window in seconds.
     */
    public function getRateLimit($request, $action)
    {
        return [5000, $this->rateWindowSize];
    }

    /**
     * Loads the number of allowed requests and the corresponding timestamp from a persistent storage.
     * @param \yii\web\Request $request the current request
     * @param \yii\base\Action $action the action to be executed
     * @return array an array of two elements. The first element is the number of allowed requests,
     * and the second element is the corresponding UNIX timestamp.
     */
    public function loadAllowance($request, $action)
    {
        $allowance = Yii::$app->cache->get($this->getCacheKey('api_rate_allowance'));
        $timestamp = Yii::$app->cache->get($this->getCacheKey('api_rate_timestamp'));
        return [$allowance, $timestamp];
    }

    /**
     * Saves the number of allowed requests and the corresponding timestamp to a persistent storage.
     * @param \yii\web\Request $request the current request
     * @param \yii\base\Action $action the action to be executed
     * @param integer $allowance the number of allowed requests remaining.
     * @param integer $timestamp the current timestamp.
     */
    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        Yii::$app->cache->set($this->getCacheKey('api_rate_allowance'), $allowance, $this->rateWindowSize);
        Yii::$app->cache->set($this->getCacheKey('api_rate_timestamp'), $timestamp, $this->rateWindowSize);
    }

    /**
     * @param $key
     * @return array
     */
    public function getCacheKey($key)
    {
        return [__CLASS__, $this->getId(), $key];
    }
}
