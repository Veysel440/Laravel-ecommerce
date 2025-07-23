"use client";
import { useContext } from "react";
import { FavoriteContext } from "../../contexts/FavoriteContext";
import ProductCard from "../../components/ProductCard";

export default function FavoritesPage() {
    const { favorites } = useContext(FavoriteContext);

    return (
        <div>
            <h1 style={{ textAlign: "center" }}>Favorilerim</h1>
            {favorites.length === 0 && <p style={{ textAlign: "center" }}>Hiç favoriniz yok.</p>}
            <div style={{ display: "flex", flexWrap: "wrap", gap: 20, justifyContent: "center" }}>
                {favorites.map((p) => (
                    <ProductCard key={p.id} product={p} />
                ))}
            </div>
        </div>
    );
}
