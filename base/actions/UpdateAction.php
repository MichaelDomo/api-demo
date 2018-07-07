<?php

namespace app\modules\api\base\actions;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\rest\Action;
use yii\web\ServerErrorHttpException;
use app\modules\api\base\forms\UpdateFormAbstract;

/**
 * Class UpdateAction
 * @package app\modules\api\base\actions
 */
class UpdateAction extends Action
{
    /**
     * @var string class name of the form which will be handled by this action.
     * This property must be set.
     */
    public $formClass;

    /**
     * Updates an existing model.
     * @return bool|Model|\yii\db\ActiveQuery|ActiveRecord
     * @throws \yii\base\InvalidParamException
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException if there is any error when updating the model
     * @internal param string $id the primary key of the model
     */
    public function run()
    {
        /* @var $model Model */
        $form = new $this->formClass;
        if (!$form instanceof UpdateFormAbstract) {
            throw new InvalidConfigException('Property "formClass" must be implemented "UpdateFormAbstract"');
        }

        $form->load(Yii::$app->request->bodyParams, '');

        $validate = Yii::$app->request->get('validate', false);
        if (!$validate) {
            if (($result = $form->update()) === false && !$form->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
        } else {
            $parts = explode(',', $validate);
            $attributeNames = array_intersect($parts, $form->attributes());
            if (empty($attributeNames[0])) {
                $attributeNames = null;
            }
            $form->validate($attributeNames);
        }

        return $result ?: $form;
    }
}
