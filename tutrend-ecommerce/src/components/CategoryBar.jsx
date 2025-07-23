import { useContext } from "react";
import { CategoryContext } from "../contexts/CategoryContext";
import "../styles/CategoryBar.css";

const categories = [
    "Tümü",
    "Kadın",
    "Erkek",
    "Elektronik",
    "Ev & Yaşam",
    "Kozmetik",
    "Spor",
];

export default function CategoryBar() {
    const { selectedCategory, setSelectedCategory } = useContext(CategoryContext);

    return (
        <div className="category-bar">
            {categories.map((cat) => (
                <button
                    key={cat}
                    className={`category-button${selectedCategory === cat ? " active" : ""}`}
                    onClick={() => setSelectedCategory(cat)}
                >
                    {cat}
                </button>
            ))}
        </div>
    );
}
