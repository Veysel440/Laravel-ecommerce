import { useState } from 'react';
import { registerUser } from '../api/authApi';
import { useNavigate } from 'react-router-dom';

export default function Register() {
    const [form, setForm] = useState({ name: '', email: '', password: '' });
    const [error, setError] = useState('');
    const navigate = useNavigate();

    const handleChange = (e) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError('');
        try {
            await registerUser(form);
            navigate('/login');
        } catch (err) {
            setError('Kayıt başarısız.');
        }
    };

    return (
        <div>
            <h1>Kayıt Ol</h1>
            <form onSubmit={handleSubmit}>
                <input type="text" name="name" placeholder="Ad Soyad" value={form.name} onChange={handleChange} />
                <input type="email" name="email" placeholder="E-posta" value={form.email} onChange={handleChange} />
                <input type="password" name="password" placeholder="Şifre" value={form.password} onChange={handleChange} />
                <button type="submit">Kayıt Ol</button>
                {error && <p style={{ color: 'red' }}>{error}</p>}
            </form>
        </div>
    );
}
