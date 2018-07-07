<?php

namespace app\modules\api\base\actions;

use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecordInterface;
use yii\rest\Action;
use yii\web\UnauthorizedHttpException;
use app\modules\api\base\forms\IndexFormAbstract;

/**
 * Class IndexAction
 * @package app\modules\api\base\actions
 */
class IndexAction extends Action
{
    /**
     * @var string class name of the form which will be handled by this action.
     * This property must be set.
     */
    public $formClass;

    /**
     * @var callable a PHP callable that will be called to prepare a data provider that
     *
     * ```php
     * function ($form, $model, $action) {
     *     return new ActiveDataProvider([
     *         'query' => $form->buildQuery($model),
     *         'sort' => [
     *             ...
     *         ]
     *     ]);
     * }
     * ```
     *
     * The callable should return an Component object.
     */
    public $prepareProvider;

    /**
     * @throws UnauthorizedHttpException
     *
     * @return array
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        /** @var \yii\db\ActiveRecord $model */
        $model = Yii::createObject($this->modelClass);

        return $this->prepareProvider($model);
    }

    /**
     * Prepares the data provider that should return the requested collection of the models.
     *
     * @param ActiveRecordInterface $model
     * @throws \yii\base\InvalidParamException
     * @throws InvalidConfigException
     * @return mixed|IndexFormAbstract|ActiveDataProvider
     */
    protected function prepareProvider($model)
    {
        /* @var $form IndexFormAbstract */
        $form = new $this->formClass();
        if (!$form instanceof IndexFormAbstract) {
            throw new InvalidConfigException('Property "formClass" must be implemented "IndexFormAbstract"');
        }

        $form->load(Yii::$app->request->bodyParams, '');

        if (false === $form->validate()) {
            return $form;
        }

        if ($this->prepareProvider !== null) {
            return call_user_func($this->prepareProvider, $form, $model, $this);
        }

        /** @var \yii\db\ActiveRecord $model */
        $model = Yii::createObject($this->modelClass);

        return new ActiveDataProvider([
            'query' => $form->buildQuery($model),
        ]);
    }
}
