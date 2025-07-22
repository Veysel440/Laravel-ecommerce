const API_BASE_URL = 'http://localhost:8000/api';

const handleResponse = async (response) => {
    if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'İşlem başarısız.');
    }
    return await response.json();
};

export const loginUser = async (email, password) => {
    try {
        const response = await fetch(`${API_BASE_URL}/auth/login`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password }),
        });
        return await handleResponse(response);
    } catch (error) {
        console.error('loginUser:', error);
        throw error;
    }
};

export const registerUser = async (name, email, password) => {
    try {
        const response = await fetch(`${API_BASE_URL}/auth/register`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, email, password }),
        });
        return await handleResponse(response);
    } catch (error) {
        console.error('registerUser:', error);
        throw error;
    }
};

export const getUserInfo = async (token) => {
    try {
        const response = await fetch(`${API_BASE_URL}/auth/me`, {
            method: 'GET',
            headers: { Authorization: `Bearer ${token}` },
        });
        return await handleResponse(response);
    } catch (error) {
        console.error('getUserInfo:', error);
        throw error;
    }
};
