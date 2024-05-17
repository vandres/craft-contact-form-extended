<?php

namespace vandres\craftcontactformextended\models;

use craft\base\Model;

class Settings extends Model
{
    public int $secondsSpentOnForm = 0;

    public function defineRules(): array
    {
        return [
            [['secondsSpentOnForm'], 'integer', 'min' => 0],
        ];
    }
}
