"use client";
import { useState, useContext, useEffect } from "react";
import { SearchContext } from "../contexts/SearchContext";
import { CategoryContext } from "../contexts/CategoryContext";
import { fetchProducts } from "../lib/productApi";
import ProductCard from "../components/ProductCard";
import Pagination from "../components/Pagination";
import SimpleCarousel from "../components/SimpleCarousel";
import CategoryBar from "../components/CategoryBar";
import FilterPanel from "../components/FilterPanel";
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";

export default function HomePage() {
    const [products, setProducts] = useState([]);
    const { searchText } = useContext(SearchContext);
    const { selectedCategory } = useContext(CategoryContext);


    const [filtered, setFiltered] = useState([]);
    const [filterState, setFilterState] = useState({
        price: [0, 10000],
        brand: "Tümü",
        sort: "az"
    });


    const [currentPage, setCurrentPage] = useState(1);
    const productsPerPage = 12;

    useEffect(() => {
        fetchProducts().then(setProducts).catch(() => alert("Ürünler yüklenemedi."));
    }, []);


    const applyFilters = ({ price, brand, sort }) => {
        let f = [...products];


        f = f.filter((p) =>
            (selectedCategory === "Tümü" || p.category === selectedCategory)
        );


        f = f.filter(
            (p) => p.price >= price[0] && p.price <= price[1]
        );


        if (brand !== "Tümü") {
            f = f.filter((p) => p.brand === brand);
        }


        f = f.filter((p) =>
            p.name.toLowerCase().includes(searchText.toLowerCase())
        );


        if (sort === "az") f.sort((a, b) => a.name.localeCompare(b.name));
        if (sort === "za") f.sort((a, b) => b.name.localeCompare(a.name));
        if (sort === "price-asc") f.sort((a, b) => a.price - b.price);
        if (sort === "price-desc") f.sort((a, b) => b.price - a.price);

        setFiltered(f);
        setCurrentPage(1);
    };


    const handleFilterChange = (state) => {
        setFilterState(state);
        applyFilters(state);
    };

    useEffect(() => {
        applyFilters(filterState);
    }, [products, searchText, selectedCategory]);

    const paginatedProducts = filtered.slice(
        (currentPage - 1) * productsPerPage,
        currentPage * productsPerPage
    );

    useEffect(() => { window.scrollTo(0, 0); }, [currentPage]);

    return (
        <>
            <SimpleCarousel />
            <CategoryBar />
            <FilterPanel
                minPrice={0}
                maxPrice={10000}
                onFilterChange={handleFilterChange}
                brandList={["Tümü", ...new Set(products.map(p => p.brand).filter(Boolean))]}
            />
            <Typography variant="h4" align="center" sx={{ my: 3 }}>
                Ürünler
            </Typography>
            <Pagination
                currentPage={currentPage}
                totalPages={Math.ceil(filtered.length / productsPerPage)}
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
                totalPages={Math.ceil(filtered.length / productsPerPage)}
                onPageChange={setCurrentPage}
            />
        </>
    );
}
