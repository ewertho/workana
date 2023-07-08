import Logos from "components/atoms/logos";
import Card from "components/organisms/card";
import {
  BeakerIcon,
  BookmarkIcon,
  CakeIcon,
  ChevronDownIcon,
  CubeTransparentIcon,
  FilmIcon,
  PhoneXMarkIcon,
  LockClosedIcon,
  Bars3Icon,
  PencilIcon,
  PhotoIcon,
} from "@heroicons/react/24/outline";
import { QuestionMarkCircleIcon } from "@heroicons/react/24/solid";
import Button from "components/atoms/button";
import CopyButton from "components/molecules/copy-button";

import styles from "./app.module.css";
import React, { useState } from "react";

import ProductForm from "../components/ProductForm/ProductForm";
import SaleForm from "../components/SaleForm/SaleForm";
import Totalizers from "../components/Totalizers/Totalizers";

const App = (): JSX.Element => {
  const [totalValue, setTotalValue] = useState(0);
  const [totalTaxes, setTotalTaxes] = useState(0);
  const handleProductSubmit = (name: string, type: string, price: number) => {
    // Lógica para lidar com o envio do formulário de produto
    console.log("Product submitted:", name, type, price);
  };
  const handleSaleSubmit = (productId: number, quantity: number) => {
    // Lógica para lidar com o envio do formulário de venda
    console.log("Sale submitted:", productId, quantity);
  };
  return (
    <main className={styles.main}>
      <header className={styles.header}></header>
      <section className={styles.App}>
        <ProductForm onSubmit={handleProductSubmit} />
        <SaleForm onSubmit={handleSaleSubmit} />
        <Totalizers totalValue={totalValue} totalTaxes={totalTaxes} />
      </section>
      <footer className={styles.footer}></footer>
    </main>
  );
};

export default App;
