import { Link } from 'react-router-dom';

export default function ProductCard({ product }) {
    return (
        <div style={{ border: '1px solid #ddd', padding: '10px', margin: '10px' }}>
            <h2>
                <Link to={`/products/${product.id}`}>{product.name}</Link>
            </h2>
            <p>{product.description}</p>
            <p>Fiyat: {product.price} ₺</p>
        </div>
    );
}
