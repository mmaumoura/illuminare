<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageFolder extends Model
{
    protected $fillable = ['nome', 'descricao', 'clinic_id', 'user_id'];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }
}
