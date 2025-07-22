'use client';

import { useEffect, useState } from 'react';
import { fetchAdminOrders } from '../../../lib/adminApi';

export default function AdminOrdersPage() {
    const [orders, setOrders] = useState([]);

    useEffect(() => {
        const token = localStorage.getItem('token');
        fetchAdminOrders(token)
            .then(setOrders)
            .catch(() => alert('Siparişler alınamadı.'));
    }, []);

    return (
        <div>
            <h1>Sipariş Yönetimi</h1>

            {orders.map((order) => (
                <div key={order.id}>
                    <p>ID: {order.id}</p>
                    <p>Durum: {order.status}</p>
                    <p>Toplam: {order.total_price} ₺</p>
                    <button>Durumu Güncelle</button>
                </div>
            ))}
        </div>
    );
}
