const API_BASE_URL = 'http://localhost:8000/api';

export async function fetchCart() {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/cart", {
        headers: { Authorization: `Bearer ${token}` },
    });
    if (!res.ok) throw new Error("Sepet yüklenemedi");
    return res.json();
}

export async function addToCart(productId, quantity = 1) {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/cart/add", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({ product_id: productId, quantity }),
    });
    if (!res.ok) throw new Error("Sepete eklenemedi");
    return res.json();
}

export async function updateCartItem(itemId, quantity) {
    const token = localStorage.getItem("token");
    const res = await fetch(`/api/cart/update/${itemId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({ quantity }),
    });
    if (!res.ok) throw new Error("Güncelleme başarısız");
    return res.json();
}

export async function removeCartItem(itemId) {
    const token = localStorage.getItem("token");
    const res = await fetch(`/api/cart/remove/${itemId}`, {
        method: "DELETE",
        headers: { Authorization: `Bearer ${token}` },
    });
    if (!res.ok) throw new Error("Sepetten silinemedi");
}

export async function clearCart() {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/cart/clear", {
        method: "DELETE",
        headers: { Authorization: `Bearer ${token}` },
    });
    if (!res.ok) throw new Error("Sepet temizlenemedi");
}

