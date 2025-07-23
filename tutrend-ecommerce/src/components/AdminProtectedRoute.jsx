"use client";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import { useEffect, useState } from "react";
import { fetchAdminProducts } from "../lib/adminApi";
import { AdminProductsContainer } from "../styles/AdminProductPageStyled";

export default function AdminProductsPage() {
    const [products, setProducts] = useState([]);

    useEffect(() => {
        const token = localStorage.getItem('token');
        fetchAdminProducts(token).then(setProducts);
    }, []);

    return (
        <AdminProductsContainer>
            <Typography variant="h5" sx={{ mb: 3 }}>
                Admin Ürün Yönetimi
            </Typography>
            {/* Ürünler listesi burada */}
            {products.length === 0 ? (
                <Typography>Hiç ürün yok.</Typography>
            ) : (
                products.map((p) => (
                    <div key={p.id} style={{
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'space-between',
                        padding: 10,
                        borderBottom: '1px solid #eee'
                    }}>
                        <Typography>{p.name} - {p.price} ₺</Typography>
                        <Button color="error">Sil</Button>
                    </div>
                ))
            )}
        </AdminProductsContainer>
    );
}
