import { styled, alpha } from "@mui/material/styles";
import AppBar from "@mui/material/AppBar";
import InputBase from "@mui/material/InputBase";

export const StyledAppBar = styled(AppBar)(({ theme }) => ({
    background: "#fff",
    color: "#333",
    boxShadow: "0 2px 8px rgba(0,0,0,0.03)",
}));

export const Search = styled("div")(({ theme }) => ({
    position: "relative",
    borderRadius: theme.shape.borderRadius,
    backgroundColor: alpha(theme.palette.primary.main, 0.12),
    "&:hover": {
        backgroundColor: alpha(theme.palette.primary.main, 0.24),
    },
    marginLeft: 0,
    width: "100%",
    [theme.breakpoints.up("sm")]: { width: "auto" },
}));

export const StyledInputBase = styled(InputBase)(({ theme }) => ({
    color: "inherit",
    width: "100%",
    "& .MuiInputBase-input": {
        padding: theme.spacing(1, 1, 1, 0),
        paddingLeft: `calc(1em + ${theme.spacing(4)})`,
        transition: theme.transitions.create("width"),
        width: "16ch",
        [theme.breakpoints.up("sm")]: { width: "26ch" },
    },
}));
