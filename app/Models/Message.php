<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Message extends Model
{
    public function userFrom() {
        return $this->belongsTo('App\User', 'user_id_from');
    }
    public function userTo() {
        return $this->belongsTo('App\User', 'user_id_to');
    }
}
