import { styled } from "@mui/material/styles";
import Paper from "@mui/material/Paper";

export const ProfilePageContainer = styled(Paper)(({ theme }) => ({
    maxWidth: 700,
    margin: "40px auto",
    padding: theme.spacing(4),
    borderRadius: 16,
    boxShadow: "0 2px 12px rgba(0,0,0,0.10)",
    background: "#fff",
}));
