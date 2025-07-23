import Button from "@mui/material/Button";
import Typography from "@mui/material/Typography";
import FavoriteIcon from "@mui/icons-material/Favorite";
import { useContext } from "react";
import { CartContext } from "../contexts/CartContext";
import { FavoriteContext } from "../contexts/FavoriteContext";
import {
    StyledCard,
    StyledMedia,
    FavoriteBtn,
    StyledCardContent,
    StyledCardActions,
} from "../styles/ProductCardStyled";

export default function ProductCard({ product }) {
    const { addToCart } = useContext(CartContext);
    const { addFavorite, removeFavorite, isFavorite } = useContext(FavoriteContext);

    return (
        <StyledCard>
            <StyledMedia
                component="img"
                height="180"
                image={product.image || "/placeholder.png"}
                alt={product.name}
            />
            <FavoriteBtn
                onClick={() =>
                    isFavorite(product.id)
                        ? removeFavorite(product.id)
                        : addFavorite(product)
                }
                color={isFavorite(product.id) ? "error" : "default"}
            >
                <FavoriteIcon />
            </FavoriteBtn>
            <StyledCardContent>
                <Typography gutterBottom variant="h6" component="div" noWrap>
                    {product.name}
                </Typography>
                <Typography variant="body2" color="text.secondary" sx={{ minHeight: 38 }}>
                    {product.description?.slice(0, 55) || ""}
                </Typography>
                <Typography variant="subtitle1" color="primary" sx={{ mt: 1 }}>
                    {product.price} ₺
                </Typography>
            </StyledCardContent>
            <StyledCardActions>
                <Button
                    variant="contained"
                    color="primary"
                    fullWidth
                    onClick={() => addToCart(product.id, 1)}
                >
                    Sepete Ekle
                </Button>
            </StyledCardActions>
        </StyledCard>
    );
}
