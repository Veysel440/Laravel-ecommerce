import { styled } from "@mui/material/styles";
import Paper from "@mui/material/Paper";

export const AdminDashboardContainer = styled(Paper)(({ theme }) => ({
    maxWidth: 1100,
    margin: "40px auto",
    padding: theme.spacing(4),
    borderRadius: 16,
    background: "#fff",
    boxShadow: "0 2px 12px rgba(0,0,0,0.09)",
}));
