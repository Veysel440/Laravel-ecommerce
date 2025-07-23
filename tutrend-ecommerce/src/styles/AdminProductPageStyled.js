import { styled } from "@mui/material/styles";
import Paper from "@mui/material/Paper";

export const AdminProductsContainer = styled(Paper)(({ theme }) => ({
    maxWidth: 1000,
    margin: "40px auto",
    padding: theme.spacing(4),
    borderRadius: 14,
    boxShadow: "0 2px 8px rgba(0,0,0,0.10)",
    background: "#fff",
}));
