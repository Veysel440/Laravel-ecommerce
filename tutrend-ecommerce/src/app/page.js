"use client";

import SimpleCarousel from '../components/SimpleCarousel';
import CategoryBar from '../components/CategoryBar';
import ProductCard from '../components/ProductCard';
import { fetchProducts } from '../lib/productApi';
import { useEffect, useState, useContext } from 'react';
import { SearchContext } from '../contexts/SearchContext';

export default function HomePage() {
    const [products, setProducts] = useState([]);
    const { searchText } = useContext(SearchContext);

    useEffect(() => {
        fetchProducts()
            .then(setProducts)
            .catch(() => alert('Ürünler yüklenemedi.'));
    }, []);

    const filteredProducts = products.filter((p) =>
        p.name.toLowerCase().includes(searchText.toLowerCase())
    );

    return (
        <>
            <SimpleCarousel />
            <CategoryBar />

            <h1 style={{ textAlign: 'center' }}>Ürünler</h1>

            {filteredProducts.length === 0 && <p style={{ textAlign: 'center' }}>Aradığınız ürünü bulamadık.</p>}

            <div style={{ display: 'flex', flexWrap: 'wrap', gap: '20px', justifyContent: 'center' }}>
                {filteredProducts.map((product) => (
                    <ProductCard key={product.id} product={product} />
                ))}
            </div>
        </>
    );
}
