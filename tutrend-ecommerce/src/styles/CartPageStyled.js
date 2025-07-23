import { styled } from "@mui/material/styles";
import Paper from "@mui/material/Paper";
import Box from "@mui/material/Box";

export const CartContainer = styled(Box)(({ theme }) => ({
    maxWidth: 800,
    margin: "40px auto",
    background: "#fff",
    padding: theme.spacing(4),
    borderRadius: theme.shape.borderRadius,
    boxShadow: "0 2px 8px rgba(0,0,0,0.07)",
}));

export const CartItemPaper = styled(Paper)(({ theme }) => ({
    display: "flex",
    alignItems: "center",
    padding: theme.spacing(2),
    marginBottom: theme.spacing(2),
    borderRadius: 10,
    gap: 24,
}));
