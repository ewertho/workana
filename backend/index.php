<?php

require 'functions.php';

// Set response headers
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // Permite todas as origens. Substitua "*" pelo domínio específico do seu cliente, se necessário.
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE"); // Especifique os métodos HTTP permitidos.
header("Access-Control-Allow-Headers: Content-Type"); // Especifique os cabeçalhos personalizados permitidos.


// Get the URL path
$uri = $_SERVER['REQUEST_URI'];
$parts = explode('?', $uri);
$path = $parts[0];

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Convert request body to associative array
    $data = json_decode(file_get_contents('php://input'), true);

    switch ($path) {
        case '/products':
            if (isset($data['name'], $data['type_id'], $data['price'])) {
                $name = $data['name'];
                $typeId = (int) $data['type_id'];
                $price = (float) $data['price'];
                $response = registerProduct($name, $typeId, $price);
                http_response_code($response->success ? 201 : 400);
                echo json_encode(['message' => $response->message]);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required fields']);
            }
            exit;

        case '/types':
            if (isset($data['name'], $data['tax_rate'])) {
                $name = $data['name'];
                $taxRate = (float) $data['tax_rate'];
                $response = registerProductType($name, $taxRate);
                http_response_code($response->success ? 201 : 400);
                echo json_encode(['message' => $response->message]);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required fields']);
            }
            exit;

        case '/sales':
            if (isset($data['product_id'], $data['quantity'])) {
                $productId = (int) $data['product_id'];
                $quantity = (int) $data['quantity'];
                $response = registerSale($productId, $quantity);
                http_response_code($response->success ? 201 : 400);
                echo json_encode(['message' => $response->message]);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required fields']);
            }
            exit;
    }
}

// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch ($path) {
        case '/products':
            $response = listProducts();
            echo json_encode($response);
            exit;

        case '/types':
            $response = listProductTypes();
            echo json_encode($response);
            exit;

        case '/sales':
            $response = listSales();
            echo json_encode($response);
            exit;

        case '/sales/total-value':
            if (isset($_GET['product_id'], $_GET['quantity'])) {
                $productId = (int) $_GET['product_id'];
                $quantity = (int) $_GET['quantity'];
                $totalValue = calculateTotalValue($productId, $quantity);
                echo json_encode(['total_value' => $totalValue]);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required parameters']);
            }
            exit;

        case '/sales/total-tax-value':
            if (isset($_GET['product_id'], $_GET['quantity'])) {
                $productId = (int) $_GET['product_id'];
                $quantity = (int) $_GET['quantity'];
                $totalTaxValue = calculateTotalTaxValue($productId, $quantity);
                echo json_encode(['total_tax_value' => $totalTaxValue]);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required parameters']);
            }
            exit;

        case '/purchases/total-value':
            $totalPurchaseValue = getTotalPurchaseValue();
            echo json_encode(['total_purchase_value' => $totalPurchaseValue]);
            exit;

        case '/taxes/total-value':
            $totalTaxValue = getTotalTaxValue();
            echo json_encode(['total_tax_value' => $totalTaxValue]);
            exit;
    }
}

// Handle PUT requests
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents('php://input'), $data);

    switch ($path) {
        case '/products':
            if (isset($data['id'], $data['name'], $data['type_id'], $data['price'])) {
                $id = (int) $data['id'];
                $name = $data['name'];
                $typeId = (int) $data['type_id'];
                $price = (float) $data['price'];
                $response = updateProduct($id, $name, $typeId, $price);
                http_response_code($response->success ? 200 : 400);
                echo json_encode(['message' => $response->message]);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required fields']);
            }
            exit;

        case '/types':
            if (isset($data['id'], $data['name'], $data['tax_rate'])) {
                $id = (int) $data['id'];
                $name = $data['name'];
                $taxRate = (float) $data['tax_rate'];
                $response = updateProductType($id, $name, $taxRate);
                http_response_code($response->success ? 200 : 400);
                echo json_encode(['message' => $response->message]);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required fields']);
            }
            exit;

        case '/sales':
            if (isset($data['id'], $data['product_id'], $data['quantity'])) {
                $id = (int) $data['id'];
                $productId = (int) $data['product_id'];
                $quantity = (int) $data['quantity'];
                $response = updateSale($id, $productId, $quantity);
                http_response_code($response->success ? 200 : 400);
                echo json_encode(['message' => $response->message]);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required fields']);
            }
            exit;
    }
}

// Handle DELETE requests
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents('php://input'), $data);

    switch ($path) {
        case '/products':
            if (isset($data['id'])) {
                $id = (int) $data['id'];
                $response = deleteProduct($id);
                http_response_code($response->success ? 200 : 400);
                echo json_encode(['message' => $response->message]);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required fields']);
            }
            exit;

        case '/types':
            if (isset($data['id'])) {
                $id = (int) $data['id'];
                $response = deleteProductType($id);
                http_response_code($response->success ? 200 : 400);
                echo json_encode(['message' => $response->message]);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required fields']);
            }
            exit;

        case '/sales':
            if (isset($data['id'])) {
                $id = (int) $data['id'];
                $response = deleteSale($id);
                http_response_code($response->success ? 200 : 400);
                echo json_encode(['message' => $response->message]);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required fields']);
            }
            exit;
    }
}

// Invalid endpoint
http_response_code(404);
echo json_encode(['message' => 'Invalid endpoint.']);
