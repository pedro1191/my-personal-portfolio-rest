<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Log;

class EmailController extends Controller
{
    /**
     * Send an email
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        // User input validation
        $this->validate($request, [
            'name' => ['required', 'min:1', 'max:100'],
            'email' => ['required', 'email', 'min:1', 'max:100'],
            'message' => ['required', 'min:1', 'max:3000'],
        ]);

        $messageData = $request->only('name', 'email', 'message');
        $emailContent = $this->buildEmailContent($messageData);

        Mail::raw(null, function ($message) use ($emailContent) {
            $message->subject('Contact from Portfolio');
            $message->to(env('MAIL_USERNAME'));
            $message->setBody($emailContent, 'text/html');
        });

        $messageSender = $this->formatMessageSender($messageData);
        $infoMessage = 'Email from ' . $messageSender . ' has been sent...';
        Log::info($infoMessage, ['file' => __FILE__, 'line' => __LINE__, 'method' => __METHOD__]);

        return response()->json([
            'message' => 'Email sent successfully.',
            'status_code' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    /**
     * Build the email content in html format
     * 
     * @param array $messageData
     * @return string
     */
    private function buildEmailContent(array $messageData)
    {
        $emailContent = '<p><strong>Guest ' . $this->formatMessageSender($messageData) . ' sent the following message</strong></p>';
        $emailContent .= '<p>' . $messageData['message'] . '</p>';

        return $emailContent;
    }

    /**
     * Extract and format the message sender
     * 
     * @param array $messageData
     * @return string
     */
    private function formatMessageSender(array $messageData)
    {
        return '"' . $messageData['name'] . '", "' . $messageData['email'] . '"';
    }
}
