<?php

namespace app\modules\api\base\actions;

use app\forms\base\SearchFormAbstract;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\rest\Action;

/**
 * Class SearchAction
 * @package app\modules\api\base\actions
 */
class SearchAction extends Action
{
    /**
     * @var string class name of the form which will be handled by this action.
     * This property must be set.
     */
    public $formClass;

    /**
     * Prepares the data provider that should return the requested collection of the models.
     * @return SearchFormAbstract|mixed|ActiveDataProvider
     * @throws \yii\base\InvalidParamException
     * @throws InvalidConfigException
     * @internal param ActiveRecordInterface $model
     */
    protected function run()
    {
        /* @var $form SearchFormAbstract */
        $form = new $this->formClass();
        if (!$form instanceof SearchFormAbstract) {
            throw new InvalidConfigException('Property "formClass" must be implemented "SearchFormAbstract"');
        }

        $form->load(\Yii::$app->request->bodyParams, '');

        if (false === $form->validate()) {
            return $form;
        }

        return $form->build(Yii::createObject($this->modelClass));
    }
}
