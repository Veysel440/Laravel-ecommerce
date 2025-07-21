import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api';

export const fetchProducts = async () => {
    try {
        const response = await axios.get(`${API_BASE_URL}/products`);
        return response.data.data;
    } catch (error) {
        console.error('Ürünler yüklenemedi.', error);
        throw error;
    }
};

export const fetchProductDetail = async (id) => {
    try {
        const response = await axios.get(`${API_BASE_URL}/products/${id}`);
        return response.data.data;
    } catch (error) {
        console.error('Ürün detayı getirilemedi.', error);
        throw error;
    }
};
