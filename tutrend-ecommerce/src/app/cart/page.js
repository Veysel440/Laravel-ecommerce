'use client';

import { useContext } from 'react';
import { CartContext } from '../../contexts/CartContext';
import { AuthContext } from '../../contexts/AuthContext';
import { createOrder } from '../../lib/orderApi';
import { useRouter } from 'next/navigation';

export default function CartPage() {
    const { cartItems, clearCart } = useContext(CartContext);
    const { user } = useContext(AuthContext);
    const router = useRouter();

    const totalPrice = cartItems.reduce((sum, item) => sum + item.product.price * item.quantity, 0);

    const handleCheckout = async () => {
        if (!user) {
            alert('Sipariş için giriş yapmalısınız.');
            return;
        }

        try {
            const token = localStorage.getItem('token');
            await createOrder(token, totalPrice, cartItems);
            clearCart();
            router.push('/order-success');
        } catch {
            alert('Sipariş oluşturulamadı.');
        }
    };

    return (
        <div>
            <h1>Sepetim</h1>

            {cartItems.length === 0 && <p>Sepetiniz boş.</p>}

            {cartItems.map((item) => (
                <p key={item.product.id}>{item.product.name} x {item.quantity}</p>
            ))}

            {cartItems.length > 0 && (
                <>
                    <p><b>Toplam Tutar:</b> {totalPrice} ₺</p>
                    <button onClick={handleCheckout}>Siparişi Tamamla</button>
                </>
            )}
        </div>
    );
}
