<?php
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/routes/api.php';

$controller = new UserController();

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

switch ($requestMethod) {
    case 'GET':
        if (preg_match('/\/api\/users\/(\d+)/', $requestUri, $matches)) {
            $controller->readUser($matches[1]);
        } else {
            $controller->readAllUsers();
        }
        break;
    case 'POST':
        $controller->createUser();
        break;
    case 'PUT':
        if (preg_match('/\/api\/users\/(\d+)/', $requestUri, $matches)) {
            $controller->updateUser($matches[1]);
        }
        break;
    case 'DELETE':
        if (preg_match('/\/api\/users\/(\d+)/', $requestUri, $matches)) {
            $controller->deleteUser($matches[1]);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}
?>