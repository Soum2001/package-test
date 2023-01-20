<?php

namespace Soumyaa\Openai;

class Openai
{
    public function completion($api = "")
    {
        $apiKey = "$api";
        $data = [
            'prompt' => 'What is the capital of odisha',
        ];
        $url = "https://api.openai.com/v1/engines/text-davinci-002/completions";
        $type = "POST";
        return $this->callOpenAI($data, $url, $type, $apiKey);
    }
    public function fineTune($api = "")
    {
        $apiKey = "$api";
        $data = [
            "model" => "curie",
            "prompt" => "Overjoyed with the new iPhone! ->",
            //"completion"=>" positive",
            "max_tokens" => 1,

        ];
        $url = "https://api.openai.com/v1/completions";
        $type = "POST";
        return $this->callOpenAI($data, $url, $type, $apiKey);
    }
    public function edit($api = "")
    {
        $apiKey = "$api";
        $data = [
            "model" => "text-davinci-edit-001",
            "input" => "What day of the wek is it?",
            "instruction" => "Fix the spelling mistakes",
        ];
        $url = "https://api.openai.com/v1/edits";
        $type = "POST";
        return $this->callOpenAI($data, $url, $type, $apiKey);
    }
    public function embeddings($api = "")
    {
        $apiKey = "$api";
        $data = [
            "model" => "text-embedding-ada-002",
            "input" => "The food was delicious and the waiter...",
            "instruction" => "Fix the spelling mistakes",
        ];
        $url = "https://api.openai.com/v1/embeddings";
        $type = "POST";
        return $this->callOpenAI($data, $url, $type, $apiKey);
    }
    public function moderation($api = "")
    {
        $apiKey = "$api";
        $data = [
            "input" => "I want to kill them.",
        ];

        $url = "https://api.openai.com/v1/moderations";
        $type = "POST";
        return $this->callOpenAI($data, $url, $type, $apiKey);
    }
    public function engines($api = "")
    {
        $apiKey = "$api";
        $data = [];
        $url = "https://api.openai.com/v1/engines";
        $type = "GET";
        return $this->callOpenAI($data, $url, $type, $apiKey);
    }

    public function callOpenAI($data, $url, $type, $apiKey)
    {
        if ($type == "POST") {
            $url = $url;
            $prompt = "What is the capital of odisha";

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $type,
                CURLOPT_POSTFIELDS => json_encode([$data]),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer $apiKey"
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $response_data = json_decode($response, true);
            print_r($response_data);
            $embeddings = $response_data['choices'][0]['text'];
            return $embeddings;
        } else {
            $url = $url;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $type,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer $apiKey"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $response_data = json_decode($response, true);
            print_r($response_data);
            $embeddings = $response_data['choices'][0]['text'];
            return $embeddings;
        }
    }
}
