export async function fetchFavorites() {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/favorites", {
        headers: { Authorization: `Bearer ${token}` },
    });
    if (!res.ok) throw new Error("Favoriler yüklenemedi");
    return res.json();
}

export async function addFavorite(productId) {
    const token = localStorage.getItem("token");
    const res = await fetch("/api/favorites", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({ product_id: productId }),
    });
    if (!res.ok) throw new Error("Favori eklenemedi");
}

export async function removeFavorite(productId) {
    const token = localStorage.getItem("token");
    const res = await fetch(`/api/favorites/${productId}`, {
        method: "DELETE",
        headers: { Authorization: `Bearer ${token}` },
    });
    if (!res.ok) throw new Error("Favori silinemedi");
}
