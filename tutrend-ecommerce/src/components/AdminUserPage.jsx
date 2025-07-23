"use client";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import { useEffect, useState } from "react";
import { fetchUsers } from "../lib/adminApi";
import { AdminUserContainer } from "../styles/AdminUserPageStyled";

export default function AdminUserPage() {
    const [users, setUsers] = useState([]);

    useEffect(() => {
        const token = localStorage.getItem("token");
        fetchUsers(token).then(setUsers);
    }, []);

    return (
        <AdminUserContainer>
            <Typography variant="h5" sx={{ mb: 3 }}>
                Admin Kullanıcı Yönetimi
            </Typography>
            {users.length === 0 ? (
                <Typography>Hiç kullanıcı yok.</Typography>
            ) : (
                users.map((u) => (
                    <div key={u.id} style={{
                        display: "flex",
                        alignItems: "center",
                        justifyContent: "space-between",
                        padding: 10,
                        borderBottom: "1px solid #eee"
                    }}>
                        <Typography>
                            {u.name} ({u.email}) - {u.userType}
                        </Typography>
                        <Button color="error">Sil</Button>
                    </div>
                ))
            )}
        </AdminUserContainer>
    );
}
