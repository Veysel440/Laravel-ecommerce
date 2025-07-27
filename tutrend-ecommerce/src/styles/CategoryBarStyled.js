import { styled } from "@mui/material/styles";
import Box from "@mui/material/Box";

export const FilterPanel = styled(Box)(({ theme }) => ({
    display: "flex",
    gap: 24,
    alignItems: "center",
    padding: theme.spacing(2),
    background: "#fff",
    borderRadius: 10,
    boxShadow: "0 2px 6px rgba(0,0,0,0.04)",
    margin: "0 auto",
    maxWidth: 1100,
    marginTop: 20
}));
