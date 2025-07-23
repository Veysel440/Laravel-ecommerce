import { styled } from "@mui/material/styles";
import Paper from "@mui/material/Paper";
import Box from "@mui/material/Box";

export const ProductDetailContainer = styled(Paper)(({ theme }) => ({
    maxWidth: 900,
    margin: "40px auto",
    padding: theme.spacing(4),
    borderRadius: 14,
    boxShadow: "0 2px 10px rgba(0,0,0,0.07)",
    display: "flex",
    gap: 36,
    background: "#fff",
}));

export const ProductImageBox = styled(Box)(({ theme }) => ({
    width: 340,
    height: 340,
    background: "#fafafa",
    display: "flex",
    alignItems: "center",
    justifyContent: "center",
    borderRadius: 12,
    boxShadow: "0 1px 5px rgba(0,0,0,0.05)",
}));
