<?php

class OpenAIAPI {
    private $apiKey;
    private $model;

    public function __construct($apiKey, $model) {
        $this->apiKey = $apiKey;
        $this->model = $model;
    }

    public function query($data) {
        $api_url = 'https://api.openai.com/v1/chat/completions';
        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/json\r\n" .
                             "Authorization: Bearer " . $this->apiKey . "\r\n",
                'content' => json_encode($data)
            ]
        ];
        
        $context  = stream_context_create($options);
        $response = file_get_contents($api_url, false, $context);

        if (false === $response) {
            throw new Exception('Error communicating with the OpenAI API');
        }

        return $response;
    }
}

