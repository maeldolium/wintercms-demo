<?php

namespace Maeld\Compat;

use App;
use Martin\Forms\Classes\Mails\AutoResponse;
use Martin\Forms\Classes\Mails\Notification;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name'        => 'Correctifs de compatibilité',
            'description' => 'Petits correctifs de compatibilité pour des plugins tiers utilisés sur ce projet.',
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
    }
}
