"use client";

import { useEffect, useState } from 'react';
import { fetchUsers } from '../../../lib/adminApi';
import '../../../styles/AdminUserPage.css';

export default function AdminUsersPage() {
    const [users, setUsers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [typeMap, setTypeMap] = useState({});

    useEffect(() => {
        const token = localStorage.getItem('token');
        fetchUsers(token)
            .then(setUsers)
            .catch(() => alert('Kullanıcılar alınamadı.'))
            .finally(() => setLoading(false));
    }, []);

    const handleTypeChange = (id, value) => {
        setTypeMap((prev) => ({ ...prev, [id]: value }));
    };

    const handleUpdateType = async (id) => {
        const newType = typeMap[id];
        if (!newType) return;
        const token = localStorage.getItem('token');
        try {
            const response = await fetch(`http://localhost:8000/api/admin/users/${id}/update-type`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify({ userType: newType }),
            });
            if (!response.ok) throw new Error('Kullanıcı tipi güncellenemedi.');
            setUsers((prev) =>
                prev.map((user) =>
                    user.id === id ? { ...user, userType: newType } : user
                )
            );
            alert('Kullanıcı tipi güncellendi.');
        } catch (error) {
            alert(error.message);
        }
    };

    const handleDelete = async (id) => {
        if (!confirm("Bu kullanıcıyı silmek istediğine emin misin?")) return;
        const token = localStorage.getItem('token');
        try {
            const response = await fetch(`http://localhost:8000/api/admin/users/${id}`, {
                method: 'DELETE',
                headers: { Authorization: `Bearer ${token}` },
            });
            if (!response.ok) throw new Error('Kullanıcı silinemedi.');
            setUsers((prev) => prev.filter((u) => u.id !== id));
            alert('Kullanıcı silindi.');
        } catch (error) {
            alert(error.message);
        }
    };

    if (loading) return <p>Yükleniyor...</p>;

    return (
        <div>
            <h1 className="admin-user-header">Admin Kullanıcı Yönetimi</h1>
            <table className="admin-user-list">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Ad Soyad</th>
                    <th>E-posta</th>
                    <th>Tip</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tbody>
                {users.map((user) => (
                    <tr key={user.id}>
                        <td>{user.id}</td>
                        <td>{user.name}</td>
                        <td>{user.email}</td>
                        <td>
                            <select
                                className="admin-user-type-select"
                                value={typeMap[user.id] ?? user.userType}
                                onChange={e => handleTypeChange(user.id, e.target.value)}
                            >
                                <option value="user">Kullanıcı</option>
                                <option value="admin">Admin</option>
                            </select>
                        </td>
                        <td>
                            <button className="admin-user-update-btn" onClick={() => handleUpdateType(user.id)}>
                                Güncelle
                            </button>
                            <button className="admin-user-delete-btn" onClick={() => handleDelete(user.id)}>
                                Sil
                            </button>
                        </td>
                    </tr>
                ))}
                </tbody>
            </table>
        </div>
    );
}
