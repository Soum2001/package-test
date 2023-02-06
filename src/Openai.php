<?php

namespace Soumyaa\Openai;

class Openai
{
    private string $content_types;
    private string $url;
    private string $openai_key;

    public function __construct($openai_key)
    {
        $this->openai_key    = $openai_key;
        $this->url           = "https://api.openai.com/v1/";
        $this->content_types = "application/json";
    }

    /**
     * @uses List the currently availabel models and provides basic information about each one such as owner availability  
     * @param string type
     * @param string url
     * @param string content_type
     * @return string list of the models
     */
    public function listModels()
    {
        $this->content_types = "application/json";
        $parameter = array(
            'type' => "GET",
            'url'  => $this->url . "models",
            'arr_name'=>'data',
            'key'=>'id'
            
        );
        return ($this->callOpenAI($parameter));
    }

    /**
     * @uses Retriving a model instance, providing basic information about model such as owner and permissioning
     * @param string type
     * @param string url
     * @param string content_type
     * @return string retrive model instance
     */
    public function retriveModels($data)
    {
        $this->content_types = "application/json";

        if ($data['model'] == "") {
            $parameter = array(
                "message" => "add model id"
            );
        } else {
            $parameter = array(
                'type' => "GET",
                'url'  => $this->url . "models/" . $data['model'],
                'arr_name'=>'permission',
                'key'=>'id'

            );
        }
        return $this->callOpenAI($parameter);
    }

    /**
     * @uses Given a prompt the model will return one or more predicted completions 
     * @param string model
     * @param string prompt
     * @param int max_tokens
     * @param int temperature
     * @param string content_type
     * @param string type
     * @param string url
     * @return string predicted completions
     */
    public function completion($data)
    {
        $this->content_types = "application/json";
        if ($data['prompt'] == "") {
            $parameter = array(
                "message" => "add some prompt"
            );
        } else {
            $parameter = array(
                'data' => array(
                    "model"         => $data['model'],
                    "prompt"        => $data['prompt'],
                    "max_tokens"    => $data['max_tokens'],
                    "temperature"   => $data['temperature'],
                ),
                'type' => "POST",
                'url' => $this->url . "completions",
                'arr_name'=>'choices',
                'key'=>'text'
            );
        }

        return $this->callOpenAI($parameter);
    }

    public function edits($data)
    {
        $this->content_types = "application/json";
        if ($data['input'] == "") {
            $parameter = array(
                "message" => "add some input"
            );
        } else {
            $parameter = array(
                'data' => array(
                    "model"         => $data['model'],
                    "input"        => $data['input'],
                    "instruction"    => $data['instruction'],
                ),
                'type' => "POST",
                'url' => $this->url . "edits",
                'arr_name'=>'choices',
                'key'=>'text'
            );
        }

        return $this->callOpenAI($parameter);
    }
    /**
     * @uses Given a prompt and/or an input image, the model will generate a new image.
     * @param string prompt
     * @param int n
     * @param string size
     * @param string content_type
     * @param string type
     * @param string url
     * @return string new image url
     */
    public function imageGenerations($data)
    {
        $this->content_types = "application/json";
        if (array_key_exists("prompt", $data)) {
            if ($data['prompt'] == "") {
                $parameter = array(
                    "message" => "add some prompt message"
                );
            } else {
                $parameter = array(
                    'data'       => array(
                        "prompt" => $data['prompt'],
                        "n"      => $data['n'],
                        "size"   => $data['size'],
                    ),
                    'type' => "POST",
                    'url' => $this->url . "images/generations",
                    'arr_name'=>'data',
                    'key'=>'url'
                );
            }
        } else {
            $parameter = array(
                "message" => "add prompt parameter"
            );
        }
        return $this->callOpenAI($parameter);
    }

    /**
     * @uses Creates an edited or extended image given an original image and a prompt.
     * @param string prompt
     * @param object image
     * @param int n
     * @param string size
     * @param string content_type
     * @param string type
     * @param string url
     * @return string new image url
     */
    public function imageEdit($data)
    {
        if (array_key_exists("prompt", $data) || array_key_exists("image", $data)) {
            if ($data['image'] == "") {
                $parameter = array(
                    "message" => "missiging image file"
                );
            } else if ($data['prompt'] == "") {
                $parameter = array(
                    "message" => "add some prompt"
                );
            } else {
                $this->content_types = "multipart/form-data";
                $parameter = array(
                    'data' => array(
                        "image"  => $data['image'],
                        "prompt" => $data['prompt'],
                        "n"      => $data['n'],
                        "size"   => $data['size'],
                    ),
                    'type' => "POST",
                    'url' => $this->url . "images/edits",
                    'arr_name'=>'data',
                    'key'=>'url'
                );
            }
        } else {
            $parameter = array(
                "message" => "add required parameter"
            );
        }
        return $this->callOpenAI($parameter);
    }

    /**
     * @uses create variations of given image
     * @param object image
     * @param int n
     * @param string size
     * @param string content_type
     * @param string type
     * @param string url
     * @return string url of image
     */
    public function imageVariations($data)
    {
        if (array_key_exists("image", $data)) {
            if ($data['image'] == "") {
                $parameter = array(
                    "message" => "image parameter is empty. Add some image over there"
                );
            } else {
                $this->content_types = "multipart/form-data";
                $parameter = array(
                    'data' => array(
                        "image" => $data['image'],
                        "n"     => $data['n'],
                        "size"  => $data['size'],
                    ),
                    'type' => "POST",
                    'url' => $this->url . "images/variations",
                    'arr_name'=>'data',
                    'key'=>'url'
                );
            }
        } else {
            $parameter = array(
                "message" => "image parameter required"
            );
        }
        return $this->callOpenAI($parameter);
    }

    public function callOpenAI($parameter)
    {
        if (isset($parameter["message"])) {
            return $parameter['message'];
        } else {
            $curl = curl_init();
            if ($parameter['type'] == "POST" && $this->content_types == "application/json") {
                curl_setopt_array($curl, array(CURLOPT_POSTFIELDS => json_encode($parameter['data'])));
            }
            if ($parameter['type'] == "POST" && $this->content_types == "multipart/form-data") {
                curl_setopt_array($curl, array(CURLOPT_POSTFIELDS => $parameter['data']));
            }
            curl_setopt_array($curl, array(
                CURLOPT_URL => $parameter['url'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => "",
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => $parameter['type'],
                CURLOPT_HTTPHEADER     => array(
                    "Content-Type:" . $this->content_types,
                    "Authorization: Bearer " . $this->openai_key
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $response_data = json_decode($response, true);
            $output = "";
            for($i=0;$i<count($response_data[$parameter['arr_name']]);$i++)
            {
                $output .= $response_data[$parameter['arr_name']][$i][$parameter['key']];
                $output .= "<br>";
            }
            //$output = $response_data['choices'][0]['text'];
            return $output;
        }
    }
}
