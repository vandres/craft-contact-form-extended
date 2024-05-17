<?php

namespace vandres\craftcontactformextended\services;

use Craft;
use vandres\craftcontactformextended\ContactFormExtended;

class FormService
{
    const SESSION_KEY = 'ContactFormExtendedSessionKey';

    public function prepareSubmission(): void
    {
        Craft::$app->getSession()->set(self::SESSION_KEY . ContactFormExtended::getInstance()->schemaVersion, time());
    }

    public function checkSubmission(): void
    {
        $settings = ContactFormExtended::getInstance()->getSettings();
        if ($settings->secondsSpentOnFormThreshold <= 0) {
            $this->reset();
            return;
        }

        $start = Craft::$app->getSession()->get(self::SESSION_KEY . ContactFormExtended::getInstance()->schemaVersion);

        if (!$start) {
            // no session set, no entry over the form itself
            $this->reset();
            throw new \InvalidArgumentException('User has not seen the form before submission.');
        }

        $duration = time() - $start;
        if ($duration < $settings->secondsSpentOnFormThreshold) {
            // seen form shorter than the threshold
            $this->reset();
            throw new \InvalidArgumentException('User has not seen the form long enough.');
        }

        $this->reset();
    }

    public function logSpam($message, $submission)
    {
        $settings = ContactFormExtended::getInstance()->getSettings();
        if (!$settings->logSpam) {
            return;
        }

        Craft::error($message . "\n" . print_r($submission->attributes, true), 'contact-form-extended');
    }

    public function logAll($message, $submission)
    {
        $settings = ContactFormExtended::getInstance()->getSettings();
        if (!$settings->logAll) {
            return;
        }

        Craft::info($message . "\n" . print_r($submission->attributes, true), 'contact-form-extended');
    }

    private function reset(): void
    {
        Craft::$app->getSession()->remove(self::SESSION_KEY . ContactFormExtended::getInstance()->schemaVersion);
    }
}
