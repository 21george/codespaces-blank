<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('users')->group(function () {
    Route::post('/', [UserController::class, 'createUser']);
    Route::get('/{id}', [UserController::class, 'readUser']);
    Route::put('/{id}', [UserController::class, 'updateUser']);
    Route::delete('/{id}', [UserController::class, 'deleteUser']);
});

Route::prefix('tax')->group(function () {
    Route::post('/calculate', [UserController::class, 'calculateIncome']);
    Route::post('/refund', [UserController::class, 'processTaxRefund']);
});

require_once __DIR__ . '/../controllers/UserController.php';

use App\Controllers\UserController;

$controller = new UserController();

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

switch ($requestMethod) {
    case 'GET':
        if (preg_match('/\/api\/users\/(\d+)/', $requestUri, $matches)) {
            $user = $controller->readUser($matches[1]);
            echo json_encode($user);
        } elseif (preg_match('/\/api\/tax-refund\/pdf\/(\d+)\/(\w+)/', $requestUri, $matches)) {
            $controller->generateTaxRefundPDF($matches[1], $matches[2]);
        } elseif (preg_match('/\/api\/tax-refund\/claims\/(\d+)/', $requestUri, $matches)) {
            $controller->getPastTaxRefundClaims($matches[1]);
        } elseif (preg_match('/\/api\/tax-office\/messages\/(\d+)/', $requestUri, $matches)) {
            $controller->getMessagesFromTaxOffice($matches[1]);
        } elseif (preg_match('/\/api\/users\/(\d+)\/documents\/private/', $requestUri, $matches)) {
            $documents = $controller->getNecessaryDocumentsForPrivateUser($matches[1]);
            echo json_encode($documents);
        } elseif (preg_match('/\/api\/users\/(\d+)\/documents\/company/', $requestUri, $matches)) {
            $documents = $controller->getNecessaryDocumentsForCompanyUser($matches[1]);
            echo json_encode($documents);
        } else {
            $users = $controller->readAllUsers();
            echo json_encode($users);
        }
        break;
    case 'POST':
        if (preg_match('/\/api\/tax-refund\/request\/(\d+)\/(\w+)/', $requestUri, $matches)) {
            $controller->sendTaxRefundRequest($matches[1], $matches[2]);
        } else {
            $data = json_decode(file_get_contents('php://input'), true);
            $user = $controller->createUser($data);
            echo json_encode($user);
        }
        break;
    case 'PUT':
        if (preg_match('/\/api\/users\/(\d+)/', $requestUri, $matches)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $user = $controller->updateUser($matches[1], $data);
            echo json_encode($user);
        }
        break;
    case 'DELETE':
        if (preg_match('/\/api\/users\/(\d+)/', $requestUri, $matches)) {
            $result = $controller->deleteUser($matches[1]);
            echo json_encode(['status' => $result ? 'success' : 'error']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}
?>