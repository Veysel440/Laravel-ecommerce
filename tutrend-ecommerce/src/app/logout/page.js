
import { useRouter } from "next/navigation";

export default function LogoutPage() {
    const router = useRouter();

    useEffect(() => {
        localStorage.removeItem("token");
        router.push("/login");
    }, [router]);

    return <p>Çıkış yapılıyor...</p>;
}
