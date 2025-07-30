"use client";
import { useEffect, useState } from "react";
import {
    fetchShippingCompanies,
    createShippingCompany,
    updateShippingCompany,
    deleteShippingCompany
} from "../../../lib/adminApi";
import Button from "@mui/material/Button";
import TextField from "@mui/material/TextField";

export default function AdminShippingPage() {
    const [companies, setCompanies] = useState([]);
    const [newCompany, setNewCompany] = useState({ name: "", cost: "", status: "active" });

    useEffect(() => {
        fetchShippingCompanies().then(setCompanies);
    }, []);

    const handleCreate = async () => {
        await createShippingCompany(newCompany);
        fetchShippingCompanies().then(setCompanies);
        setNewCompany({ name: "", cost: "", status: "active" });
    };

    const handleDelete = async (id) => {
        await deleteShippingCompany(id);
        fetchShippingCompanies().then(setCompanies);
    };

    return (
        <div>
            <h1>Kargo Şirketleri</h1>
            <div>
                <TextField label="Adı" value={newCompany.name}
                           onChange={e => setNewCompany({ ...newCompany, name: e.target.value })} />
                <TextField label="Ücret" value={newCompany.cost}
                           onChange={e => setNewCompany({ ...newCompany, cost: e.target.value })} />
                <Button variant="contained" onClick={handleCreate}>Ekle</Button>
            </div>
            <ul>
                {companies.map(c => (
                    <li key={c.id}>
                        {c.name} – {c.cost}₺ – {c.status}
                        <Button color="error" onClick={() => handleDelete(c.id)}>Sil</Button>
                    </li>
                ))}
            </ul>
        </div>
    );
}
