"use client";
import Typography from "@mui/material/Typography";
import { useEffect, useState } from "react";
import { useParams } from "next/navigation";
import { fetchOrderById } from "../lib/orderApi";
import { OrderDetailContainer } from "../styles/OrderDetailStyled";

export default function OrderDetail() {
    const { id } = useParams();
    const [order, setOrder] = useState(null);

    useEffect(() => {
        if (id) fetchOrderById(id).then(setOrder);
    }, [id]);

    if (!order) return <Typography>Yükleniyor...</Typography>;

    return (
        <OrderDetailContainer>
            <Typography variant="h5" sx={{ mb: 2 }}>
                Sipariş Detayı #{order.id}
            </Typography>
            <Typography sx={{ mb: 1 }}>Tarih: {order.created_at}</Typography>
            <Typography sx={{ mb: 2 }}>Durum: {order.status}</Typography>
            <Typography sx={{ fontWeight: 500, mb: 1 }}>Ürünler:</Typography>
            {order.items.map((item) => (
                <div key={item.id} style={{ marginBottom: 10 }}>
                    <Typography>
                        {item.product.name} × {item.quantity} — {item.product.price} ₺
                    </Typography>
                </div>
            ))}
            <Typography sx={{ mt: 2, fontWeight: 700 }}>
                Toplam: {order.total_price} ₺
            </Typography>
        </OrderDetailContainer>
    );
}
