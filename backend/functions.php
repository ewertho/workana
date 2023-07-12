<?php
require 'db.php';

class APIResponse
{
    public $success;
    public $message;
    public $data;

    public function __construct($success, $message, $data = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }
}

// Function to register a product
function registerProduct($name, $type_id, $price)
{
    $db = new Database();
    $conn = $db->getConnection();

    // Verificar se o produto já está cadastrado
    $query = "SELECT COUNT(*) FROM products WHERE name = ? AND type_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name, $type_id]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        return new APIResponse(false, 'Product already exists');
    }

    $query = "INSERT INTO products (name, type_id, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    try {
        $stmt->execute([$name, $type_id, $price]);
        $productId = $conn->lastInsertId();
        $data = ['id' => $productId, 'name' => $name, 'type_id' => $type_id, 'price' => $price];
        return new APIResponse(true, 'Product registered successfully', $data);
    } catch (PDOException $e) {
        return new APIResponse(false, 'Failed to register product: ' . $e->getMessage());
    }
}

// Function to register a product type
function registerProductType($name, $tax_rate)
{
    $db = new Database();
    $conn = $db->getConnection();

    // Verificar se o tipo de produto já está cadastrado
    $query = "SELECT COUNT(*) FROM types WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        return new APIResponse(false, 'Product type already exists');
    }

    // Inserir o novo tipo de produto
    $query = "INSERT INTO types (name, tax_rate) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    try {
        $stmt->execute([$name, $tax_rate]);
        $typeId = $conn->lastInsertId();
        $data = ['id' => $typeId, 'name' => $name, 'tax_rate' => $tax_rate];
        return new APIResponse(true, 'Product type registered successfully', $data);
    } catch (PDOException $e) {
        return new APIResponse(false, 'Failed to register product type: ' . $e->getMessage());
    }
}

// Function to register a sale
function registerSale($product_id, $quantity)
{
    $db = new Database();
    $conn = $db->getConnection();

    // Verificar se a venda já está cadastrada
    $query = "SELECT COUNT(*) FROM sales WHERE product_id = ? AND quantity = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$product_id, $quantity]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        return new APIResponse(false, 'Sale already exists');
    }

    // Inserir a nova venda
    $query = "INSERT INTO sales (product_id, quantity) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    try {
        $stmt->execute([$product_id, $quantity]);
        $saleId = $conn->lastInsertId();
        $data = ['id' => $saleId, 'product_id' => $product_id, 'quantity' => $quantity];
        return new APIResponse(true, 'Sale registered successfully', $data);
    } catch (PDOException $e) {
        return new APIResponse(false, 'Failed to register sale: ' . $e->getMessage());
    }
}

// Function to calculate the total value of a sale
function calculateTotalValue($product_id, $quantity)
{
    $db = new Database();
    $conn = $db->getConnection();

    $query = "SELECT price FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$product_id]);
    $price = $stmt->fetchColumn();

    if ($price !== false) {
        return $price * $quantity;
    } else {
        return null;
    }
}

// Function to calculate the total tax value of a sale
function calculateTotalTaxValue($product_id, $quantity)
{
    $db = new Database();
    $conn = $db->getConnection();

    $query = "SELECT price, type_id FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$product_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result !== false) {
        $price = $result['price'];
        $type_id = $result['type_id'];

        $query = "SELECT tax_rate FROM types WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$type_id]);
        $tax_rate = $stmt->fetchColumn();

        return ($price * $tax_rate / 100) * $quantity;
    } else {
        return null;
    }
}

// Function to get the total purchase value
function getTotalPurchaseValue()
{
    $db = new Database();
    $conn = $db->getConnection();

    $query = "SELECT SUM(sales.quantity * products.price) as total FROM sales INNER JOIN products ON sales.product_id = products.id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result !== false) {
        return $result['total'];
    } else {
        return null;
    }
}

// Function to get the total tax value
function getTotalTaxValue()
{
    $db = new Database();
    $conn = $db->getConnection();

    $query = "SELECT SUM(sales.quantity * products.price * types.tax_rate / 100) as total FROM sales INNER JOIN products ON sales.product_id = products.id INNER JOIN types ON products.type_id = types.id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result !== false) {
        return $result['total'];
    } else {
        return null;
    }
}

