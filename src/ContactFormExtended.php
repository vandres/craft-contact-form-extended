<?php

namespace vandres\craftcontactformextended;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\contactform\events\SendEvent;
use craft\contactform\Mailer;
use craft\web\twig\variables\CraftVariable;
use vandres\craftcontactformextended\models\Settings;
use vandres\craftcontactformextended\services\FormService;
use vandres\craftcontactformextended\variables\FormVariable;
use yii\base\Event;

/**
 * Contact Form Extended plugin
 *
 * @method static ContactFormExtended getInstance()
 * @method Settings getSettings()
 * @author Volker Andres <andres@voan.ch>
 * @copyright Volker Andres
 * @license https://craftcms.github.io/license/ Craft License
 */
class ContactFormExtended extends Plugin
{
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = true;

    public static function config(): array
    {
        return [
            'components' => [
                'formService' => FormService::class,
            ],
        ];
    }

    public function init(): void
    {
        parent::init();

        $this->setUp();
        $this->setUpSite();
        $this->setUpCp();
    }

    // TODO should log be written
    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    protected function settingsHtml(): ?string
    {
        // Get and pre-validate the settings
        $settings = $this->getSettings();
        $settings->validate();

        // Get the settings that are being defined by the config file
        $overrides = Craft::$app->getConfig()->getConfigFromFile(strtolower($this->handle));

        return Craft::$app->view->renderTemplate('contact-form-extended/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
            'overrides' => array_keys($overrides),
        ]);
    }

    private function setUp()
    {
        Craft::$app->onInit(function () {
        });
    }

    private function setUpSite()
    {
        Craft::$app->onInit(function () {
            if (!Craft::$app->getRequest()->getIsSiteRequest()) {
                return;
            }

            $this->initMailHook();
        });
    }

    private function setUpCp()
    {
        Craft::$app->onInit(function () {
            if (!Craft::$app->getRequest()->getIsCpRequest()) {
                return;
            }
        });
    }

    private function initMailHook()
    {
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('form', [
                    'class' => FormVariable::class,
                ]);
            }
        );

        if (!class_exists(Mailer::class)) {
            return;
        }

        Event::on(
            Mailer::class,
            Mailer::EVENT_BEFORE_SEND,
            function (SendEvent $event) {
                try {
                    $this->formService->checkSubmission();
                } catch (\Exception $error) {
                    // TODO write log
                    Craft::warning($error->getMessage());
                    $event->isSpam = true;
                }
            }
        );
    }
}
