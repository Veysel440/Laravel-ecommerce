"use client";
import Typography from "@mui/material/Typography";
import { useContext } from "react";
import { FavoriteContext } from "../contexts/FavoriteContext";
import ProductCard from "./ProductCard";
import { FavoritesContainer } from "../styles/FavoritesPageStyled";

export default function FavoritesPage() {
    const { favorites } = useContext(FavoriteContext);

    return (
        <FavoritesContainer>
            <Typography variant="h5" align="center" sx={{ mb: 3 }}>
                Favorilerim
            </Typography>
            {favorites.length === 0 ? (
                <Typography align="center">Hiç favoriniz yok.</Typography>
            ) : (
                <div style={{
                    display: "flex", flexWrap: "wrap", gap: 24, justifyContent: "center"
                }}>
                    {favorites.map((p) => (
                        <ProductCard key={p.id} product={p} />
                    ))}
                </div>
            )}
        </FavoritesContainer>
    );
}
