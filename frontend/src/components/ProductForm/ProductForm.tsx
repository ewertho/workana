import React, { useState } from "react";

interface ProductFormProps {
  onSubmit: (name: string, type: number, price: number) => void;
  productTypes: any[];
}

const ProductForm: React.FC<ProductFormProps> = ({
  onSubmit,
  productTypes,
}) => {
  const [name, setName] = useState("");
  const [type, setType] = useState("");
  const [price, setPrice] = useState("");

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onSubmit(name.trim(), Number(type), Number(price));
    setName("");
    setType("");
    setPrice("");
  };

  return (
    <div className="bg-gray-100 p-4 rounded-lg">
      <h2 className="text-xl font-bold mb-4">Product Form</h2>
      <form onSubmit={handleSubmit}>
        <div className="mb-4">
          <label htmlFor="name" className="block mb-1">
            Product Name:
          </label>
          <input
            type="text"
            id="name"
            value={name}
            className="w-full p-2 border border-gray-300 rounded"
            onChange={(e) => setName(e.target.value)}
            required
          />
        </div>
        <div className="mb-4">
          <label htmlFor="type" className="block mb-1">
            Product Type:
          </label>
          <select
            id="type"
            value={type}
            className="w-full p-2 border border-gray-300 rounded"
            onChange={(e) => setType(e.target.value)}
            required
          >
            <option value="">Select a type</option>
            {productTypes.length > 0 ? (
              productTypes.map((productType) => (
                <option key={productType.id} value={productType.id}>
                  {productType.name}
                </option>
              ))
            ) : (
              <option></option>
            )}
          </select>
        </div>
        <div className="mb-4">
          <label htmlFor="price" className="block mb-1">
            Product Price:
          </label>
          <input
            type="number"
            id="price"
            value={price}
            className="w-full p-2 border border-gray-300 rounded"
            onChange={(e) => setPrice(e.target.value)}
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

export default ProductForm;
