import React, { useState, useEffect } from "react";
import styles from "./app.module.css";
import ProductForm from "../components/ProductForm/ProductForm";
import SaleForm from "../components/SaleForm/SaleForm";
import Totalizers from "../components/Totalizers/Totalizers";
import {
  listProducts,
  listProductTypes,
  listSales,
  registerProduct,
  registerSale,
  updateProduct,
  updateSale,
  deleteProduct,
  deleteSale,
} from "../connection/Api";

const App = (): JSX.Element => {
  const [products, setProducts] = useState<any[]>([]);
  const [productTypes, setProductTypes] = useState<any[]>([]);
  const [sales, setSales] = useState<any[]>([]);
  const [totalValue, setTotalValue] = useState(0);
  const [totalTaxes, setTotalTaxes] = useState(0);

  const fetchProducts = async () => {
    try {
      const products = await listProducts();
      setProducts(products || []);
    } catch (error: any) {
      console.error("Failed to fetch products:", error.message);
    }
  };

  const fetchProductTypes = async () => {
    try {
      const productTypes = await listProductTypes();
      setProductTypes(productTypes || []);
    } catch (error: any) {
      console.error("Failed to fetch product types:", error.message);
    }
  };

  const fetchSales = async () => {
    try {
      const sales = await listSales();
      setSales(sales || []);
    } catch (error: any) {
      console.error("Failed to fetch sales:", error.message);
    }
  };

  useEffect(() => {
    fetchProducts();
    fetchProductTypes();
    fetchSales();
  }, []);

  const handleProductSubmit = async (
    name: string,
    typeId: number,
    price: number
  ) => {
    try {
      await registerProduct(name, typeId, price);
      fetchProducts();
      console.log("Product registered successfully.");
    } catch (error: any) {
      console.error("Failed to register product:", error.message);
    }
  };

  const handleProductUpdate = async (
    id: number,
    name: string,
    typeId: number,
    price: number
  ) => {
    try {
      await updateProduct(id, name, typeId, price);
      fetchProducts();
      console.log("Product updated successfully.");
    } catch (error: any) {
      console.error("Failed to update product:", error.message);
    }
  };

  const handleProductDelete = async (id: number) => {
    try {
      await deleteProduct(id);
      fetchProducts();
      console.log("Product deleted successfully.");
    } catch (error: any) {
      console.error("Failed to delete product:", error.message);
    }
  };

  const handleSaleSubmit = async (productId: number, quantity: number) => {
    try {
      await registerSale(productId, quantity);
      fetchSales();
      console.log("Sale registered successfully.");
    } catch (error: any) {
      console.error("Failed to register sale:", error.message);
    }
  };

  const handleSaleUpdate = async (
    id: number,
    productId: number,
    quantity: number
  ) => {
    try {
      await updateSale(id, productId, quantity);
      fetchSales();
      console.log("Sale updated successfully.");
    } catch (error: any) {
      console.error("Failed to update sale:", error.message);
    }
  };

  const handleSaleDelete = async (id: number) => {
    try {
      await deleteSale(id);
      fetchSales();
      console.log("Sale deleted successfully.");
    } catch (error: any) {
      console.error("Failed to delete sale:", error.message);
    }
  };

  return (
    <main className={styles.main}>
      <header className={styles.header}>
        <h1>Inventory Management System</h1>
      </header>
      <section className={styles.content}>
        <div className={styles.column}>
          <h2>Products</h2>
          <ProductForm
            onSubmit={handleProductSubmit}
            productTypes={productTypes}
          />
          <table>
            <thead>
              <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Price</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              {products.length > 0 ? (
                products.map((product) => (
                  <tr key={product.id}>
                    <td>{product.name}</td>
                    <td>{product.type}</td>
                    <td>{product.price}</td>
                    <td>
                      <button
                        onClick={() =>
                          handleProductUpdate(
                            product.id,
                            product.name,
                            product.type_id,
                            product.price
                          )
                        }
                      >
                        Update
                      </button>
                      <button onClick={() => handleProductDelete(product.id)}>
                        Delete
                      </button>
                    </td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td>not product</td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
        <div className={styles.column}>
          <h2>Sales</h2>
          <SaleForm onSubmit={handleSaleSubmit} products={products} />
          <table>
            <thead>
              <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              {sales.length > 0 ? (
                sales.map((sale) => (
                  <tr key={sale.id}>
                    <td>{sale.product_name}</td>
                    <td>{sale.quantity}</td>
                    <td>
                      <button
                        onClick={() =>
                          handleSaleUpdate(
                            sale.id,
                            sale.product_id,
                            sale.quantity
                          )
                        }
                      >
                        Update
                      </button>
                      <button onClick={() => handleSaleDelete(sale.id)}>
                        Delete
                      </button>
                    </td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td>not sale</td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
        <div className={styles.column}>
          <Totalizers totalValue={totalValue} totalTaxes={totalTaxes} />
        </div>
      </section>
      <footer className={styles.footer}>
        <p>&copy; Inventory Management System</p>
      </footer>
    </main>
  );
};

export default App;
