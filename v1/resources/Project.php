<?php

namespace app\modules\api\v1\resources;

use app\models\FreelanceProjects;
use Yii;

/**
 * Class Project
 * @package app\modules\api\v1\resources
 *
 * @property bool|float|int $newPrice
 * @property mixed isUserBookmark
 */
class Project extends FreelanceProjects
{
    /**
     * Project constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        if (!Yii::$app->user->isGuest) {
            /** @var Profile $user */
            $user = Yii::$app->user->getIdentity();
            if ($currency = $user->currentSettings->currency) {
                $this->setNewCurrency($currency);
            }
        }
        parent::__construct($config);
    }

    /**
     * Return current fields
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'title',
            'description',
            'link',
            'date' => function () {
                return date('Y-m-d', strtotime($this->date . ' UTC'));
            },
            'time' => function () {
                return date('H:i', strtotime($this->date . ' UTC'));
            },
            'price' => function () {
                return (integer) $this->getPrice();
            },
            'currency' => function () {
                return $this->getCurrency();
            },
            'isBookmark' => function () {
                return $this->isUserBookmark !== null;
            },
            'parser' => 'parserModel',
        ];
    }

    /**
     * @return UserBookmark|null|\yii\db\ActiveRecord
     */
    public function getIsUserBookmark()
    {
        return $this->hasOne(UserBookmark::class, ['project_id' => 'id'])
            ->andWhere([
                'user_bookmark.user_id' => Yii::$app->user->getId()
            ])
            ->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParserModel()
    {
        return $this->hasOne(Parser::className(), ['class_name' => 'parser']);
    }
}
