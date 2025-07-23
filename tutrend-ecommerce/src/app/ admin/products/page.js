"use client";

import { useEffect, useState } from 'react';
import { fetchAdminProducts } from '../../../lib/adminApi';
import Link from "next/link";
import '../../../styles/AdminProductPage.css';
import AdminProtectedRoute from "../../../components/AdminProtectedRoute";

export default function AdminProductsPage() {
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const token = localStorage.getItem('token');
        fetchAdminProducts(token)
            .then(setProducts)
            .catch(() => alert('Admin ürünleri alınamadı.'))
            .finally(() => setLoading(false));
    }, []);

    const handleDelete = async (id) => {
        if (!confirm("Bu ürünü silmek istediğine emin misin?")) return;
        const token = localStorage.getItem('token');
        try {
            const response = await fetch(`http://localhost:8000/api/admin/products/${id}`, {
                method: 'DELETE',
                headers: { Authorization: `Bearer ${token}` },
            });
            if (!response.ok) throw new Error('Ürün silinemedi.');
            setProducts((prev) => prev.filter((p) => p.id !== id));
            alert('Ürün silindi.');
        } catch (error) {
            alert(error.message);
        }
    };

    if (loading) return <p>Yükleniyor...</p>;

    return (
        <AdminProtectedRoute>
        <div>
            <h1 className="admin-product-header">Admin Ürün Yönetimi</h1>

            <div style={{ textAlign: "right", margin: "16px 40px" }}>
                <Link href="/admin/products/create">
                    <button className="admin-product-create-btn">
                        + Ürün Ekle
                    </button>
                </Link>
            </div>

            <div className="admin-product-list">
                {products.map((p) => (
                    <div key={p.id} className="admin-product-card">
                        <p><b>{p.name}</b></p>
                        <p>Fiyat: {p.price} ₺</p>
                        <div className="admin-product-btns">
                            <Link href={`/admin/products/edit/${p.id}`}>
                                <button className="admin-product-edit-btn">
                                    Düzenle
                                </button>
                            </Link>
                            <button
                                className="admin-product-delete-btn"
                                onClick={() => handleDelete(p.id)}>
                                Sil
                            </button>
                        </div>
                    </div>
                ))}
            </div>
        </div>
        </AdminProtectedRoute>
    );
}
