<?php

namespace Maeld\Compat;

use App;
use Event;
use Martin\Forms\Classes\MagicForm;
use Martin\Forms\Classes\Mails\AutoResponse;
use Martin\Forms\Classes\Mails\Notification;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    /**
     * Honeypot fields rendered off-screen in the contact form. Humans never see them,
     * so any submission where one of them is filled in comes from a bot.
     */
    protected const HONEYPOT_FIELDS = ['company_url', 'middle_name'];

    public function pluginDetails(): array
    {
        return [
            'name'        => 'Correctifs de compatibilité',
            'description' => 'Petits correctifs de compatibilité et protection anti-spam pour des plugins tiers utilisés sur ce projet.',
            'author'      => 'Atelier Dumont',
            'icon'        => 'icon-wrench',
        ];
    }

    /**
     * Martin.Forms builds its mail classes via App::makeWith() with a positional
     * (numerically indexed) parameters array, but Laravel's container only resolves
     * makeWith() parameters by name. On this Laravel version that throws an
     * "Unresolvable dependency" error, so the container bindings below construct
     * the classes manually from that same positional array.
     */
    public function boot(): void
    {
        App::bind(Notification::class, function ($app, $params) {
            return new Notification($params[0], $params[1], $params[2], $params[3]);
        });

        App::bind(AutoResponse::class, function ($app, $params) {
            return new AutoResponse($params[0], $params[1], $params[2]);
        });

        $this->registerHoneypot();
    }

    /**
     * Intercepts Martin.Forms submissions before they are handled: when a honeypot
     * field is filled in, nothing is saved or mailed, but the usual success message
     * is returned so the bot has no signal that it was caught.
     */
    protected function registerHoneypot(): void
    {
        Event::listen('cms.component.beforeRunAjaxHandler', function ($component, $handler) {
            if (!$component instanceof MagicForm || $handler !== 'onFormSubmit') {
                return;
            }

            $isBot = collect(self::HONEYPOT_FIELDS)->contains(fn ($field) => filled(post($field)));
            if (!$isBot) {
                return;
            }

            return ['#' . $component->alias . '_forms_flash' => $component->renderPartial(
                $component->property('messages_partial', '@flash.htm'),
                [
                    'status'  => 'success',
                    'type'    => 'success',
                    'content' => $component->property('messages_success'),
                ]
            )];
        });
    }
}
