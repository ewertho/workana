import React, { useState } from "react";

interface SaleFormProps {
  onSubmit: (productId: number, quantity: number) => Promise<void>;
  products: any[];
}

const SaleForm: React.FC<SaleFormProps> = ({ onSubmit, products }) => {
  const [productId, setProductId] = useState("");
  const [quantity, setQuantity] = useState("");

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    await onSubmit(Number(productId), Number(quantity));
    setProductId("");
    setQuantity("");
  };

  return (
    <div className="bg-gray-100 p-4 rounded-lg">
      <h2 className="text-xl font-bold mb-4">Sale Form</h2>
      <form onSubmit={handleSubmit}>
        <div className="mb-4">
          <label htmlFor="productId" className="block mb-1">
            Product ID:
          </label>
          <input
            type="number"
            id="productId"
            value={productId}
            className="w-full p-2 border border-gray-300 rounded"
            onChange={(e) => setProductId(e.target.value)}
            required
          />
        </div>
        <div className="mb-4">
          <label htmlFor="quantity" className="block mb-1">
            Quantity:
          </label>
          <input
            type="number"
            id="quantity"
            value={quantity}
            className="w-full p-2 border border-gray-300 rounded"
            onChange={(e) => setQuantity(e.target.value)}
            required
          />
        </div>
        <button
          className="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
          type="submit"
        >
          Submit
        </button>
      </form>
    </div>
  );
};

export default SaleForm;
