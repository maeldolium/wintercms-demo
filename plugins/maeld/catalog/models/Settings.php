<?php

namespace Maeld\Catalog\Models;

use Winter\Storm\Database\Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'maeld_catalog_settings';

    public $settingsFields = 'fields.yaml';
}
