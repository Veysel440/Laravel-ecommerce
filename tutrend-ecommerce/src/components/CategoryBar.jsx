'use client';

import '../styles/CategoryBar.css';

const categories = [
    'Kadın',
    'Erkek',
    'Elektronik',
    'Ev & Yaşam',
    'Kozmetik',
    'Spor',
];

export default function CategoryBar() {
    return (
        <div className="category-bar">
            {categories.map((cat) => (
                <button key={cat} className="category-button">
                    {cat}
                </button>
            ))}
        </div>
    );
}
