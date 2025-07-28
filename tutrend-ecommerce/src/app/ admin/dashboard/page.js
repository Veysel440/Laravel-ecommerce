"use client";
import { useEffect, useState } from "react";
import Typography from "@mui/material/Typography";
import Divider from "@mui/material/Divider";
import { AdminDashboardContainer } from "../../../styles/AdminDashboardStyled";
import {
    LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer, BarChart, Bar, PieChart, Pie, Cell
} from "recharts";
import { fetchDashboardStats } from "../../../lib/adminApi";

const COLORS = ["#ff6600", "#007bff", "#ffc107", "#4caf50", "#e91e63"];

export default function AdminDashboard() {
    const [stats, setStats] = useState(null);

    useEffect(() => {
        fetchDashboardStats().then(setStats);
    }, []);

    if (!stats) return <p>Yükleniyor...</p>;

    return (
        <AdminDashboardContainer>
            <Typography variant="h5" sx={{ mb: 2 }}>Yönetici Dashboard</Typography>
            <Divider sx={{ mb: 3 }} />
            <div style={{
                display: "flex",
                justifyContent: "space-between",
                gap: 32,
                flexWrap: "wrap"
            }}>
                {/* Kartlar */}
                <div>
                    <Typography variant="subtitle2" color="text.secondary">Toplam Satış</Typography>
                    <Typography variant="h6">{stats.totalSales} ₺</Typography>
                </div>
                <div>
                    <Typography variant="subtitle2" color="text.secondary">Toplam Sipariş</Typography>
                    <Typography variant="h6">{stats.totalOrders}</Typography>
                </div>
                <div>
                    <Typography variant="subtitle2" color="text.secondary">Toplam Kullanıcı</Typography>
                    <Typography variant="h6">{stats.totalUsers}</Typography>
                </div>
                <div>
                    <Typography variant="subtitle2" color="text.secondary">En Çok Satan Ürün</Typography>
                    <Typography variant="h6">{stats.bestSeller?.name || "-"}</Typography>
                </div>
            </div>

            <Divider sx={{ my: 4 }}>Aylık Satış Grafiği</Divider>
            <ResponsiveContainer width="100%" height={300}>
                <LineChart data={stats.monthlySales}>
                    <CartesianGrid strokeDasharray="3 3" />
                    <XAxis dataKey="month" />
                    <YAxis />
                    <Tooltip />
                    <Legend />
                    <Line type="monotone" dataKey="sales" stroke="#ff6600" />
                </LineChart>
            </ResponsiveContainer>

            <Divider sx={{ my: 4 }}>Sipariş Dağılımı (Pie)</Divider>
            <ResponsiveContainer width="100%" height={240}>
                <PieChart>
                    <Pie
                        data={stats.orderStatusPie}
                        dataKey="value"
                        nameKey="status"
                        cx="50%"
                        cy="50%"
                        outerRadius={80}
                        fill="#8884d8"
                        label
                    >
                        {stats.orderStatusPie.map((entry, index) => (
                            <Cell key={entry.status} fill={COLORS[index % COLORS.length]} />
                        ))}
                    </Pie>
                    <Tooltip />
                </PieChart>
            </ResponsiveContainer>

            <Divider sx={{ my: 4 }}>En Çok Satan Ürünler</Divider>
            <ResponsiveContainer width="100%" height={260}>
                <BarChart data={stats.topProducts}>
                    <CartesianGrid strokeDasharray="3 3" />
                    <XAxis dataKey="name" />
                    <YAxis />
                    <Tooltip />
                    <Legend />
                    <Bar dataKey="sold" fill="#007bff" />
                </BarChart>
            </ResponsiveContainer>
        </AdminDashboardContainer>
    );
}
