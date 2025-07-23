import { styled } from "@mui/material/styles";
import Paper from "@mui/material/Paper";

export const AdminUserContainer = styled(Paper)(({ theme }) => ({
    maxWidth: 900,
    margin: "40px auto",
    padding: theme.spacing(4),
    borderRadius: 14,
    boxShadow: "0 2px 12px rgba(0,0,0,0.09)",
    background: "#fff",
}));
