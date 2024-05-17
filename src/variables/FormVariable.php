<?php

namespace vandres\craftcontactformextended\variables;

use vandres\craftcontactformextended\ContactFormExtended;
use vandres\craftcontactformextended\services\FormService;

class FormVariable
{
    public function getService(): FormService {
        return ContactFormExtended::getInstance()->formService;
    }
}
