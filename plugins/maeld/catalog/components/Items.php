<?php

namespace Maeld\Catalog\Components;

use Cms\Classes\ComponentBase;
use Maeld\Catalog\Models\Item;
use Maeld\Catalog\Models\Settings as CatalogSettings;

class Items extends ComponentBase
{
    public $items;

    public $categoryOptions;

    public $contactButtonText;

    public $contactButtonUrl;

    public $ctaLabel;

    public $ctaTitle;

    public $ctaText;

    public $ctaButtonText;

    public $ctaButtonUrl;

    public function componentDetails(): array
    {
        return [
            'name'        => 'Meubles du catalogue',
            'description' => 'Affiche les meubles actifs du catalogue, avec filtres par catégorie.',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'label' => [
                'title'   => 'Label',
                'default' => '',
            ],
            'title' => [
                'title'   => 'Titre',
                'default' => '',
            ],
            'intro' => [
                'title'   => 'Introduction',
                'default' => '',
            ],
        ];
    }

    public function onRun()
    {
        $this->items = Item::active()->get();
        $this->categoryOptions = Item::$categoryOptions;

        $this->contactButtonText = CatalogSettings::get('contact_button_text', 'Nous contacter');
        $this->contactButtonUrl = CatalogSettings::get('contact_button_url', '/contact-devis');

        $this->ctaLabel = CatalogSettings::get('cta_label', "Vous ne trouvez pas ce qu'il vous faut ?");
        $this->ctaTitle = CatalogSettings::get('cta_title', 'Nous construisons selon vos spécifications.');
        $this->ctaText = CatalogSettings::get('cta_text', "Décrivez votre projet et nous organiserons une consultation. Aucun plan n'est nécessaire pour commencer.");
        $this->ctaButtonText = CatalogSettings::get('cta_button_text', 'Lancer une commande');
        $this->ctaButtonUrl = CatalogSettings::get('cta_button_url', '/contact-devis');
    }
}
