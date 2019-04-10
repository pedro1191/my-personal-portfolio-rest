<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Dingo\Api\Exception\InternalHttpException;
use Illuminate\Support\Facades\Auth;
use Log;
use App\User;

class MessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Tries to send email
        try {
            // Pretend to be authenticated user
            $authUser = Auth::fromUser(User::first());

            $this->api
                ->be($authUser)
                ->post('api/v1/emails/send', $request->only('name', 'email', 'message'));
        } catch (InternalHttpException $e) {
            Log::debug($e->getResponse(), ['file' => __FILE__, 'line' => __LINE__, 'method' => __METHOD__]);
            return $e->getResponse();
        }

        // Everything OK
        return response()->json([
            'message' => 'Your message was sent successfully.',
            'status_code' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
