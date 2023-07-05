<?php

require_once 'config.php';
require_once 'DB.php';
require_once 'OpenAIAPI.php';

function handleSuccess($responseJson, $count = 0)  {
    http_response_code(200);    
    echo json_encode(array_merge(
            ['status' => '200'],
            $responseJson,
            ['count' => $count])
        );
    exit;
}

function handleError($message) {
    http_response_code(500);
    echo json_encode(['status' => '500', 'error' => $message]);
    exit;
}

function validateResponse($responseJson){
    $requiredKeys = ['answerIsValid', 'explanation'];
    foreach ($requiredKeys as $key){
        if(!is_array($responseJson) || !array_key_exists($key, $responseJson)) {
            return false;
        }
    }
    return true;
}

try {
    $db = new DB($db);
    $openai = new OpenAIAPI($config['openai_key'], 'gpt-3.5-turbo');

    $answer = filter_input(INPUT_POST, "answer", FILTER_SANITIZE_STRING);

    if(!$answer) {
        handleError('Invalid input');
    }

    $result = $db->checkAnswerExists($answer);
    if($result) {
        handleSuccess(json_decode($result['response'], true), $result['count']);
    }

    require 'prompt.php';
    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ["role" => "system", "content" => $systemPrompt],
            ["role" => "user", "content" => $userPrompt]
        ]
    ];

    $maxAttempts = 3;
    for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
        $response = $openai->query($data);
        $responseBody = json_decode($response, true);
        if(isset($responseBody["choices"][0]["message"]["content"])) {
            $responseJson = json_decode($responseBody["choices"][0]["message"]["content"], true);
            if(validateResponse($responseJson)){
                $db->storeAnswer($answer, $responseJson);
                handleSuccess($responseJson);
            }
        } 
        if ($attempt === $maxAttempts) {
            handleError('Invalid response from API after '.$maxAttempts.' attempts.');
        }
    }
} catch (Exception $e) {
    handleError($e->getMessage());
}