// Function to list all products
function listProducts()
{
    $db = new Database();
    $conn = $db->getConnection();

    $query = "SELECT * FROM products";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return new APIResponse(true, 'Products retrieved successfully', $products);
}

// Function to list all product types
function listProductTypes()
{
    $db = new Database();
    $conn = $db->getConnection();

    $query = "SELECT * FROM types";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return new APIResponse(true, 'Product types retrieved successfully', $types);
}

// Function to list all sales
function listSales()
{
    $db = new Database();
    $conn = $db->getConnection();

    $query = "SELECT * FROM sales";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return new APIResponse(true, 'Sales retrieved successfully', $sales);
}

// Function to update a product
function updateProduct($id, $name, $type_id, $price)
{
    $db = new Database();
    $conn = $db->getConnection();

    // Verificar se o produto existe
    $query = "SELECT COUNT(*) FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        return new APIResponse(false, 'Product not found');
    }

    // Atualizar o produto
    $query = "UPDATE products SET name = ?, type_id = ?, price = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    try {
        $stmt->execute([$name, $type_id, $price, $id]);
        return new APIResponse(true, 'Product updated successfully');
    } catch (PDOException $e) {
        return new APIResponse(false, 'Failed to update product: ' . $e->getMessage());
    }
}

// Function to update a product type
function updateProductType($id, $name, $tax_rate)
{
    $db = new Database();
    $conn = $db->getConnection();

    // Verificar se o tipo de produto existe
    $query = "SELECT COUNT(*) FROM types WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        return new APIResponse(false, 'Product type not found');
    }

    // Atualizar o tipo de produto
    $query = "UPDATE types SET name = ?, tax_rate = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    try {
        $stmt->execute([$name, $tax_rate, $id]);
        return new APIResponse(true, 'Product type updated successfully');
    } catch (PDOException $e) {
        return new APIResponse(false, 'Failed to update product type: ' . $e->getMessage());
    }
}

// Function to update a sale
function updateSale($id, $product_id, $quantity)
{
    $db = new Database();
    $conn = $db->getConnection();

    // Verificar se a venda existe
    $query = "SELECT COUNT(*) FROM sales WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        return new APIResponse(false, 'Sale not found');
    }

    // Atualizar a venda
    $query = "UPDATE sales SET product_id = ?, quantity = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    try {
        $stmt->execute([$product_id, $quantity, $id]);
        return new APIResponse(true, 'Sale updated successfully');
    } catch (PDOException $e) {
        return new APIResponse(false, 'Failed to update sale: ' . $e->getMessage());
    }
}

// Function to delete a product
function deleteProduct($id)
{
    $db = new Database();
    $conn = $db->getConnection();

    // Verificar se o produto existe
    $query = "SELECT COUNT(*) FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        return new APIResponse(false, 'Product not found');
    }

    // Deletar o produto
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    try {
        $stmt->execute([$id]);
        return new APIResponse(true, 'Product deleted successfully');
    } catch (PDOException $e) {
        return new APIResponse(false, 'Failed to delete product: ' . $e->getMessage());
    }
}

// Function to delete a product type
function deleteProductType($id)
{
    $db = new Database();
    $conn = $db->getConnection();

    // Verificar se o tipo de produto existe
    $query = "SELECT COUNT(*) FROM types WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        return new APIResponse(false, 'Product type not found');
    }

    // Deletar o tipo de produto
    $query = "DELETE FROM types WHERE id = ?";
    $stmt = $conn->prepare($query);
    try {
        $stmt->execute([$id]);
        return new APIResponse(true, 'Product type deleted successfully');
    } catch (PDOException $e) {
        return new APIResponse(false, 'Failed to delete product type: ' . $e->getMessage());
    }
}

// Function to delete a sale
function deleteSale($id)
{
    $db = new Database();
    $conn = $db->getConnection();

    // Verificar se a venda existe
    $query = "SELECT COUNT(*) FROM sales WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        return new APIResponse(false, 'Sale not found');
    }

    // Deletar a venda
    $query = "DELETE FROM sales WHERE id = ?";
    $stmt = $conn->prepare($query);
    try {
        $stmt->execute([$id]);
        return new APIResponse(true, 'Sale deleted successfully');
    } catch (PDOException $e) {
        return new APIResponse(false, 'Failed to delete sale: ' . $e->getMessage());
    }
}
