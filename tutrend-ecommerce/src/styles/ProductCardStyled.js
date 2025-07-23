import { styled } from "@mui/material/styles";
import Card from "@mui/material/Card";
import CardMedia from "@mui/material/CardMedia";
import CardContent from "@mui/material/CardContent";
import CardActions from "@mui/material/CardActions";
import IconButton from "@mui/material/IconButton";

export const StyledCard = styled(Card)(({ theme }) => ({
    maxWidth: 290,
    minHeight: 380,
    margin: theme.spacing(2),
    position: "relative",
    borderRadius: 12,
    boxShadow: "0 2px 16px rgba(0,0,0,0.08)",
    border: "1px solid #eee",
}));

export const StyledMedia = styled(CardMedia)(({ theme }) => ({
    objectFit: "contain",
    padding: theme.spacing(2),
    background: "#f5f5f5",
}));

export const FavoriteBtn = styled(IconButton)(({ theme }) => ({
    position: "absolute",
    top: 10,
    right: 12,
    zIndex: 2,
}));

export const StyledCardContent = styled(CardContent)(({ theme }) => ({
    minHeight: 100,
}));

export const StyledCardActions = styled(CardActions)(({ theme }) => ({
    padding: theme.spacing(1, 2),
}));
