<?php

namespace Soumyaa\Openai;

class Openai
{
    private string $content_types;
    private string $url;
    private string $openai_key;

    public function __construct($openai_key,$url,$content_types)
    {
        $this->openai_key = $openai_key;
        $this->url = "https://api.openai.com/v1/".$url;
        if($content_types == "file/image")
        {
            $this->content_types = "multipart/form-data";
        }
        else{
            $this->content_types = "application/json";
        }
    }
    public function listModels()
    {
        $parameter = array(
            'type' => "GET",
            'url' => $this->url,
        );
        return $this->callOpenAI($parameter);
    }
    public function retriveModels()
    {
        $parameter = array(
            'type' => "GET",
            'url' => $this->url,
        );
        return $this->callOpenAI($parameter);
    }
    public function completion($data)
    {
        $parameter = array(
            'data' => array(
                "model" => $data['model_id'],
                'prompt' => $data['prompt'],
                "max_tokens" => 7,
                "temperature" => 0,
            ),
            'type' => "POST",
        );
        return $this->callOpenAI($parameter);
    }
    public function imageGenerations($data)
    {
        $parameter = array(
            'data' => array(
                "prompt" => $data['prompt'],
                "n" => $data['n'],
                "size" => $data['size'],
            ),
            'type' => "POST",
        );
        return $this->callOpenAI($parameter);
    }

    public function imageEdit($data)
    {
        $parameter = array(
            'data' => array(
                "image" => $data['image'],
                "prompt" => $data['prompt'],
                "n" => $data['n'],
                "size" => $data['size'],
            ),
            'type' => "POST",
        );
        return $this->callOpenAI($parameter);
    }

    public function imageVariations($data)
    {

        $parameter = array(
            'data' => array(
                "image" => $data['image'],
                "n" => $data['n'],
                "size" => $data['size'],
            ),
            'type' => "POST",
        );
        return $this->callOpenAI($parameter);
    }
    public function callOpenAI($parameter)
    {
        // if ($parameter["data"]["prompt"] == "") {
        //     return "Give some message in prompt";
        // }
        // $url = $parameter['url'];
        //$prompt ="What is the capital of odisha";
        $curl = curl_init();
        if ($parameter['type'] == "POST" && $this->content_types = "application/json") {
            curl_setopt_array($curl, array(CURLOPT_POSTFIELDS => json_encode($parameter['data'])));
        }
        if ($parameter['type'] == "POST" && $this->content_types = "multipart/form-data") {
            curl_setopt_array($curl, array(CURLOPT_POSTFIELDS => $parameter['data']));
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $parameter['type'],
            CURLOPT_HTTPHEADER => array(
                "Content-Type:".$this->content_types,
                "Authorization: Bearer " . $this->openai_key
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response_data = json_decode($response, true);
        print_r($response_data);
        //return $response_data;
    }
}
