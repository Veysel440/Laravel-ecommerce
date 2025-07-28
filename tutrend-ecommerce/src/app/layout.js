"use client";
import { ThemeProvider, CssBaseline, createTheme } from "@mui/material";
import { AuthProvider } from "../contexts/AuthContext";
import { CartProvider } from "../contexts/CartContext";
import { SearchProvider } from "../contexts/SearchContext";
import { FavoriteProvider } from "../contexts/FavoriteContext";
import { CategoryProvider } from "../contexts/CategoryContext";
import { OrderProvider } from "../contexts/OrderContext";


const theme = createTheme({
    palette: {
        primary: { main: "#ff6600" },
        secondary: { main: "#007bff" },
        background: { default: "#f9f9f9" },
    },
    shape: { borderRadius: 8 },
    typography: { fontFamily: "Roboto, Arial, sans-serif" },
});

export default function RootLayout({ children }) {
    return (
        <html lang="tr">
        <body>
        <ThemeProvider theme={theme}>
            <CssBaseline />
            <AuthProvider>
                <CartProvider>
                    <SearchProvider>
                        <FavoriteProvider>
                            <OrderProvider>
                            <CategoryProvider>
                                {children}
                            </CategoryProvider>
                            </OrderProvider>
                        </FavoriteProvider>
                    </SearchProvider>
                </CartProvider>
            </AuthProvider>
        </ThemeProvider>
        </body>
        </html>
    );
}
