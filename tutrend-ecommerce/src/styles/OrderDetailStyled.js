import { styled } from "@mui/material/styles";
import Paper from "@mui/material/Paper";

export const OrderDetailContainer = styled(Paper)(({ theme }) => ({
    maxWidth: 600,
    margin: "40px auto",
    padding: theme.spacing(4),
    borderRadius: 14,
    boxShadow: "0 2px 10px rgba(0,0,0,0.07)",
    background: "#fff",
}));
