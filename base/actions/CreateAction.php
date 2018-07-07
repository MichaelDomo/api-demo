<?php

namespace app\modules\api\base\actions;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\rest\Action;
use yii\web\ServerErrorHttpException;
use app\modules\api\base\forms\CreateFormAbstract;

/**
 * Class CreateAction
 * @package app\modules\api\base\actions
 */
class CreateAction extends Action
{
    /**
     * @var string the name of the view action. This property is need to create the URL when the model is successfully created.
     */
    public $viewAction = 'view';

    /**
     * @var string class name of the form which will be handled by this action.
     * This property must be set.
     */
    public $formClass;

    /**
     * Creates a new model.
     * @return bool|Model|ActiveRecord|\yii\web\HeaderCollection if there is any error when creating the model
     * @throws \yii\base\InvalidParamException
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException if there is any error when creating the model
     */
    public function run()
    {
        /* @var $form Model */
        $form = new $this->formClass;
        if (!$form instanceof CreateFormAbstract) {
            throw new InvalidConfigException('Property "formClass" must be implemented "CreateFormAbstract"');
        }

        $form->load(\Yii::$app->request->bodyParams, '');

        $validate = Yii::$app->request->get('validate', false);
        if (!$validate) {
            /* @var $result ActiveRecord */
            if ($result = $form->create()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                $id = implode(',', array_values($result->getPrimaryKey(true)));
                return $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
            } elseif (!$form->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
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
