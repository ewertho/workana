CREATE TABLE products (
id SERIAL PRIMARY KEY,
name VARCHAR(100) NOT NULL,
type_id INT NOT NULL,
price DECIMAL(10, 2) NOT NULL
);

CREATE TABLE types (
id SERIAL PRIMARY KEY,
name VARCHAR(50) NOT NULL,
tax_rate DECIMAL(5, 2) NOT NULL
);

CREATE TABLE sales (
id SERIAL PRIMARY KEY,
product_id INT NOT NULL,
quantity INT NOT NULL,
sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);