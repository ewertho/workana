<?php
// Database configurations
define('DB_HOST', 'db');
define('DB_NAME', 'market');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

// Conexão com o banco de dados
try {
  $pdo = new PDO("pgsql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";user=" . DB_USER . ";password=" . DB_PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Criação da tabela
  $sql = "CREATE TABLE IF NOT EXISTS products (
        id SERIAL PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        type_id INT NOT NULL,
        price DECIMAL(10, 2) NOT NULL
      );
    
      CREATE TABLE IF NOT EXISTS types (
        id SERIAL PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        tax_rate DECIMAL(5, 2) NOT NULL
      );
    
      CREATE TABLE IF NOT EXISTS sales (
        id SERIAL PRIMARY KEY,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );
    ";

  $pdo->exec($sql);
} catch (PDOException $e) {
  echo "Erro ao criar a tabela: " . $e->getMessage();
}
