<?php
/**
 * Created by PhpStorm.
 * User: dani
 * Date: 2018.10.23.
 * Time: 16:58
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hash extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'hash', 'secret_text', 'expires_at', 'remaining_views'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];
}