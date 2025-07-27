"use client";
import { useContext, useState } from "react";
import { CategoryContext } from "../contexts/CategoryContext";
import { SearchContext } from "../contexts/SearchContext";
import { Slider, Select, MenuItem, InputLabel, FormControl, Box, Button } from "@mui/material";
import debounce from "lodash/debounce";

const BRAND_LIST = ["Tümü", "Adidas", "Nike", "Apple", "Samsung", "Diğer"];

export default function FilterPanel({
                                        minPrice, maxPrice, onFilterChange, brandList = BRAND_LIST
                                    }) {
    const { categories, selectedCategory, setSelectedCategory } = useContext(CategoryContext);
    const { searchText, setSearchText } = useContext(SearchContext);

    const [price, setPrice] = useState([minPrice, maxPrice]);
    const [brand, setBrand] = useState("Tümü");
    const [sort, setSort] = useState("az");

    const handleSearch = debounce((value) => setSearchText(value), 300);

    const handleFilterApply = () => {
        onFilterChange({
            price, brand, sort
        });
    };

    return (
        <Box sx={{
            display: "flex", gap: 2, alignItems: "center",
            background: "#fff", borderRadius: 2, boxShadow: 1, p: 2, mb: 2, maxWidth: 1100, mx: "auto"
        }}>
            <FormControl size="small" sx={{ minWidth: 120 }}>
                <InputLabel>Kategori</InputLabel>
                <Select
                    value={selectedCategory}
                    label="Kategori"
                    onChange={e => setSelectedCategory(e.target.value)}
                >
                    {categories.map((cat) => (
                        <MenuItem key={cat} value={cat}>{cat}</MenuItem>
                    ))}
                </Select>
            </FormControl>
            <Box sx={{ width: 160 }}>
                <InputLabel sx={{ fontSize: 14, mb: 1 }}>Fiyat</InputLabel>
                <Slider
                    value={price}
                    min={minPrice}
                    max={maxPrice}
                    onChange={(_, v) => setPrice(v)}
                    valueLabelDisplay="auto"
                />
            </Box>
            <FormControl size="small" sx={{ minWidth: 100 }}>
                <InputLabel>Marka</InputLabel>
                <Select
                    value={brand}
                    label="Marka"
                    onChange={e => setBrand(e.target.value)}
                >
                    {brandList.map((b) => (
                        <MenuItem key={b} value={b}>{b}</MenuItem>
                    ))}
                </Select>
            </FormControl>
            <FormControl size="small" sx={{ minWidth: 100 }}>
                <InputLabel>Sırala</InputLabel>
                <Select
                    value={sort}
                    label="Sırala"
                    onChange={e => setSort(e.target.value)}
                >
                    <MenuItem value="az">A-Z</MenuItem>
                    <MenuItem value="za">Z-A</MenuItem>
                    <MenuItem value="price-asc">Fiyat (Artan)</MenuItem>
                    <MenuItem value="price-desc">Fiyat (Azalan)</MenuItem>
                </Select>
            </FormControl>
            <input
                type="text"
                placeholder="Ürün ara…"
                defaultValue={searchText}
                onChange={e => handleSearch(e.target.value)}
                style={{ padding: "7px 11px", borderRadius: 6, border: "1px solid #ccc" }}
            />
            <Button variant="contained" color="primary" onClick={handleFilterApply}>
                Filtrele
            </Button>
        </Box>
    );
}
