import { styled } from "@mui/material/styles";
import Box from "@mui/material/Box";

export const FavoritesContainer = styled(Box)(({ theme }) => ({
    maxWidth: 1100,
    margin: "40px auto",
    padding: theme.spacing(3),
    background: "#fff",
    borderRadius: 14,
    boxShadow: "0 2px 10px rgba(0,0,0,0.07)",
}));
