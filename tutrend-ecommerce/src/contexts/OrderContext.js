import { createContext, useState, useEffect } from "react";
import { fetchOrders, createOrder } from "../lib/orderApi";
import { toast } from "react-toastify";

export const OrderContext = createContext();

export function OrderProvider({ children }) {
    const [orders, setOrders] = useState([]);

    useEffect(() => {
        fetchOrders()
            .then(setOrders)
            .catch(() => toast.error("Siparişler yüklenemedi"));
    }, []);

    const handleCreateOrder = async (orderData) => {
        try {
            const newOrder = await createOrder(orderData);
            setOrders((prev) => [...prev, newOrder]);
            toast.success("Sipariş oluşturuldu!");
        } catch {
            toast.error("Sipariş oluşturulamadı");
        }
    };

    return (
        <OrderContext.Provider value={{ orders, createOrder: handleCreateOrder }}>
            {children}
        </OrderContext.Provider>
    );
}
