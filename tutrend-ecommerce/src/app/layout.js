import '../styles/globals.css';
import Navbar from '../components/Navbar';
import { SearchProvider } from '../contexts/SearchContext';
import { CartProvider } from '../contexts/CartContext';
import { AuthProvider } from '../contexts/AuthContext';

export const metadata = { title: 'TrendyEcom' };

export default function RootLayout({ children }) {
    return (
        <html lang="tr">
        <body>
        <AuthProvider>
            <SearchProvider>
                <CartProvider>
                    <Navbar />
                    <main className="container">{children}</main>
                </CartProvider>
            </SearchProvider>
        </AuthProvider>
        </body>
        </html>
    );
}
