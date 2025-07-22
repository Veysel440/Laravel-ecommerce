'use client';

import Link from 'next/link';

export default function AdminDashboardPage() {
    return (
        <div>
            <h1>Admin Paneli</h1>

            <ul>
                <li><Link href="/admin/products">Ürün Yönetimi</Link></li>
                <li><Link href="/admin/orders">Sipariş Yönetimi</Link></li>
                <li><Link href="/admin/users">Kullanıcı Yönetimi</Link></li>
            </ul>
        </div>
    );
}
