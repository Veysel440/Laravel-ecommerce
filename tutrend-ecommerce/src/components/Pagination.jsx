import '../styles/Pagination.css';

export default function Pagination({ currentPage, totalPages, onPageChange }) {
    if (totalPages <= 1) return null;
    return (
        <div className="pagination">
            {[...Array(totalPages).keys()].map((num) => (
                <button
                    key={num + 1}
                    className={`pagination-btn${currentPage === num + 1 ? " active" : ""}`}
                    onClick={() => onPageChange(num + 1)}
                >
                    {num + 1}
                </button>
            ))}
        </div>
    );
}
