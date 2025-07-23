"use client";

import Link from "next/link";

export default function AdminDashboardPage() {
    return (
        <div>
            <h1 style={{ textAlign: "center" }}>Admin Paneli</h1>
            <div style={{
                display: 'flex', flexDirection: 'column', alignItems: 'center', marginTop: 40, gap: 20
            }}>
                <Link href="/admin/products"><button>Ürün Yönetimi</button></Link>
                <Link href="/admin/orders"><button>Sipariş Yönetimi</button></Link>
                <Link href="/admin/users"><button>Kullanıcı Yönetimi</button></Link>
            </div>
        </div>
    );
}
