"use client";
import { useState, useEffect, useContext } from "react";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import TextField from "@mui/material/TextField";
import Divider from "@mui/material/Divider";
import { fetchUserOrders, fetchUserProfile, updateUserProfile, updateUserPassword } from "../../lib/userApi";
import { AuthContext } from "../../contexts/AuthContext";
import { ProfilePageContainer } from "../../styles/ProfilePageStyled";
import { toast } from "react-toastify";

export default function ProfilePage() {
    const { user, setUser } = useContext(AuthContext);
    const [orders, setOrders] = useState([]);
    const [profileForm, setProfileForm] = useState({ name: "", address: "" });
    const [passwordForm, setPasswordForm] = useState({ password: "", newPassword: "" });

    useEffect(() => {
        if (user) {
            setProfileForm({ name: user.name, address: user.address || "" });
            fetchUserOrders().then(setOrders);
        } else {
            fetchUserProfile().then(u => {
                setUser(u);
                setProfileForm({ name: u.name, address: u.address || "" });
                fetchUserOrders().then(setOrders);
            });
        }
    }, [user, setUser]);


    const handleProfileSave = async () => {
        try {
            await updateUserProfile(profileForm);
            toast.success("Profil güncellendi!");
        } catch {
            toast.error("Profil güncellenemedi.");
        }
    };


    const handlePasswordSave = async () => {
        try {
            await updateUserPassword(passwordForm);
            toast.success("Parola güncellendi!");
            setPasswordForm({ password: "", newPassword: "" });
        } catch {
            toast.error("Parola güncellenemedi.");
        }
    };

    return (
        <ProfilePageContainer>
            <Typography variant="h5" sx={{ mb: 2 }}>
                Hesabım
            </Typography>

            <Divider sx={{ my: 2 }}>Profil Bilgileri</Divider>
            <TextField
                label="Ad Soyad"
                value={profileForm.name}
                onChange={e => setProfileForm(f => ({ ...f, name: e.target.value }))}
                sx={{ mb: 2 }}
                fullWidth
            />
            <TextField
                label="Adres"
                value={profileForm.address}
                onChange={e => setProfileForm(f => ({ ...f, address: e.target.value }))}
                sx={{ mb: 2 }}
                fullWidth
            />
            <Button variant="contained" color="primary" onClick={handleProfileSave}>
                Kaydet
            </Button>

            <Divider sx={{ my: 3 }}>Şifre Değiştir</Divider>
            <TextField
                label="Eski Şifre"
                type="password"
                value={passwordForm.password}
                onChange={e => setPasswordForm(f => ({ ...f, password: e.target.value }))}
                sx={{ mb: 2 }}
                fullWidth
            />
            <TextField
                label="Yeni Şifre"
                type="password"
                value={passwordForm.newPassword}
                onChange={e => setPasswordForm(f => ({ ...f, newPassword: e.target.value }))}
                sx={{ mb: 2 }}
                fullWidth
            />
            <Button variant="contained" color="secondary" onClick={handlePasswordSave}>
                Parola Güncelle
            </Button>

            <Divider sx={{ my: 3 }}>Sipariş Geçmişi</Divider>
            {orders.length === 0 ? (
                <Typography>Siparişiniz yok.</Typography>
            ) : (
                orders.map((order) => (
                    <div key={order.id} style={{
                        padding: 10,
                        marginBottom: 7,
                        border: "1px solid #eee",
                        borderRadius: 8
                    }}>
                        <Typography>
                            <b>Sipariş #{order.id}</b> — {order.status} — {order.total_price} ₺
                        </Typography>
                        <Typography sx={{ fontSize: 14 }}>
                            Tarih: {order.created_at}
                        </Typography>
                    </div>
                ))
            )}
        </ProfilePageContainer>
    );
}
