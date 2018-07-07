<?php

namespace app\modules\api\v1\resources;

use app\models\FreelanceParsers;

/**
 * Class Parser
 * @package app\modules\api\v1\resources
 */
class Parser extends FreelanceParsers
{
    /**
     * Return current fields
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'lang',
            'type',
            'tariff',
            'stat',
            'value' => 'class_name',
            'favicon' => 'faviconUrl',
            'site' => 'site_url',
        ];
    }
}
