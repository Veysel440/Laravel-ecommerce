'use client';

import '../styles/SimpleCarousel.css';

const images = [
    '/carousel1.jpg',
    '/carousel2.jpg',
    '/carousel3.jpg',
];

export default function SimpleCarousel() {
    return (
        <div className="carousel">
            {images.map((src, index) => (
                <img key={index} src={src} alt={`Slide ${index}`} className="carousel-image" />
            ))}
        </div>
    );
}
