import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api';

export const registerUser = async (data) => {
    return axios.post(`${API_BASE_URL}/auth/register`, data);
};

export const loginUser = async (data) => {
    return axios.post(`${API_BASE_URL}/auth/login`, data, {
        withCredentials: true,
    });
};

export const getUserInfo = async (token) => {
    return axios.get(`${API_BASE_URL}/auth/me`, {
        headers: { Authorization: `Bearer ${token}` },
    });
};
