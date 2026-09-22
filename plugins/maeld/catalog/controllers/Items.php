<?php

namespace Maeld\Catalog\Controllers;

use Backend\Classes\Controller;

class Items extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\ReorderController::class,
    ];
}
