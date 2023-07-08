import React from "react";
import "./Totalizers.css";

interface TotalizersProps {
  totalValue: number;
  totalTaxes: number;
}

const Totalizers: React.FC<TotalizersProps> = ({ totalValue, totalTaxes }) => {
  return (
    <div className="Totalizers">
      <h2>Totalizers</h2>
      <p>Total Value: {totalValue}</p>
      <p>Total Taxes: {totalTaxes}</p>
    </div>
  );
};

export default Totalizers;
