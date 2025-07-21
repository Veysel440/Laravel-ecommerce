import { useEffect, useState } from 'react';
import { fetchProducts } from '../api/productApi';
import ProductCard from '../components/ProductCard';

export default function Home() {
    const [products, setProducts] = useState([]);

    useEffect(() => {
        fetchProducts()
            .then(setProducts)
            .catch(() => alert('Ürünler yüklenemedi.'));
    }, []);

    return (
        <div>
            <h1>Ürünler</h1>
            {products.map((product) => (
                <ProductCard key={product.id} product={product} />
            ))}
        </div>
    );
}
