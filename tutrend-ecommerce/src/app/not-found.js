
"use client";
import Link from "next/link";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";

export default function NotFound() {
    return (
        <div style={{
            minHeight: "80vh", display: "flex", flexDirection: "column",
            alignItems: "center", justifyContent: "center"
        }}>
            <Typography variant="h3" color="error" gutterBottom>404</Typography>
            <Typography variant="h6" gutterBottom>
                Üzgünüz, aradığınız sayfa bulunamadı.
            </Typography>
            <Link href="/" passHref>
                <Button variant="contained" color="primary">Anasayfaya Dön</Button>
            </Link>
        </div>
    );
}
