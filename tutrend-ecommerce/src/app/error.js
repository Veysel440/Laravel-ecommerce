
"use client";
import { useEffect } from "react";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";

export default function GlobalError({ error, reset }) {
    useEffect(() => {
        // Hata loglama vs.
        // örn: Sentry, console.log(error)
    }, [error]);

    return (
        <div style={{
            minHeight: "80vh", display: "flex", flexDirection: "column",
            alignItems: "center", justifyContent: "center"
        }}>
            <Typography variant="h3" color="error" gutterBottom>500</Typography>
            <Typography variant="h6" gutterBottom>
                Beklenmeyen bir hata oluştu.
            </Typography>
            <Button variant="contained" color="primary" onClick={reset}>
                Yeniden Dene
            </Button>
        </div>
    );
}
