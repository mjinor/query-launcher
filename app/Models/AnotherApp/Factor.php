<?php

namespace App\Models\AnotherApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    protected $table = "factor";
    protected $connection = "anotherApp";
    public $timestamps = false;

    public function items() {
        return $this->hasMany(FactorItem::class);
    }
}
