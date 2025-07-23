// src/lib/adminApi.js
const API_BASE_URL = 'http://localhost:8000/api';

const authHeader = (token) => ({
    headers: { Authorization: `Bearer ${token}` },
});

const handleResponse = async (response) => {
    if (!response.ok) {
        const data = await response.json().catch(() => ({}));
        throw new Error(data.message || 'API hatası');
    }
    return await response.json();
};

// Ürünler
export const fetchAdminProducts = async (token) => {
    try {
        const response = await fetch(`${API_BASE_URL}/admin/products`, authHeader(token));
        const data = await handleResponse(response);
        return data.data;
    } catch (error) {
        console.error('fetchAdminProducts:', error);
        throw error;
    }
};

// Siparişler
export const fetchAdminOrders = async (token) => {
    try {
        const response = await fetch(`${API_BASE_URL}/admin/orders`, authHeader(token));
        const data = await handleResponse(response);
        return data.data;
    } catch (error) {
        console.error('fetchAdminOrders:', error);
        throw error;
    }
};

// Kullanıcılar
export const fetchUsers = async (token) => {
    try {
        const response = await fetch(`${API_BASE_URL}/admin/users`, authHeader(token));
        const data = await handleResponse(response);
        return data.data;
    } catch (error) {
        console.error('fetchUsers:', error);
        throw error;
    }
};
