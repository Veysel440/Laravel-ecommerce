'use client';

import Link from 'next/link';

export default function OrderSuccessPage() {
    return (
        <div>
            <h1>🎉 Siparişiniz Alındı!</h1>
            <p>Teşekkür ederiz. Siparişiniz alınmıştır.</p>

            <Link href="/">Anasayfa</Link> | <Link href="/my-orders">Siparişlerim</Link>
        </div>
    );
}
