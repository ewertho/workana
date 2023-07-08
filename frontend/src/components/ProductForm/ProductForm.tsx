import React, { useState } from "react";
import styles from "./ProductForm.module.css";

interface ProductFormProps {
  onSubmit: (name: string, type: string, price: number) => void;
}

const ProductForm: React.FC<ProductFormProps> = ({ onSubmit }) => {
  const [name, setName] = useState("");
  const [type, setType] = useState("");
  const [price, setPrice] = useState(0);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onSubmit(name, type, price);
    setName("");
    setType("");
    setPrice(0);
  };

  return (
    <div className={styles.ProductForm}>
      <h2 className={styles.h2}>Product Form</h2>
      <form className={styles.form} onSubmit={handleSubmit}>
        <div>
          <label className={styles.label} htmlFor="name">
            Product Name:
          </label>
          <input
            type="text"
            id="name"
            value={name}
            className={styles.input}
            onChange={(e) => setName(e.target.value)}
          />
        </div>
        <div>
          <label className={styles.label} htmlFor="type">
            Product Type:
          </label>
          <input
            type="text"
            id="type"
            value={type}
            className={styles.input}
            onChange={(e) => setType(e.target.value)}
          />
        </div>
        <div>
          <label className={styles.label} htmlFor="price">
            Product Price:
          </label>
          <input
            type="number"
            id="price"
            value={price}
            className={styles.input}
            onChange={(e) => setPrice(Number(e.target.value))}
          />
        </div>
        <button className={styles.label} type="submit">
          Submit
        </button>
      </form>
    </div>
  );
};

export default ProductForm;
