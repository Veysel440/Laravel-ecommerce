'use client';

import { useState, useContext } from 'react';
import { AuthContext } from '../../contexts/AuthContext';

export default function LoginPage() {
    const [form, setForm] = useState({ email: '', password: '' });
    const { setUser } = useContext(AuthContext);

    const handleSubmit = async (e) => {
        e.preventDefault();
        const response = await fetch('http://localhost:8000/api/auth/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(form),
        });
        const data = await response.json();
        if (data.token) {
            localStorage.setItem('token', data.token);
            setUser(data.user);
            alert('Giriş başarılı!');
        } else {
            alert('Giriş başarısız.');
        }
    };

    return (
        <div>
            <h1>Giriş Yap</h1>
            <form onSubmit={handleSubmit}>
                <input
                    type="email"
                    name="email"
                    placeholder="E-posta"
                    value={form.email}
                    onChange={(e) => setForm({ ...form, email: e.target.value })}
                />
                <input
                    type="password"
                    name="password"
                    placeholder="Şifre"
                    value={form.password}
                    onChange={(e) => setForm({ ...form, password: e.target.value })}
                />
                <button type="submit">Giriş Yap</button>
            </form>
        </div>
    );
}
