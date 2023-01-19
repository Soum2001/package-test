<?php
namespace Soumyaa\Openai;

class Openai
{
    public function greet($greet = "Hello World")
    {
        return $greet;
    }
    
        /**
         * @Route("/openai", name="app_openai")
         */
        public function completion($api="")
        {
            $apiKey = "$api";
            $data = [
                'prompt' => 'What is the capital of odisha',
            ];
            $content_type = [
                "Content-Type: application/json",
                "Authorization: Bearer $apiKey"
            ];
            $url = "https://api.openai.com/v1/engines/text-davinci-002/completions";
            $type= "POST";
            return $this->callOpenAI($data, $url, $content_type,$type,$apiKey);
        }
        public function fineTune($api="")
        {
            $apiKey = "$api";
            $data = [
                "model" => "curie",
                "prompt"=>"Overjoyed with the new iPhone! ->", 
                //"completion"=>" positive",
                "max_tokens"=> 1,
               
            ];
            $content_type = [
                "Content-Type: application/json",
                "Authorization: Bearer $apiKey"
            ];
            $url = "https://api.openai.com/v1/completions";
            $type= "POST";
            return $this->callOpenAI($data, $url, $content_type,$type,$apiKey);
        }
        public function edit($api="")
        {
            $apiKey = "$api";
            $data = [
                "model" => "text-davinci-edit-001",
                "input" => "What day of the wek is it?",
                "instruction" => "Fix the spelling mistakes",
            ];
            $content_type = [
                "Content-Type: application/json",
                "Authorization: Bearer $apiKey"
            ];
            $url = "https://api.openai.com/v1/edits";
            $type= "POST";
            return $this->callOpenAI($data, $url,$content_type,$type,$apiKey);
        }
        public function embeddings($api="")
        {
            $apiKey = "$api";
            $data = [
                "model" => "text-embedding-ada-002",
                "input" => "The food was delicious and the waiter...",
                "instruction" => "Fix the spelling mistakes",
            ];
            $content_type = [
                "Content-Type"=> "application/json",
                "Authorization"=> "Bearer $apiKey"
            ];
            $url = "https://api.openai.com/v1/embeddings";
            $type= "POST";
            return $this->callOpenAI($data, $url, $content_type,$type,$apiKey);
        }
        public function files($api="")
        {
            $apiKey = "$api";
            $data = [
              
                    "id"=> "file-ccdDZrC3iZVNiQVeEA6Z66wf",
                    "object"=> "file",
                    "bytes"=> 175,
                    "created_at"=> 1613677385,
                    "filename"=> "train.jsonl",
                    "purpose"=> "search",
             
              
                  "object"=> "list"
            ];
            $content_type = [
                "Content-Type"=> "application/json",
                "Authorization"=> "Bearer $apiKey"
            ];
            $url = "https://api.openai.com/v1/files";
            $type= "GET";
            return $this->callOpenAI($data, $url, $content_type,$type,$apiKey);
        }
        public function moderation($api="")
        {
            $apiKey = "$api";
            $data = [
                "id"=> "modr-5MWoLO",
                "model"=> "text-moderation-001",
                "input"=> "I want to kill them.",
                "results"=> [
                   
                      "categories"=> [
                        "hate"=> false,
                        "hate/threatening"=> true,
                        "self-harm"=> false,
                        "sexual"=> false,
                        "sexual/minors"=> false,
                        "violence"=> true,
                        "violence/graphic"=> false
                    ],
                      "category_scores"=> [
                        "hate"=> 0.22714105248451233,
                        "hate/threatening"=> 0.4132447838783264,
                        "self-harm"=> 0.005232391878962517,
                        "sexual"=> 0.01407341007143259,
                        "sexual/minors"=> 0.0038522258400917053,
                        "violence"=> 0.9223177433013916,
                        "violence/graphic"=> 0.036865197122097015
                      ],
                      "flagged"=> true
                    ]
            ];
            $content_type = [
                "Content-Type"=> "application/json",
                "Authorization"=> "Bearer $apiKey"
            ];
            $url = "https://api.openai.com/v1/moderations";
            $type= "POST";
            return $this->callOpenAI($data, $url, $content_type,$type,$apiKey);
        }
        public function engines($api="")
        {
            $apiKey = "$api";
            $data = [
                [
                    "id"=> "engine-id-0",
                    "object"=> "engine",
                    "owner"=> "organization-owner",
                    "ready"=> true
                ],
                [
                    "id"=> "engine-id-2",
                    "object"=> "engine",
                    "owner"=> "organization-owner",
                    "ready"=> true
                ],
                [
                    "id"=> "engine-id-3",
                    "object"=> "engine",
                    "owner"=> "organization-owner",
                    "ready"=> true
                ],
            ];
            $content_type = [
                "Content-Type"=> "application/json",
                "Authorization"=> "Bearer $apiKey"
            ];
            $url = "https://api.openai.com/v1/engines";
            $type= "GET";
            return $this->callOpenAI($data, $url, $content_type,$type,$apiKey);
        }
    
        public function callOpenAI($data, $url, $content_type,$type,$apiKey)
        {
            $apiKey = "$apiKey";
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
                    // 'Content-Type: multipart/form-data',
                    // 'Authorization: Bearer '.$apiKey,
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