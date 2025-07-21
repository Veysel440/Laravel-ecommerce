import { useContext, useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import { fetchProductDetail } from '../api/productApi';
import { addToCart } from '../api/cartApi';
import { AuthContext } from '../contexts/AuthContext';

export default function ProductDetail() {
    const { id } = useParams();
    const [product, setProduct] = useState(null);
    const { token } = useContext(AuthContext);

    useEffect(() => {
        fetchProductDetail(id)
            .then(setProduct)
            .catch(() => alert('Ürün detay yüklenemedi.'));
    }, [id]);

    const handleAddToCart = async () => {
        try {
            await addToCart(token, product.id);
            alert('Sepete eklendi!');
        } catch {
            alert('Sepete eklenemedi.');
        }
    };

    if (!product) return <p>Yükleniyor...</p>;

    return (
        <div>
            <h1>{product.name}</h1>
            <p>{product.description}</p>
            <button onClick={handleAddToCart}>Sepete Ekle</button>
        </div>
    );
}
