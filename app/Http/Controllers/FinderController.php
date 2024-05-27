<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class FinderController extends Controller
{
  
    public function generateResponse(Request $request)
    {

        $openAIKey = env('OPENAI_API_KEY');

        $prompt = $request->input('message');

        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/chat/completions', 
        [
            'headers' => [
                'Authorization' => 'Bearer '.$openAIKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo-0125',
                'max_tokens' => 100,
                'temperature' => 0.7,
                'messages' => [
                    [
                    "role" => "user",
                    "content" =>$prompt,

                ]
                ],
            ],
        ]);

        $responseData = json_decode($response->getBody(), true);


        $answer = trim($responseData['choices'][0]['message']['content']);



        $followUpQuestions = $this->generateFollowUpQuestions($prompt);

        return response()->json([
            'answer' => $answer,
            'follow_up_questions' => $followUpQuestions,
        ]);
    }

    //using machine learning model to generate the follow up question
    private function generateFollowUpQuestions($prompt)
    {

        $openAIKey = env('OPENAI_API_KEY');

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$openAIKey,
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo-0125',
                'max_tokens' => 50,
                'temperature' => 0.7,
                'n' => 4, 
                'messages' => [
                    [
                    "role" => "user",
                    "content" =>$prompt,

                ]
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);

            $followUpQuestions = [];
            for ($i = 0; $i < 4; $i++) {
                $followUpQuestions[] = array("question"=> trim($responseData['choices'][$i]['message']['content']));
            }
            return $followUpQuestions;
    }


}




