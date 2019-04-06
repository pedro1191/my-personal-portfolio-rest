<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Dingo\Api\Exception\InternalHttpException;
use Log;

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
            $this->api->post('api/v1/emails/send', $request->only('name', 'email', 'message'));
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
