<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$pdo = require 'config/database.php';

switch($method) {
    case 'GET':
        if(isset($_GET['id'])) {
            // Get single contact
            $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $contact = $stmt->fetch(PDO::FETCH_ASSOC);

            if($contact) {
                echo json_encode($contact);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Contact not found"]);
            }
        } else {
            // Get all contacts
            $stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC");
            $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($contacts);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        if(!isset($data['name']) || !isset($data['email'])) {
            http_response_code(400);
            echo json_encode(["message" => "Name and email are required"]);
            break;
        }

        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone, address) VALUES (?, ?, ?, ?)");

        try {
            $stmt->execute([
                $data['name'],
                $data['email'],
                $data['phone'] ?? null,
                $data['address'] ?? null
            ]);

            $data['id'] = $pdo->lastInsertId();
            http_response_code(201);
            echo json_encode($data);
        } catch(PDOException $e) {
            http_response_code(400);
            echo json_encode(["message" => "Error creating contact: " . $e->getMessage()]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);

        if(!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(["message" => "ID is required"]);
            break;
        }

        $fields = [];
        $values = [];

        if(isset($data['name'])) {
            $fields[] = "name = ?";
            $values[] = $data['name'];
        }
        if(isset($data['email'])) {
            $fields[] = "email = ?";
            $values[] = $data['email'];
        }
        if(isset($data['phone'])) {
            $fields[] = "phone = ?";
            $values[] = $data['phone'];
        }
        if(isset($data['address'])) {
            $fields[] = "address = ?";
            $values[] = $data['address'];
        }

        $values[] = $data['id'];

        $sql = "UPDATE contacts SET " . implode(", ", $fields) . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute($values);
            if($stmt->rowCount() > 0) {
                echo json_encode(["message" => "Contact updated", "id" => $data['id']]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Contact not found"]);
            }
        } catch(PDOException $e) {
            http_response_code(400);
            echo json_encode(["message" => "Error updating contact: " . $e->getMessage()]);
        }
        break;

    case 'DELETE':
        if(!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(["message" => "ID is required"]);
            break;
        }

        $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");

        try {
            $stmt->execute([$_GET['id']]);
            if($stmt->rowCount() > 0) {
                echo json_encode(["message" => "Contact deleted", "id" => $_GET['id']]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Contact not found"]);
            }
        } catch(PDOException $e) {
            http_response_code(400);
            echo json_encode(["message" => "Error deleting contact: " . $e->getMessage()]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed"]);
        break;
}