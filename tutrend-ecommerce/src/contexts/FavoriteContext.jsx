"use client";
import { createContext, useContext, useEffect, useState } from "react";

export const FavoriteContext = createContext();

export function FavoriteProvider({ children }) {
    const [favorites, setFavorites] = useState([]);


    useEffect(() => {
        const fav = localStorage.getItem("favorites");
        if (fav) setFavorites(JSON.parse(fav));
    }, []);

    useEffect(() => {
        localStorage.setItem("favorites", JSON.stringify(favorites));
    }, [favorites]);

    const addFavorite = (product) => {
        if (!favorites.some((p) => p.id === product.id)) {
            setFavorites([...favorites, product]);
        }
    };

    const removeFavorite = (id) => {
        setFavorites(favorites.filter((p) => p.id !== id));
    };

    const isFavorite = (id) => favorites.some((p) => p.id === id);

    return (
        <FavoriteContext.Provider value={{ favorites, addFavorite, removeFavorite, isFavorite }}>
            {children}
        </FavoriteContext.Provider>
    );
}

// Kullanmak için: const { favorites, addFavorite, removeFavorite, isFavorite } = useContext(FavoriteContext);
