import Link from 'next/link';
import '../styles/ProductCard.css';

export default function ProductCard({ product }) {
    return (
        <div className="product-card">
            <Link href={`/products/${product.id}`} className="product-link">
                {product.image ? (
                    <img src={product.image} alt={product.name} className="product-image" />
                ) : (
                    <div className="product-placeholder"></div>
                )}

                <div className="product-details">
                    <h3>{product.name}</h3>
                    <p className="price">{product.price} ₺</p>
                    <button className="buy-button">Detayları Gör</button>
                </div>
            </Link>
        </div>
    );
}
