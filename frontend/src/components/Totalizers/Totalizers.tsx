import React from "react";

interface TotalizersProps {
  totalValue: number;
  totalTaxes: number;
}

const Totalizers: React.FC<TotalizersProps> = ({ totalValue, totalTaxes }) => {
  return (
    <div className="bg-gray-100 p-4 rounded-lg">
      <h2 className="text-xl font-bold mb-4">Totalizers</h2>
      <p className="mb-2">Total Value: {totalValue}</p>
      <p className="mb-2">Total Taxes: {totalTaxes}</p>
    </div>
  );
};

export default Totalizers;
