<?php

class DB {
    private $conn;

    public function __construct($db) {
        $this->conn = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);
        if ($this->conn->connect_error) {
            throw new Exception('Connection failed: ' . $this->conn->connect_error);
        }
    }

    public function checkAnswerExists($answer) {
        $stmt = $this->conn->prepare("SELECT response, count FROM answers WHERE answer = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->conn->error);
        }
        $stmt->bind_param("s", $answer);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt = $this->conn->prepare("UPDATE answers SET count = count + 1 WHERE answer = ?");
            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $this->conn->error);
            }
            $stmt->bind_param("s", $answer);
            $stmt->execute();
            return $row;
        } else {
            return null;
        }
    }

    public function storeAnswer($answer, $response) {
        $stmt = $this->conn->prepare("INSERT INTO answers (answer, response, count) VALUES (?, ?, 1)");
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->conn->error);
        }
        $stmt->bind_param("ss", $answer, json_encode($response));
        if(!$stmt->execute()){
            throw new Exception("Failed to execute statement: " . $stmt->error);
        }
    }
}

