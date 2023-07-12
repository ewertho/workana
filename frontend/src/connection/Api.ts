import axios from "axios";

const BASE_URL = "http://localhost:8000";

// Function to register a product
export async function registerProduct(
  name: string,
  typeId: number,
  price: number
): Promise<string> {
  try {
    const response = await axios.post(`${BASE_URL}/products`, {
      name,
      type_id: typeId,
      price,
    });
    const apiresponse = response.data;
    return apiresponse.message;
  } catch (error: any) {
    throw new Error(error.reponse.data.message);
  }
}

// Function to register a product type
export async function registerProductType(
  name: string,
  taxRate: number
): Promise<string> {
  try {
    const response = await axios.post(`${BASE_URL}/types`, {
      name,
      tax_rate: taxRate,
    });
    const apiresponse = response.data;
    return apiresponse.message;
  } catch (error: any) {
    throw new Error(error.reponse.data.message);
  }
}

// Function to register a sale
export async function registerSale(
  productId: number,
  quantity: number
): Promise<string> {
  try {
    const response = await axios.post(`${BASE_URL}/sales`, {
      product_id: productId,
      quantity,
    });
    const apiresponse = response.data.data;
    return apiresponse.message;
  } catch (error: any) {
    throw new Error(error.reponse.data.message);
  }
}

// Function to list all products
export async function listProducts(): Promise<any[]> {
  try {
    const response = await axios.get(`${BASE_URL}/products`);
    const apiresponse = response.data.data;
    console.log(apiresponse);
    return apiresponse;
  } catch (error: any) {
    throw new Error(error.reponse.data.message);
  }
}

// Function to list all product types
export async function listProductTypes(): Promise<any[]> {
  try {
    const response = await axios.get(`${BASE_URL}/types`);
    const apiresponse = response.data.data;
    console.log(apiresponse);
    return apiresponse;
  } catch (error: any) {
    throw new Error(error.reponse.data.message);
  }
}

// Function to list all sales
export async function listSales(): Promise<any[]> {
  try {
    const response = await axios.get(`${BASE_URL}/sales`);
    const apiresponse = response.data.data;
    console.log(apiresponse);
    return apiresponse;
  } catch (error: any) {
    throw new Error(error.reponse.data.message);
  }
}

// Function to get the total purchase value
export async function getTotalPurchaseValue(): Promise<number> {
  try {
    const response = await axios.get(`${BASE_URL}/purchases/total-value`);
    const apiresponse = response.data.data;
    return apiresponse.total_purchase_value || 0;
  } catch (error: any) {
    throw new Error(
      error.response?.data?.message || "Failed to get total purchase value"
    );
  }
}

// Function to get the total tax value
export async function getTotalTaxValue(): Promise<number> {
  try {
    const response = await axios.get(`${BASE_URL}/taxes/total-value`);
    const apiresponse = response.data.data;
    return apiresponse.total_tax_value || 0;
  } catch (error: any) {
    throw new Error(
      error.response?.data?.message || "Failed to get total tax value"
    );
  }
}

// Function to update a product
export async function updateProduct(
  id: number,
  name: string,
  typeId: number,
  price: number
): Promise<string> {
  try {
    const response = await axios.put(`${BASE_URL}/products`, {
      id,
      name,
      type_id: typeId,
      price,
    });
    const apiresponse = response.data.data;
    return apiresponse.message;
  } catch (error: any) {
    throw new Error(error.reponse.data.message);
  }
}

// Function to update a product type
export async function updateProductType(
  id: number,
  name: string,
  taxRate: number
): Promise<string> {
  try {
    const response = await axios.put(`${BASE_URL}/types`, {
      id,
      name,
      tax_rate: taxRate,
    });
    const apiresponse = response.data.data;
    return apiresponse.message;
  } catch (error: any) {
    throw new Error(error.reponse.data.message);
  }
}

// Function to update a sale
export async function updateSale(
  id: number,
  productId: number,
  quantity: number
): Promise<string> {
  try {
    const response = await axios.put(`${BASE_URL}/sales`, {
      id,
      product_id: productId,
      quantity,
    });
    const apiresponse = response.data.data;
    return apiresponse.message;
  } catch (error: any) {
    throw new Error(error.reponse.data.message);
  }
}

// Function to delete a product
export async function deleteProduct(id: number): Promise<string> {
  try {
    const response = await axios.delete(`${BASE_URL}/products`, {
      data: { id },
    });
    const apiresponse = response.data.data;
    return apiresponse.message;
  } catch (error: any) {
    throw new Error(error.reponse.data.message);
  }
}

// Function to delete a product type
export async function deleteProductType(id: number): Promise<string> {
  try {
    const response = await axios.delete(`${BASE_URL}/types`, { data: { id } });
    const apiresponse = response.data.data;
    return apiresponse.message;
  } catch (error: any) {
    throw new Error(error.reponse.data.message);
  }
}

// Function to delete a sale
export async function deleteSale(id: number): Promise<string> {
  try {
    const response = await axios.delete(`${BASE_URL}/sales`, { data: { id } });
    const apiresponse = response.data.data;
    return apiresponse.message;
  } catch (error: any) {
    throw new Error(error.reponse.data.message);
  }
}
