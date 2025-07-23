"use client";
import { useState, useContext, useEffect } from "react";
import { SearchContext } from "../contexts/SearchContext";
import { CategoryContext } from "../contexts/CategoryContext";
import { fetchProducts } from "../lib/productApi";
import ProductCard from "../components/ProductCard";
import Pagination from "../components/Pagination";
import SimpleCarousel from "../components/SimpleCarousel";
import CategoryBar from "../components/CategoryBar";
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";

export default function HomePage() {
    const [products, setProducts] = useState([]);
    const { searchText } = useContext(SearchContext);
    const { selectedCategory } = useContext(CategoryContext);


    const [currentPage, setCurrentPage] = useState(1);
    const productsPerPage = 12;

    useEffect(() => {
        fetchProducts().then(setProducts).catch(() => alert("Ürünler yüklenemedi."));
    }, []);


    const filteredProducts = products.filter((p) =>
        (selectedCategory === "Tümü" || p.category === selectedCategory) &&
        p.name.toLowerCase().includes(searchText.toLowerCase())
    );

    
    const paginatedProducts = filteredProducts.slice(
        (currentPage - 1) * productsPerPage,
        currentPage * productsPerPage
    );

    useEffect(() => { window.scrollTo(0, 0); }, [currentPage]);

    return (
        <>
            <SimpleCarousel />
            <CategoryBar />
            <Typography variant="h4" align="center" sx={{ my: 3 }}>
                Ürünler
            </Typography>
            <Pagination
                currentPage={currentPage}
                totalPages={Math.ceil(filteredProducts.length / productsPerPage)}
                onPageChange={setCurrentPage}
            />
            <Box
                sx={{
                    display: 'flex',
                    flexWrap: 'wrap',
                    gap: 3,
                    justifyContent: 'center'
                }}
            >
                {paginatedProducts.map((product) => (
                    <ProductCard key={product.id} product={product} />
                ))}
            </Box>
            <Pagination
                currentPage={currentPage}
                totalPages={Math.ceil(filteredProducts.length / productsPerPage)}
                onPageChange={setCurrentPage}
            />
        </>
    );
}
