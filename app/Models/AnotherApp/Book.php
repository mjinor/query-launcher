<?php

namespace App\Models\AnotherApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    const CENTER = 'a_id';

    protected $table = "book";
    protected $connection = "anotherApp";
    public $timestamps = false;

    public function getTableColumns(){
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function scopeSelectRefundsByRefId($query,$params) {
        return $query->findByRefId($params[0])->with('factorItems');
    }

    public function scopeFindByRefId($query,$params) {
        return $query->where('ref_id',$params[0]);
    }

    public function factorItems() {
        return $this->hasMany(FactorItem::class,'type_id');
    }
}
