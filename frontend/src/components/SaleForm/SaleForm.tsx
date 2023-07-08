import React, { useState } from "react";
import style from "./SaleForm.module.css";

interface SaleFormProps {
  onSubmit: (productId: number, quantity: number) => void;
}

const SaleForm: React.FC<SaleFormProps> = ({ onSubmit }) => {
  const [productId, setProductId] = useState(0);
  const [quantity, setQuantity] = useState(0);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onSubmit(productId, quantity);
    setProductId(0);
    setQuantity(0);
  };

  return (
    <div className={style.SaleForm}>
      <h2>Sale Form</h2>
      <form onSubmit={handleSubmit}>
        <div>
          <label htmlFor="productId">Product ID:</label>
          <input
            type="number"
            id="productId"
            value={productId}
            onChange={(e) => setProductId(Number(e.target.value))}
          />
        </div>
        <div>
          <label htmlFor="quantity">Quantity:</label>
          <input
            type="number"
            id="quantity"
            value={quantity}
            onChange={(e) => setQuantity(Number(e.target.value))}
          />
        </div>
        <button type="submit">Submit</button>
      </form>
    </div>
  );
};

export default SaleForm;
