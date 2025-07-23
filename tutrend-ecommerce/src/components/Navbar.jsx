"use client";
import Box from "@mui/material/Box";
import Toolbar from "@mui/material/Toolbar";
import Typography from "@mui/material/Typography";
import IconButton from "@mui/material/IconButton";
import Badge from "@mui/material/Badge";
import SearchIcon from "@mui/icons-material/Search";
import ShoppingCartIcon from "@mui/icons-material/ShoppingCart";
import FavoriteIcon from "@mui/icons-material/Favorite";
import LoginIcon from "@mui/icons-material/Login";
import Link from "next/link";
import { useContext } from "react";
import { SearchContext } from "../contexts/SearchContext";
import { CartContext } from "../contexts/CartContext";
import { FavoriteContext } from "../contexts/FavoriteContext";
import { AuthContext } from "../contexts/AuthContext";
import { StyledAppBar, Search, StyledInputBase } from "../styles/NavbarStyled";

export default function Navbar() {
    const { searchText, setSearchText } = useContext(SearchContext);
    const { cartItems } = useContext(CartContext);
    const { favorites } = useContext(FavoriteContext);
    const { user } = useContext(AuthContext);

    return (
        <Box sx={{ flexGrow: 1, marginBottom: 4 }}>
            <StyledAppBar position="static" elevation={1}>
                <Toolbar>
                    <Link href="/" style={{ textDecoration: "none", color: "inherit" }}>
                        <Typography variant="h6" noWrap sx={{ flexGrow: 1, fontWeight: 700, mr: 2 }}>
                            <span style={{ color: "#ff6600" }}>TuTrend</span>
                        </Typography>
                    </Link>

                    <Search>
                        <IconButton sx={{ position: "absolute", left: 4, top: 2, color: "#888" }}>
                            <SearchIcon />
                        </IconButton>
                        <StyledInputBase
                            placeholder="Ürün Ara…"
                            inputProps={{ "aria-label": "search" }}
                            value={searchText}
                            onChange={e => setSearchText(e.target.value)}
                        />
                    </Search>

                    <Box sx={{ flexGrow: 1 }} />

                    <Link href="/favorites">
                        <IconButton color="inherit" sx={{ mx: 1 }}>
                            <Badge badgeContent={favorites.length} color="error">
                                <FavoriteIcon />
                            </Badge>
                        </IconButton>
                    </Link>

                    <Link href="/cart">
                        <IconButton color="inherit" sx={{ mx: 1 }}>
                            <Badge badgeContent={cartItems.length} color="primary">
                                <ShoppingCartIcon />
                            </Badge>
                        </IconButton>
                    </Link>

                    {user ? (
                        <Link href="/profile">
                            <IconButton color="inherit" sx={{ mx: 1 }}>
                                <Typography>{user.name}</Typography>
                            </IconButton>
                        </Link>
                    ) : (
                        <Link href="/login">
                            <IconButton color="inherit" sx={{ mx: 1 }}>
                                <LoginIcon />
                            </IconButton>
                        </Link>
                    )}
                </Toolbar>
            </StyledAppBar>
        </Box>
    );
}
