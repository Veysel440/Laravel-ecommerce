import { createContext, useState, useEffect } from "react";
import { fetchCart, addToCart, updateCartItem, removeCartItem, clearCart } from "../lib/cartApi";
import { toast } from "react-toastify";

export const CartContext = createContext();

export function CartProvider({ children }) {
    const [cartItems, setCartItems] = useState([]);


    useEffect(() => {
        fetchCart()
            .then(setCartItems)
            .catch(() => toast.error("Sepet yüklenemedi"));
    }, []);

    const handleAddToCart = async (productId, quantity = 1) => {
        try {
            const item = await addToCart(productId, quantity);

            setCartItems((prev) => {
                const existing = prev.find((ci) => ci.product_id === productId);
                if (existing) {
                    return prev.map((ci) =>
                        ci.product_id === productId
                            ? { ...ci, quantity: ci.quantity + quantity }
                            : ci
                    );
                }
                return [...prev, item];
            });
            toast.success("Ürün sepete eklendi!");
        } catch {
            toast.error("Sepete eklenemedi");
        }
    };

    const handleUpdateQuantity = async (itemId, quantity) => {
        try {
            const updated = await updateCartItem(itemId, quantity);
            setCartItems((prev) =>
                prev.map((ci) => (ci.id === itemId ? { ...ci, quantity } : ci))
            );
            toast.success("Sepet güncellendi!");
        } catch {
            toast.error("Güncelleme başarısız");
        }
    };

    const handleRemoveItem = async (itemId) => {
        try {
            await removeCartItem(itemId);
            setCartItems((prev) => prev.filter((ci) => ci.id !== itemId));
            toast.success("Sepetten çıkarıldı!");
        } catch {
            toast.error("Sepetten silinemedi");
        }
    };

    const handleClearCart = async () => {
        try {
            await clearCart();
            setCartItems([]);
            toast.success("Sepet temizlendi!");
        } catch {
            toast.error("Sepet temizlenemedi");
        }
    };

    return (
        <CartContext.Provider
            value={{
                cartItems,
                addToCart: handleAddToCart,
                updateQuantity: handleUpdateQuantity,
                removeItem: handleRemoveItem,
                clearCart: handleClearCart,
            }}
        >
            {children}
        </CartContext.Provider>
    );
}
