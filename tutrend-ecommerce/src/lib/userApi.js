export async function fetchUserProfile() {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/profile", {
        headers: { Authorization: `Bearer ${token}` }
    });
    return res.json();
}

export async function updateUserProfile(data) {
    const token = localStorage.getItem("token");
    await fetch("/api/profile", {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`
        },
        body: JSON.stringify(data)
    });
}

export async function updateUserPassword(data) {
    const token = localStorage.getItem("token");
    await fetch("/api/profile/password", {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`
        },
        body: JSON.stringify(data)
    });
}

export async function fetchUserOrders() {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/orders", {
        headers: { Authorization: `Bearer ${token}` }
    });
    return res.json();
}
