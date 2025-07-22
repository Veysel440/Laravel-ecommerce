'use client';

import { useEffect, useState, useContext } from 'react';
import { useParams } from 'next/navigation';
import { fetchProductDetail } from '../../../lib/productApi';
import { CartContext } from '../../../contexts/CartContext';

export default function ProductDetailPage() {
    const params = useParams();
    const { id } = params;
    const [product, setProduct] = useState(null);
    const { addToCart } = useContext(CartContext);

    useEffect(() => {
        const loadProduct = async () => {
            try {
                const result = await fetchProductDetail(id);
                setProduct(result);
            } catch {
                alert('Ürün yüklenemedi.');
            }
        };

        loadProduct();
    }, [id]);

    if (!product) return <p>Yükleniyor...</p>;

    return (
        <div>
            <h1>{product.name}</h1>
            <p>{product.description}</p>
            <p>Fiyat: {product.price} ₺</p>
            <button onClick={() => addToCart(product)}>Sepete Ekle</button>
        </div>
    );
}
