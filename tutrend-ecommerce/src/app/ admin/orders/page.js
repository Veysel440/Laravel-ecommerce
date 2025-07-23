"use client";

import { useEffect, useState } from 'react';
import { fetchAdminOrders } from '../../../lib/adminApi';
import '../../../styles/AdminOrderPage.css';

export default function AdminOrdersPage() {
    const [orders, setOrders] = useState([]);
    const [loading, setLoading] = useState(true);
    const [statusMap, setStatusMap] = useState({});

    useEffect(() => {
        const token = localStorage.getItem('token');
        fetchAdminOrders(token)
            .then(setOrders)
            .catch(() => alert('Admin siparişleri alınamadı.'))
            .finally(() => setLoading(false));
    }, []);


    const handleStatusChange = (id, value) => {
        setStatusMap((prev) => ({ ...prev, [id]: value }));
    };

    
    const handleUpdateStatus = async (id) => {
        const newStatus = statusMap[id];
        if (!newStatus) return;
        const token = localStorage.getItem('token');
        try {
            const response = await fetch(`http://localhost:8000/api/admin/orders/${id}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify({ status: newStatus }),
            });
            if (!response.ok) throw new Error('Durum güncellenemedi.');
            setOrders((prev) =>
                prev.map((order) =>
                    order.id === id ? { ...order, status: newStatus } : order
                )
            );
            alert('Sipariş durumu güncellendi.');
        } catch (error) {
            alert(error.message);
        }
    };

    if (loading) return <p>Yükleniyor...</p>;

    return (
        <div>
            <h1 className="admin-order-header">Admin Sipariş Yönetimi</h1>
            <table className="admin-order-list">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Kullanıcı</th>
                    <th>Toplam</th>
                    <th>Durum</th>
                    <th>Güncelle</th>
                </tr>
                </thead>
                <tbody>
                {orders.map((order) => (
                    <tr key={order.id}>
                        <td>{order.id}</td>
                        <td>{order.user?.name || '-'}</td>
                        <td>{order.total_price} ₺</td>
                        <td>
                            <select
                                className="admin-order-status-select"
                                value={statusMap[order.id] ?? order.status}
                                onChange={e => handleStatusChange(order.id, e.target.value)}
                            >
                                <option value="pending">Bekliyor</option>
                                <option value="completed">Tamamlandı</option>
                                <option value="cancelled">İptal</option>
                            </select>
                        </td>
                        <td>
                            <button className="admin-order-update-btn" onClick={() => handleUpdateStatus(order.id)}>
                                Güncelle
                            </button>
                        </td>
                    </tr>
                ))}
                </tbody>
            </table>
        </div>
    );
}
