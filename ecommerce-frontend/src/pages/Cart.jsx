import { useEffect, useState, useContext } from 'react';
import { fetchCart, removeCartItem, clearCart, updateCartItem } from '../api/cartApi';
import { AuthContext } from '../contexts/AuthContext';

export default function Cart() {
    const { token } = useContext(AuthContext);
    const [cartItems, setCartItems] = useState([]);

    const loadCart = async () => {
        try {
            const res = await fetchCart(token);
            setCartItems(res.data.data);
        } catch {
            alert('Sepet yüklenemedi.');
        }
    };

    useEffect(() => {
        loadCart();
    }, []);

    const handleRemove = async (id) => {
        await removeCartItem(token, id);
        loadCart();
    };

    const handleClear = async () => {
        await clearCart(token);
        loadCart();
    };

    const handleUpdateQuantity = async (itemId, quantity) => {
        await updateCartItem(token, itemId, quantity);
        loadCart();
    };

    return (
        <div>
            <h1>Sepetim</h1>
            {cartItems.length === 0 && <p>Sepetiniz boş.</p>}
            {cartItems.map(item => (
                <div key={item.id}>
                    <p>{item.product.name}</p>
                    <p>{item.product.price} ₺</p>
                    <input
                        type="number"
                        value={item.quantity}
                        onChange={(e) => handleUpdateQuantity(item.id, e.target.value)}
                        min="1"
                    />
                    <button onClick={() => handleRemove(item.id)}>Sil</button>
                </div>
            ))}
            {cartItems.length > 0 && (
                <button onClick={handleClear}>Sepeti Temizle</button>
            )}
        </div>
    );
}
