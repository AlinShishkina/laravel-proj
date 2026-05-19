<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiRecord extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'name', 'description', 'active', 'crew_capacity', 'api_response'];
}