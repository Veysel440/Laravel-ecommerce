import { styled } from "@mui/material/styles";
import Paper from "@mui/material/Paper";

export const ProfileContainer = styled(Paper)(({ theme }) => ({
    maxWidth: 500,
    margin: "40px auto",
    padding: theme.spacing(4),
    borderRadius: 14,
    boxShadow: "0 2px 8px rgba(0,0,0,0.09)",
    background: "#fff",
}));
