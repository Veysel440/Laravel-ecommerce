"use client";
import { createContext, useState } from "react";

export const CategoryContext = createContext();

export function CategoryProvider({ children }) {
    const [selectedCategory, setSelectedCategory] = useState("Tümü");
    return (
        <CategoryContext.Provider value={{ selectedCategory, setSelectedCategory }}>
            {children}
        </CategoryContext.Provider>
    );
}
