const API_BASE_URL = 'http://localhost:8000/api';

const authHeader = (token) => ({
    headers: { Authorization: `Bearer ${token}` },
});

const handleResponse = async (response) => {
    if (!response.ok) throw new Error('API hatası');
    return await response.json();
};

export const createOrder = async (token, totalPrice, items) => {
    try {
        const response = await fetch(`${API_BASE_URL}/orders`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({
                total_price: totalPrice,
                items: items.map(item => ({
                    product_id: item.product.id,
                    quantity: item.quantity,
                })),
            }),
        });
        return await handleResponse(response);
    } catch (error) {
        console.error('createOrder:', error);
        throw error;
    }
};

export const fetchUserOrders = async (token) => {
    try {
        const response = await fetch(`${API_BASE_URL}/orders`, authHeader(token));
        const data = await handleResponse(response);
        return data.data;
    } catch (error) {
        console.error('fetchUserOrders:', error);
        throw error;
    }
};
