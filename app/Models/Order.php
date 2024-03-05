<?php

namespace App\Models;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_name',
        'item_id',
        'status',
        'total',
        'note',
        'count',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        if (is_numeric($this->user_id)) {
            return $this->belongsTo(User::class);
        } else {
            return $this->belongsTo(User::class, 'user_id', 'email');
        }
    }
}
