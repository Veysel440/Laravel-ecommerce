'use client';

import { useEffect, useState } from 'react';
import { fetchUserOrders } from '../../lib/orderApi';

export default function MyOrdersPage() {
    const [orders, setOrders] = useState([]);

    useEffect(() => {
        const loadOrders = async () => {
            try {
                const token = localStorage.getItem('token');
                const result = await fetchUserOrders(token);
                setOrders(result);
            } catch {
                alert('Siparişler alınamadı.');
            }
        };

        loadOrders();
    }, []);

    return (
        <div>
            <h1>Siparişlerim</h1>
            {orders.length === 0 && <p>Henüz siparişiniz yok.</p>}

            {orders.map((order) => (
                <div key={order.id}>
                    <p><b>ID:</b> {order.id}</p>
                    <p><b>Toplam:</b> {order.total_price} ₺</p>
                    <p><b>Durum:</b> {order.status}</p>
                </div>
            ))}
        </div>
    );
}
