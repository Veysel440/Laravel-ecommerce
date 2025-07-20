<h2>Siparişiniz Tamamlandı!</h2>

<p>Sayın {{ $order->user->name }},</p>

<p>Siparişiniz başarıyla oluşturuldu. Sipariş Numaranız: {{ $order->id }}</p>

<p>Toplam Tutar: {{ $order->total_price }}₺</p>

<p>Teşekkür ederiz!</p>
