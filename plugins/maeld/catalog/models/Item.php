<?php

namespace Maeld\Catalog\Models;

use Winter\Storm\Database\Model;

class Item extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    use \Winter\Storm\Database\Traits\Sortable;

    public $table = 'maeld_catalog_items';

    public $rules = [
        'name'     => 'required',
        'status'   => 'required|in:stock,order,unique',
        'category' => 'required|in:tables,sieges,rangement,chambre,surmesure',
    ];

    protected $fillable = [
        'name', 'category', 'material', 'description', 'status', 'price_mode', 'price_from', 'photo', 'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'price_from' => 'float',
    ];

    public static $statusOptions = [
        'stock'  => 'En stock',
        'order'  => 'Sur commande',
        'unique' => 'Projet unique',
    ];

    public static $categoryOptions = [
        'tables'    => 'Tables',
        'sieges'    => 'Sièges',
        'rangement' => 'Rangement',
        'chambre'   => 'Chambre',
        'surmesure' => 'Sur mesure',
    ];

    public static $priceModeOptions = [
        'from' => 'À partir de',
        'unit' => '/ pièce',
    ];

    public function getStatusOptions(): array
    {
        return self::$statusOptions;
    }

    public function getCategoryOptions(): array
    {
        return self::$categoryOptions;
    }

    public function getPriceModeOptions(): array
    {
        return self::$priceModeOptions;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::$statusOptions[$this->status] ?? $this->status;
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::$categoryOptions[$this->category] ?? $this->category;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
