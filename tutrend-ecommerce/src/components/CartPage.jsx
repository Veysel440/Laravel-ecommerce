"use client";
import Typography from "@mui/material/Typography";
import IconButton from "@mui/material/IconButton";
import Button from "@mui/material/Button";
import DeleteIcon from "@mui/icons-material/Delete";
import { useContext } from "react";
import { CartContext } from "../contexts/CartContext";
import { CartContainer, CartItemPaper } from "../styles/CartPageStyled";

export default function CartPage() {
    const { cartItems, removeFromCart, clearCart } = useContext(CartContext);

    return (
        <CartContainer>
            <Typography variant="h5" sx={{ mb: 3 }}>
                Sepetim
            </Typography>
            {cartItems.length === 0 ? (
                <Typography>Sepetinizde ürün yok.</Typography>
            ) : (
                <>
                    {cartItems.map((item) => (
                        <CartItemPaper key={item.id}>
                            <img
                                src={item.image || "/placeholder.png"}
                                alt={item.name}
                                style={{ width: 90, height: 90, objectFit: "contain", background: "#fafafa", borderRadius: 8 }}
                            />
                            <div style={{ flex: 1 }}>
                                <Typography variant="subtitle1">{item.name}</Typography>
                                <Typography variant="body2" color="text.secondary">
                                    {item.price} ₺ x {item.quantity}
                                </Typography>
                            </div>
                            <IconButton color="error" onClick={() => removeFromCart(item.id)}>
                                <DeleteIcon />
                            </IconButton>
                        </CartItemPaper>
                    ))}
                    <Button variant="contained" color="error" onClick={clearCart}>
                        Sepeti Temizle
                    </Button>
                </>
            )}
        </CartContainer>
    );
}
