<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = [
        'sum',
        'type',
        'transaction_type',
        'company_id',
        'comment',
    ];

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class)->withPivot('price', 'count');;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'domain');
    }
}
