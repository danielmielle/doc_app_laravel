<?php

namespace App\Models;
// namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'doc_id',
        'category',
        'patients',
        'experience',
        'bio_data',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
