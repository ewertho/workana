<?php
require 'functions.php';

// Example of function usage

// Register a product
registerProduct('Product 1', 1, 10.99);

// Register a product type
registerProductType('Type 1', 5.0);

// Register a sale
registerSale(1, 3);

// Calculate the total value of the sale
$totalValue = calculateTotalValue(1, 3);
echo "Total value of the sale: $totalValue";

// Calculate the total tax value of the sale
$totalTaxValue = calculateTotalTaxValue(1, 3);
echo "Total tax value: $totalTaxValue";

// Get the total purchase value
$totalPurchaseValue = getTotalPurchaseValue();
echo "Total purchase value: $totalPurchaseValue";

// Get the total tax value
$totalTaxValue = getTotalTaxValue();
echo "Total tax value: $totalTaxValue";
