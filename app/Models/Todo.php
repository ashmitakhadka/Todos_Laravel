<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use SoftDeletes;

    protected $fillable = [
    'user_id',
    'title',
    'description',
    'completed',
    'completed_at',
];

    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

 public function scopeSearch($q, $term)
{
    $q->where(function ($query) use ($term) {
        $query->where('title', 'like', '%' . $term . '%')
              ->orWhere('description', 'like', '%' . $term . '%');
    });

    return $q;
}

public function scopeStatus($q, $status){
    if ($status === 'active') {
          $q->where('completed', false);
       }

    if ($status === 'completed') {
      $q->where('completed', true);
      }
}

public function scopeOrdered($q, $order){
    if($order== 'latest'){
        $q->orderBy('completed_at', 'desc');
    }
     if($order== 'oldest'){
        $q->orderBy('created_at', 'asc');
    }
}
}