"use client";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import { useContext } from "react";
import { AuthContext } from "../contexts/AuthContext";
import { ProfileContainer } from "../styles/ProfilePageStyled";

export default function ProfilePage() {
    const { user, logout } = useContext(AuthContext);

    if (!user) return <Typography>Oturum açılmamış.</Typography>;

    return (
        <ProfileContainer>
            <Typography variant="h5" sx={{ mb: 2 }}>
                Profilim
            </Typography>
            <Typography>Ad Soyad: {user.name}</Typography>
            <Typography>E-posta: {user.email}</Typography>
            <Typography>Kullanıcı Tipi: {user.userType}</Typography>
            <Button variant="outlined" color="error" sx={{ mt: 3 }} onClick={logout}>
                Çıkış Yap
            </Button>
        </ProfileContainer>
    );
}
