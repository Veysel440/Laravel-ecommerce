import { toast } from "react-toastify";

export async function fetchWithAuth(url, options = {}) {
    const token = localStorage.getItem("token");
    const headers = {
        ...(options.headers || {}),
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
    };

    const res = await fetch(url, { ...options, headers });
    if (res.status === 401 || res.status === 403) {
        localStorage.removeItem("token");
        toast.error("Oturum süreniz doldu, lütfen tekrar giriş yapın.");
        window.location.href = "/login";
        return;
    }
    return res;
}
