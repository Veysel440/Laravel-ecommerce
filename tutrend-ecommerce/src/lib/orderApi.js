const API_BASE_URL = 'http://localhost:8000/api';

const authHeader = (token) => ({
    headers: { Authorization: `Bearer ${token}` },
});

const handleResponse = async (response) => {
    if (!response.ok) throw new Error('API hatası');
    return await response.json();
};

export async function fetchOrders() {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/orders", {
        headers: { Authorization: `Bearer ${token}` },
    });
    if (!res.ok) throw new Error("Siparişler yüklenemedi");
    return res.json();
}

export async function createOrder(orderData) {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/orders", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify(orderData),
    });
    if (!res.ok) throw new Error("Sipariş oluşturulamadı");
    return res.json();
}
