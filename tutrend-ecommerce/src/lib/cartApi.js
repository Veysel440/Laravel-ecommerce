const API_BASE_URL = 'http://localhost:8000/api';

const authHeader = (token) => ({
    headers: { Authorization: `Bearer ${token}` },
});

const handleResponse = async (response) => {
    if (!response.ok) throw new Error('API hatası');
    return await response.json();
};

export const fetchCart = async (token) => {
    try {
        const response = await fetch(`${API_BASE_URL}/cart`, authHeader(token));
        const data = await handleResponse(response);
        return data.data;
    } catch (error) {
        console.error('fetchCart:', error);
        throw error;
    }
};

export const addToCart = async (token, productId, quantity = 1) => {
    try {
        const response = await fetch(`${API_BASE_URL}/cart/add`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({ product_id: productId, quantity }),
        });
        return await handleResponse(response);
    } catch (error) {
        console.error('addToCart:', error);
        throw error;
    }
};

export const removeCartItem = async (token, cartItemId) => {
    try {
        const response = await fetch(`${API_BASE_URL}/cart/remove/${cartItemId}`, {
            method: 'DELETE',
            headers: { Authorization: `Bearer ${token}` },
        });
        return await handleResponse(response);
    } catch (error) {
        console.error('removeCartItem:', error);
        throw error;
    }
};

export const clearCart = async (token) => {
    try {
        const response = await fetch(`${API_BASE_URL}/cart/clear`, {
            method: 'DELETE',
            headers: { Authorization: `Bearer ${token}` },
        });
        return await handleResponse(response);
    } catch (error) {
        console.error('clearCart:', error);
        throw error;
    }
};
