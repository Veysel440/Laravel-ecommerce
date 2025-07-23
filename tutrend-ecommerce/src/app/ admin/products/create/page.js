"use client";

import { useState } from 'react';

export default function AdminProductCreatePage() {
    const [form, setForm] = useState({ name: '', price: '', description: '', image: '' });
    const [loading, setLoading] = useState(false);

    const handleChange = (e) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            const token = localStorage.getItem('token');
            const response = await fetch('http://localhost:8000/api/admin/products', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(form),
            });
            if (!response.ok) throw new Error('Ürün eklenemedi!');
            alert('Ürün eklendi!');
            window.location.href = '/admin/products';
        } catch (error) {
            alert(error.message);
        } finally {
            setLoading(false);
        }
    };

    return (
        <div style={{ maxWidth: 400, margin: '0 auto' }}>
            <h2>Yeni Ürün Ekle</h2>
            <form onSubmit={handleSubmit}>
                <input name="name" placeholder="Ürün Adı" value={form.name} onChange={handleChange} required style={{ width: '100%', marginBottom: 8 }} />
                <input name="price" placeholder="Fiyat" value={form.price} onChange={handleChange} required type="number" style={{ width: '100%', marginBottom: 8 }} />
                <input name="image" placeholder="Görsel URL" value={form.image} onChange={handleChange} style={{ width: '100%', marginBottom: 8 }} />
                <textarea name="description" placeholder="Açıklama" value={form.description} onChange={handleChange} style={{ width: '100%', marginBottom: 8 }} />
                <button disabled={loading} type="submit" style={{ width: '100%' }}>
                    {loading ? 'Ekleniyor...' : 'Ekle'}
                </button>
            </form>
        </div>
    );
}
