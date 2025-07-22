'use client';

import { useEffect, useState } from 'react';
import { fetchUsers } from '../../../lib/adminApi';

export default function AdminUsersPage() {
    const [users, setUsers] = useState([]);

    useEffect(() => {
        const token = localStorage.getItem('token');
        fetchUsers(token)
            .then(setUsers)
            .catch(() => alert('Kullanıcılar alınamadı.'));
    }, []);

    return (
        <div>
            <h1>Kullanıcı Yönetimi</h1>

            {users.map((user) => (
                <div key={user.id}>
                    <p>{user.name} - {user.email}</p>
                    <p>Tip: {user.userType}</p>
                    <button>Sil</button>
                </div>
            ))}
        </div>
    );
}
