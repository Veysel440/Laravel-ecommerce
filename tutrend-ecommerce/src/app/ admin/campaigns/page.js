"use client";
import { useEffect, useState } from "react";
import {
    fetchAdminCampaigns, createCampaign, updateCampaign, deleteCampaign
} from "../../../lib/adminApi";
import Button from "@mui/material/Button";
import TextField from "@mui/material/TextField";

export default function AdminCampaignsPage() {
    const [campaigns, setCampaigns] = useState([]);
    const [newCampaign, setNewCampaign] = useState({
        title: "", discount_rate: "", start_date: "", end_date: ""
    });

    useEffect(() => {
        fetchAdminCampaigns().then(setCampaigns);
    }, []);

    const handleCreate = async () => {
        await createCampaign(newCampaign);
        fetchAdminCampaigns().then(setCampaigns);
        setNewCampaign({ title: "", discount_rate: "", start_date: "", end_date: "" });
    };

    const handleDelete = async (id) => {
        await deleteCampaign(id);
        fetchAdminCampaigns().then(setCampaigns);
    };

    // handleUpdate fonksiyonunu modala veya inline update formuna bağlayabilirsin.

    return (
        <div>
            <h1>Kampanyalar</h1>
            <div>
                <TextField label="Başlık" value={newCampaign.title}
                           onChange={e => setNewCampaign({ ...newCampaign, title: e.target.value })} />
                <TextField label="İndirim (%)" value={newCampaign.discount_rate}
                           onChange={e => setNewCampaign({ ...newCampaign, discount_rate: e.target.value })} />
                <TextField label="Başlangıç" type="date" value={newCampaign.start_date}
                           onChange={e => setNewCampaign({ ...newCampaign, start_date: e.target.value })} />
                <TextField label="Bitiş" type="date" value={newCampaign.end_date}
                           onChange={e => setNewCampaign({ ...newCampaign, end_date: e.target.value })} />
                <Button variant="contained" onClick={handleCreate}>Ekle</Button>
            </div>
            <ul>
                {campaigns.map(c => (
                    <li key={c.id}>
                        {c.title} – %{c.discount_rate}
                        <Button color="error" onClick={() => handleDelete(c.id)}>Sil</Button>
                    </li>
                ))}
            </ul>
        </div>
    );
}
