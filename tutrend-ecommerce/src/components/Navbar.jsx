'use client';

import Link from 'next/link';
import { useContext } from 'react';
import { SearchContext } from '../contexts/SearchContext';
import { CartContext } from '../contexts/CartContext';
import { AuthContext } from '../contexts/AuthContext';
import '../styles/Navbar.css';

export default function Navbar() {
    const { searchText, setSearchText } = useContext(SearchContext);
    const { cartItems } = useContext(CartContext);
    const { user } = useContext(AuthContext);

    return (
        <nav className="navbar">
            <Link href="/" className="navbar-logo">TrendyEcom</Link>

            <input
                type="text"
                placeholder="Ürün ara..."
                value={searchText}
                onChange={(e) => setSearchText(e.target.value)}
                className="navbar-search"
            />

            <div className="navbar-right">
                <Link href="/favorites" className="navbar-icon">
                    ❤️ Favorilerim
                </Link>

                {user
                    ? <span>👤 {user.name}</span>
                    : <Link href="/login" className="navbar-icon">🔑 Giriş Yap</Link>
                }

                <Link href="/cart" className="navbar-icon">
                    🛒 Sepetim ({cartItems.length})
                </Link>
            </div>
        </nav>
    );
}

