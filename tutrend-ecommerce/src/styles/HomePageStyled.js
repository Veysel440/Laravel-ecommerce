import { styled } from "@mui/material/styles";
import Box from "@mui/material/Box";

export const HomeContainer = styled(Box)(({ theme }) => ({
    maxWidth: 1320,
    margin: "0 auto",
    padding: theme.spacing(4, 2, 4, 2),
}));

export const ProductListGrid = styled("div")(({ theme }) => ({
    display: "flex",
    flexWrap: "wrap",
    gap: 20,
    justifyContent: "center",
}));
