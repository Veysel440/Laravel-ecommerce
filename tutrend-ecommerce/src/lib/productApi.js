export const fetchProductDetail = async (id) => {
    const res = await fetch(`http://localhost:8000/api/products/${id}`, {
        cache: 'no-store'
    });
    if (!res.ok) throw new Error('Ürün detayı getirilemedi.');
    const data = await res.json();
    return data.data;
};

export const fetchProducts = async () => {
    const response = await fetch('http://localhost:8000/api/products');

    if (!response.ok) throw new Error('Ürünler alınamadı.');

    const data = await response.json();
    return data.data;
};
