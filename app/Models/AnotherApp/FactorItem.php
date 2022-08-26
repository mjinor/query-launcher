<?php

namespace App\Models\AnotherApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactorItem extends Model
{
    protected $table = "factor_items";
    protected $connection = "anotherApp";

    public function getTableColumns(){
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function factor() {
        return $this->belongsTo(Factor::class);
    }
}
