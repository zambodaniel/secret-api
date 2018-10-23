<?php
/**
 * Created by PhpStorm.
 * User: dani
 * Date: 2018.10.23.
 * Time: 16:58
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Class Hash
 * @package App\Models
 *
 * @property integer id
 * @property integer user_id
 * @property string hash
 * @property string secret_text
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon expires_at
 * @property integer remaining_views
 * @property boolean will_expire
 *
 * @property User user
 */
class Hash extends Model
{

    protected $table = 'secrets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'hash', 'secret_text', 'expires_at', 'remaining_views', 'will_expire'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    protected $dates = ['expires_at'];

    /**
     * Model boot
     */
    public static function boot()
    {
        /**
         * Generate uuid on creating event
         */
        static::creating(function (self $model) {
            $model->hash = Uuid::uuid4();
        });

        parent::boot();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}