<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model{
    use HasFactory;
    protected $fillable=['offer_id','employee_id','message','status','accepted_at'];
    public function offer(){ return $this->belongsTo(Offer::class); }
    public function employee(){ return $this->belongsTo(User::class,'employee_id'); }
}
