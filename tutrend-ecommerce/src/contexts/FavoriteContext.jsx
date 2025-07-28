import { createContext, useState, useEffect } from "react";
import { fetchFavorites, addFavorite, removeFavorite } from "../lib/favoriteApi";
import { toast } from "react-toastify";

export const FavoriteContext = createContext();

export function FavoriteProvider({ children }) {
    const [favorites, setFavorites] = useState([]);


    useEffect(() => {
        fetchFavorites()
            .then(setFavorites)
            .catch(() => toast.error("Favoriler yüklenemedi"));
    }, []);

    const handleAddFavorite = async (product) => {
        try {
            await addFavorite(product.id);
            setFavorites((prev) => [...prev, product]);
            toast.success("Favorilere eklendi!");
        } catch {
            toast.error("Favori eklenemedi");
        }
    };

    const handleRemoveFavorite = async (productId) => {
        try {
            await removeFavorite(productId);
            setFavorites((prev) => prev.filter((p) => p.id !== productId));
            toast.success("Favoriden çıkarıldı!");
        } catch {
            toast.error("Favori silinemedi");
        }
    };

    return (
        <FavoriteContext.Provider
            value={{
                favorites,
                addFavorite: handleAddFavorite,
                removeFavorite: handleRemoveFavorite,
                isFavorite: (id) => favorites.some((p) => p.id === id),
            }}
        >
            {children}
        </FavoriteContext.Provider>
    );
}
