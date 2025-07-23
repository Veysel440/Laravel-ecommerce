"use client";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import { useContext, useEffect, useState } from "react";
import { useParams } from "next/navigation";
import { fetchProductById } from "../lib/productApi";
import { CartContext } from "../contexts/CartContext";
import { FavoriteContext } from "../contexts/FavoriteContext";
import { ProductDetailContainer, ProductImageBox } from "../styles/ProductDetailStyled";

export default function ProductDetail() {
    const { id } = useParams();
    const { addToCart } = useContext(CartContext);
    const { addFavorite, removeFavorite, isFavorite } = useContext(FavoriteContext);

    const [product, setProduct] = useState(null);

    useEffect(() => {
        if (id) {
            fetchProductById(id).then(setProduct);
        }
    }, [id]);

    if (!product) return <Typography>Yükleniyor...</Typography>;

    return (
        <ProductDetailContainer>
            <ProductImageBox>
                <img
                    src={product.image || "/placeholder.png"}
                    alt={product.name}
                    style={{ maxWidth: "92%", maxHeight: "92%", objectFit: "contain" }}
                />
            </ProductImageBox>
            <div style={{ flex: 1 }}>
                <Typography variant="h5" sx={{ mb: 1 }}>{product.name}</Typography>
                <Typography color="primary" sx={{ fontSize: 24, fontWeight: 600, mb: 2 }}>
                    {product.price} ₺
                </Typography>
                <Typography variant="body1" sx={{ mb: 3 }}>
                    {product.description}
                </Typography>
                <div style={{ display: "flex", gap: 14 }}>
                    <Button
                        variant="contained"
                        color="primary"
                        onClick={() => addToCart(product.id, 1)}
                    >
                        Sepete Ekle
                    </Button>
                    <Button
                        variant={isFavorite(product.id) ? "contained" : "outlined"}
                        color="error"
                        onClick={() =>
                            isFavorite(product.id)
                                ? removeFavorite(product.id)
                                : addFavorite(product)
                        }
                    >
                        {isFavorite(product.id) ? "Favoriden Çıkar" : "Favorilere Ekle"}
                    </Button>
                </div>
            </div>
        </ProductDetailContainer>
    );
}
