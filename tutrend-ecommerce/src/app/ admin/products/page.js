'use client';

import { useEffect, useState } from 'react';
import { fetchProducts } from '../../../lib/productApi';
import Link from 'next/link';

export default function AdminProductsPage() {
    const [products, setProducts] = useState([]);

    useEffect(() => {
        fetchProducts().then(setProducts).catch(() => alert('Ürünler alınamadı.'));
    }, []);

    return (
        <div>
            <h1>Ürün Yönetimi</h1>

            <Link href="/admin/products/create">+ Ürün Ekle</Link>

            {products.map((p) => (
                <div key={p.id} style={{ borderBottom: '1px solid #ccc', padding: '10px' }}>
                    <p>{p.name}</p>
                    <p>{p.price} ₺</p>
                    <button>Düzenle</button>
                    <button>Sil</button>
                </div>
            ))}
        </div>
    );
}
