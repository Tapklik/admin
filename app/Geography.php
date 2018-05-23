<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Geography extends Model
{
    public function country() {

        return $this->belongsTo(Country::class);
    }
}
