<?php
require 'db.php';

// Function to register a product
function registerProduct($name, $type_id, $price) {
    $db = new Database();
    $conn = $db->getConnection();

    $query = "INSERT INTO products (name, type_id, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name, $type_id, $price]);
}

// Function to register a product type
function registerProductType($name, $tax_rate) {
    $db = new Database();
    $conn = $db->getConnection();

    $query = "INSERT INTO types (name, tax_rate) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name, $tax_rate]);
}

// Function to register a sale
function registerSale($product_id, $quantity) {
    $db = new Database();
    $conn = $db->getConnection();

    $query = "INSERT INTO sales (product_id, quantity) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$product_id, $quantity]);
}

// Function to calculate the total value of a sale
function calculateTotalValue($product_id, $quantity) {
    $db = new Database();
    $conn = $db->getConnection();

    $query = "SELECT price FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$product_id]);
    $price = $stmt->fetchColumn();

    return $price * $quantity;
}

// Function to calculate the total tax value of a sale
function calculateTotalTaxValue($product_id, $quantity) {
    $db = new Database();
    $conn = $db->getConnection();

    $query = "SELECT price, type_id FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$product_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $price = $result['price'];
    $type_id = $result['type_id'];

    $query = "SELECT tax_rate FROM types WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$type_id]);
    $tax_rate = $stmt->fetchColumn();

    return ($price * $tax_rate / 100) * $quantity;
}

// Function to get the total purchase value
function getTotalPurchaseValue() {
    $db = new Database();
    $conn = $db->getConnection();

    $query = "SELECT SUM(sales.quantity * products.price) as total FROM sales INNER JOIN products ON sales.product_id = products.id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total'];
}

// Function to get the total tax value
function getTotalTaxValue() {
    $db = new Database();
    $conn = $db->getConnection();

    $query = "SELECT SUM(sales.quantity * products.price * types.tax_rate / 100) as total FROM sales INNER JOIN products ON sales.product_id = products.id INNER JOIN types ON products.type_id = types.id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total'];
}
