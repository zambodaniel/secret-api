<?php

namespace App\Http\Controllers;

use App\Exceptions\HashInputInvalidException;
use App\Exceptions\HashNotFoundOrInvalidException;
use App\Http\ResponseFactory;
use App\Models\Hash;
use App\Transformers\HashTransformer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Nord\Lumen\Fractal\FractalService;

/**
 * Class HashController
 * @package App\Http\Controllers
 */
class HashController extends Controller
{

    /**
     * Store a new secret
     * @param Request $request
     * @param FractalService $fractal
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, FractalService $fractal) {
        try {
            $validatedData = $this->validate($request, [
                'secret' => 'required',
                'expireAfterViews' => 'required|integer|min:1',
                'expireAfter' => 'required|integer'
            ]);
            $validatedData['expireAfter'] = Carbon::now()->addMinutes($validatedData['expireAfter']);
        } catch (ValidationException $validationException) {
            throw new HashInputInvalidException('Invalid input', 405);
        }

        $result = Hash::create([
            'secret_text' => Crypt::encryptString($validatedData['secret']),
            'expires_at' => $validatedData['expireAfter'],
            'remaining_views' => $validatedData['expireAfterViews'],
            'will_expire' => ($request->input('expireAfter') > 0 ? true : false)
        ]);
        return ResponseFactory::make($fractal->item($result, new HashTransformer())->toArray());
    }

    /**
     * Show a secret if found & not expired or exhausted views
     *
     * @param FractalService $fractal
     * @param string $hash
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(FractalService $fractal, string $hash) {
        $result = Hash::where('hash', '=', $hash)
            ->where(function (Builder $q) {
                $q
                    ->where('expires_at', '<', Carbon::now())
                    ->orWhere('will_expire', '=', 0)
                    ->orWhere('remaining_views', '>', 0);
            })
            ->first();
        if (!$result) {
            throw new HashNotFoundOrInvalidException('Secret not found', 404);
        }
        return ResponseFactory::make($fractal->item($result, new HashTransformer())->toArray());
    }


}
