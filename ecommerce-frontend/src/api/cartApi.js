import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api';

const authHeader = (token) => ({
    headers: { Authorization: `Bearer ${token}` },
});

export const fetchCart = (token) => axios.get(`${API_BASE_URL}/cart`, authHeader(token));

export const addToCart = (token, product_id, quantity = 1) =>
    axios.post(`${API_BASE_URL}/cart/add`, { product_id, quantity }, authHeader(token));

export const updateCartItem = (token, id, quantity) =>
    axios.put(`${API_BASE_URL}/cart/update/${id}`, { quantity }, authHeader(token));

export const removeCartItem = (token, id) =>
    axios.delete(`${API_BASE_URL}/cart/remove/${id}`, authHeader(token));

export const clearCart = (token) =>
    axios.delete(`${API_BASE_URL}/cart/clear`, authHeader(token));
