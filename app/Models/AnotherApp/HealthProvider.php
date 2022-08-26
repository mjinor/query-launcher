<?php

namespace App\Models\AnotherApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthProvider extends Model
{
    protected $table = "health_provider";
    protected $connection = "anotherApp";
}
