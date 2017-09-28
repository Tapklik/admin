<?php namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Response;
use Lcobucci\JWT\Parser;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(str_contains($request->getUri(), 'token') ||  str_contains($request->getUri(), 'logout')) return $next
        ($request);

        $needsToLogIn = (!$request->session()->get('token')) ? true : false;

        if ($needsToLogIn == true && str_contains($request->getUri(), 'auth') != true) {
            return redirect('/auth');
        } else {
            // Check user is admin
            if(!$this->_checkIfUserIsAdmin($request->session()->get('token')))
            {
                return response()->json(
                    [
                        'error' => [
                            'code'    => Response::HTTP_FORBIDDEN,
                            'message' => 'Forbidden. You should not be here. Logged.',
                            'request' => md5(rand(999, 9999)).'.'.sha1(Carbon::now()),
                        ],
                    ], Response::HTTP_UNAUTHORIZED
                );

                return redirect('/auth');
            }

            return $next($request);
        }
    }

    private function _checkIfUserIsAdmin($token)
    {

        try {

            $payload = (new Parser())->parse((string)$token);

            return ($payload->getClaim('role') == 1) ? true : false;
        } catch (\Exception $e) {

            return response()->json(
                [
                    'error' => [
                        'code'    => Response::HTTP_FORBIDDEN,
                        'message' => 'Forbidden',
                        'request' => md5(rand(999, 9999)).'.'.sha1(Carbon::now()),
                    ],
                ], Response::HTTP_UNAUTHORIZED
            );
        }
    }
}
