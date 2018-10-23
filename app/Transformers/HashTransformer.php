<?php
/**
 * Created by PhpStorm.
 * User: dani
 * Date: 2018.10.23.
 * Time: 17:36
 */

namespace App\Transformers;


use App\Models\Hash;
use Illuminate\Support\Facades\Crypt;
use League\Fractal\TransformerAbstract;

/**
 * Class HashTransformer
 * @package App\Transformers
 */
class HashTransformer extends TransformerAbstract
{

    /**
     * @param Hash $hash
     * @return array
     */
    public function transform(Hash $hash) {
        return [
            'hash' => $hash->hash,
            'secretText' => $hash->secret_text,
            'createdAt' => $hash->created_at->format('c'),
            'expiresAt' => $hash->expires_at->format('c'),
            'remainingViews' => $hash->remaining_views
        ];
    }

}