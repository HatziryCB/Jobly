<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model {
    use HasFactory;
    protected $fillable = ['employer_id','title','description','location_text','pay_min','pay_max','status','lat','lng'];
    public function employer() { return $this->belongsTo(User::class,'employer_id'); }
}
