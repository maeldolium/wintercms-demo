<?php

namespace Maeld\Catalog;

use Backend\Facades\Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name'        => 'Catalogue',
            'description' => 'Gestion des meubles du catalogue de l\'Atelier Dumont.',
            'author'      => 'Atelier Dumont',
            'icon'        => 'icon-th-large',
        ];
    }

    public function registerComponents(): array
    {
        return [
            \Maeld\Catalog\Components\Items::class => 'catalogItems',
        ];
    }

    public function registerNavigation(): array
    {
        return [
            'catalog' => [
                'label' => 'Catalogue',
                'url'   => Backend::url('maeld/catalog/items'),
                'icon'  => 'icon-th-large',
                'order' => 400,

                'sideMenu' => [
                    'new_item' => [
                        'label' => 'Ajouter un meuble',
                        'icon'  => 'icon-plus',
                        'url'   => Backend::url('maeld/catalog/items/create'),
                    ],
                    'items' => [
                        'label' => 'Meubles',
                        'icon'  => 'icon-cubes',
                        'url'   => Backend::url('maeld/catalog/items'),
                    ],
                    'reorder' => [
                        'label' => 'Réorganiser',
                        'icon'  => 'icon-sort',
                        'url'   => Backend::url('maeld/catalog/items/reorder'),
                    ],
                ],
            ],
        ];
    }

    public function registerSettings(): array
    {
        return [
            'settings' => [
                'label'       => 'Catalogue',
                'description' => 'Bouton de contact affiché sur chaque meuble du catalogue.',
                'category'    => 'Atelier Dumont',
                'icon'        => 'icon-th-large',
                'class'       => \Maeld\Catalog\Models\Settings::class,
                'order'       => 600,
                'keywords'    => 'catalogue meuble contact',
            ],
        ];
    }
}
