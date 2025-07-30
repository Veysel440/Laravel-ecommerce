
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

export async function fetchDashboardStats() {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/admin/dashboard", {
        headers: { Authorization: `Bearer ${token}` }
    });
    return res.json();
}
export async function fetchAdminCampaigns() {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/admin/campaigns", {
        headers: { Authorization: `Bearer ${token}` },
    });
    return res.json();
}
export async function createCampaign(data) {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/admin/campaigns", {
        method: "POST",
        headers: { "Content-Type": "application/json", Authorization: `Bearer ${token}` },
        body: JSON.stringify(data),
    });
    return res.json();
}
export async function updateCampaign(id, data) {
    const token = localStorage.getItem("token");
    const res = await fetch(`/api/admin/campaigns/${id}`, {
        method: "PUT",
        headers: { "Content-Type": "application/json", Authorization: `Bearer ${token}` },
        body: JSON.stringify(data),
    });
    return res.json();
}
export async function deleteCampaign(id) {
    const token = localStorage.getItem("token");
    await fetch(`/api/admin/campaigns/${id}`, {
        method: "DELETE",
        headers: { Authorization: `Bearer ${token}` },
    });
}

export async function fetchShippingCompanies() {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/admin/shipping", {
        headers: { Authorization: `Bearer ${token}` },
    });
    if (!res.ok) throw new Error("Kargo firmaları alınamadı");
    return res.json();
}

export async function createShippingCompany(data) {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/admin/shipping", {
        method: "POST",
        headers: { "Content-Type": "application/json", Authorization: `Bearer ${token}` },
        body: JSON.stringify(data),
    });
    if (!res.ok) throw new Error("Kargo firması eklenemedi");
    return res.json();
}

export async function updateShippingCompany(id, data) {
    const token = localStorage.getItem("token");
    const res = await fetch(`/api/admin/shipping/${id}`, {
        method: "PUT",
        headers: { "Content-Type": "application/json", Authorization: `Bearer ${token}` },
        body: JSON.stringify(data),
    });
    if (!res.ok) throw new Error("Kargo firması güncellenemedi");
    return res.json();
}

export async function deleteShippingCompany(id) {
    const token = localStorage.getItem("token");
    const res = await fetch(`/api/admin/shipping/${id}`, {
        method: "DELETE",
        headers: { Authorization: `Bearer ${token}` },
    });
    if (!res.ok) throw new Error("Kargo firması silinemedi");
    return res.json();
}
