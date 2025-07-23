"use client";

import { useEffect, useState } from 'react';
import { useParams } from 'next/navigation';

export default function AdminProductEditPage() {
    const { id } = useParams();
    const [form, setForm] = useState({ name: '', price: '', description: '', image: '' });
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const token = localStorage.getItem('token');
        fetch(`http://localhost:8000/api/admin/products/${id}`, {
            headers: { Authorization: `Bearer ${token}` },
        })
            .then((res) => res.json())
            .then((data) => {
                setForm({
                    name: data.data.name || '',
                    price: data.data.price || '',
                    description: data.data.description || '',
                    image: data.data.image || '',
                });
            })
            .finally(() => setLoading(false));
    }, [id]);

    const handleChange = (e) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`http://localhost:8000/api/admin/products/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(form),
            });
            if (!response.ok) throw new Error('Ürün güncellenemedi!');
            alert('Ürün güncellendi!');
            window.location.href = '/admin/products';
        } catch (error) {
            alert(error.message);
        } finally {
            setLoading(false);
        }
    };

    if (loading) return <p>Yükleniyor...</p>;

    return (
        <div style={{ maxWidth: 400, margin: '0 auto' }}>
            <h2>Ürün Düzenle</h2>
            <form onSubmit={handleSubmit}>
                <input name="name" placeholder="Ürün Adı" value={form.name} onChange={handleChange} required style={{ width: '100%', marginBottom: 8 }} />
                <input name="price" placeholder="Fiyat" value={form.price} onChange={handleChange} required type="number" style={{ width: '100%', marginBottom: 8 }} />
                <input name="image" placeholder="Görsel URL" value={form.image} onChange={handleChange} style={{ width: '100%', marginBottom: 8 }} />
                <textarea name="description" placeholder="Açıklama" value={form.description} onChange={handleChange} style={{ width: '100%', marginBottom: 8 }} />
                <button disabled={loading} type="submit" style={{ width: '100%' }}>
                    {loading ? 'Güncelleniyor...' : 'Güncelle'}
                </button>
            </form>
        </div>
    );
}
