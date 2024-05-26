<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use GuzzleHttp\Client;

class FinderController extends Controller
{
    public function generateResponse(Request $request)
    {

        $userInput = $request->input('message');
        $openAIKey = env('OPENAI_API_KEY');

        $textBasedResponse = "As of the latest available data, the United States has the
        highest number of billionaires in the world. According to the Forbes
        Billionaires List, the U.S. consistently tops the list with the most
        Guidelines
        Submission Deadline
        Submissions will be accepted until 11:59 PM on Saturday 25th May, 2024.
        Resources
        individuals having a net worth of at least one billion dollars.";

        // Set up cURL options
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'model' => 'gpt-3.5-turbo-0125',
                'prompt' => $userInput,
                'temperature' => 0.5,
                'max_tokens' => 150,
                'n' => 1,
                'stop' => ['\n']
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $openAIKey,
            ],
        ]);

        // Execute cURL request
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json(['error' => 'Failed to retrieve response from OpenAI API']);
        } else {

            $followupQuestions = [
                [
                    "question"=> "How many billionaires are there in the United States
                    compared to other countries?"
                ],
                [
                "question"=> "What industries are most common among billionaires in
                the United States?"
                ],
                [
                "question"=> "Who is currently the richest billionaire in the world
                and what is their net worth?"
                ],
                [
                "question"=> "How has the number of billionaires changed over the
                past decade in the United States?"
                ]
            ];

            return response()->json([
                'response' => $textBasedResponse,
                'followup_questions' => $followupQuestions
            ]);
        }
     
    }
}