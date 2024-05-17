<?php

namespace vandres\craftcontactformextended\models;

use craft\base\Model;

class Settings extends Model
{
    public int $secondsSpentOnFormThreshold = 0;

    public function defineRules(): array
    {
        return [
            [['secondsSpentOnFormThreshold'], 'integer', 'min' => 0],
        ];
    }
}
