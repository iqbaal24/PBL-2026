document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('[data-search-input]');
    const categorySelect = document.querySelector('[data-category-select]');
    const cards = document.querySelectorAll('[data-product-card]');
    const isCatalogPage = searchInput && cards.length > 0;
    const headerSearchInput = document.querySelector('[data-header-search-input]');
    const searchDropdown = document.querySelector('[data-search-dropdown]');
    const searchResults = document.querySelector('[data-search-results]');
    const productSearchData = document.querySelector('#product-search-data');

    const productSearchItems = (() => {
        if (!productSearchData) {
            return [];
        }

        try {
            return JSON.parse(productSearchData.textContent || '[]');
        } catch (err) {
            return [];
        }
    })();

    const renderHeaderSearch = (items) => {
        if (!searchDropdown || !searchResults) {
            return;
        }

        searchResults.innerHTML = '';

        if (!items.length) {
            searchDropdown.classList.add('hidden');
            return;
        }

        items.forEach((item) => {
            const li = document.createElement('li');
            li.innerHTML = `<a href="/katalog/${item.slug}" class="block px-4 py-3 text-sm text-[#2C3E50] transition hover:bg-[#F8F9FA]">${item.name}</a>`;
            searchResults.appendChild(li);
        });

        searchDropdown.classList.remove('hidden');
    };

    const updateHeaderSearch = () => {
        if (!headerSearchInput) {
            return;
        }

        const query = headerSearchInput.value.trim().toLowerCase();
        if (!query) {
            renderHeaderSearch([]);
            return;
        }

        const matches = productSearchItems
            .filter((item) => item.name.toLowerCase().includes(query))
            .slice(0, 5);

        renderHeaderSearch(matches);
    };

    if (headerSearchInput) {
        headerSearchInput.addEventListener('input', updateHeaderSearch);
        headerSearchInput.addEventListener('focus', updateHeaderSearch);
        document.addEventListener('click', (event) => {
            if (!searchDropdown || !headerSearchInput) {
                return;
            }

            if (!searchDropdown.contains(event.target) && event.target !== headerSearchInput) {
                searchDropdown.classList.add('hidden');
            }
        });
    }

    const updateCount = function (visibleCount) {
        const countEl = document.querySelector('[data-product-count]');
        if (countEl) {
            countEl.textContent = `Menampilkan 1-${visibleCount} dari ${cards.length} produk`;
        }
    };

    const filterCards = function () {
        if (!isCatalogPage) {
            return;
        }

        const query = searchInput.value.trim().toLowerCase();
        const category = categorySelect ? categorySelect.value : 'all';
        let visibleCount = 0;

        cards.forEach(function (card) {
            const name = card.dataset.productName || '';
            const productCategory = card.dataset.productCategory || '';
            const matchesSearch = !query || name.indexOf(query) !== -1;
            const matchesCategory = category === 'all' || productCategory === category;

            if (matchesSearch && matchesCategory) {
                card.style.display = '';
                visibleCount += 1;
            } else {
                card.style.display = 'none';
            }
        });

        updateCount(visibleCount);
    };

    if (isCatalogPage) {
        searchInput.addEventListener('input', filterCards);
        if (categorySelect) {
            categorySelect.addEventListener('change', filterCards);
        }

        filterCards();
    }

    const cartItem = document.querySelector('[data-cart-item]');
    const emptyState = document.querySelector('[data-empty-state]');
    const cartCount = document.querySelector('[data-cart-count]');
    const subtotalEl = document.querySelector('[data-subtotal]');
    const totalEl = document.querySelector('[data-total]');
    const checkoutLink = document.querySelector('a[href*="checkout/form"]');

    const formatRupiah = (value) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
    };

    const updateSummary = () => {
        if (!cartItem) {
            return;
        }

        const qtyInput = cartItem.querySelector('[data-item-qty]');
        const price = Number(cartItem.dataset.itemPrice || 0);
        const qty = Number(qtyInput.value || 1);
        const total = price * qty;

        if (cartCount) {
            cartCount.textContent = qty;
        }

        if (subtotalEl) {
            subtotalEl.textContent = formatRupiah(total);
        }

        if (totalEl) {
            totalEl.textContent = formatRupiah(total);
        }

        const itemTotal = cartItem.querySelector('[data-item-total]');
        if (itemTotal) {
            itemTotal.textContent = formatRupiah(total);
        }
    };

    const checkCartEmpty = () => {
        const items = document.querySelectorAll('[data-cart-item]');
        const visibleItems = Array.from(items).filter((item) => item.style.display !== 'none');
        const isEmpty = visibleItems.length === 0;

        if (emptyState) {
            emptyState.classList.toggle('hidden', !isEmpty);
        }

        if (checkoutLink) {
            checkoutLink.classList.toggle('pointer-events-none', isEmpty);
            checkoutLink.classList.toggle('opacity-50', isEmpty);
        }
    };

    if (cartItem) {
        const qtyInput = cartItem.querySelector('[data-item-qty]');

        cartItem.querySelectorAll('[data-qty-change]').forEach((button) => {
            button.addEventListener('click', () => {
                const action = button.dataset.qtyChange;
                let qty = Number(qtyInput.value || 1);
                if (action === 'increase') {
                    qty += 1;
                }
                if (action === 'decrease' && qty > 1) {
                    qty -= 1;
                }
                qtyInput.value = qty;
                updateSummary();
            });
        });

        const removeButton = cartItem.querySelector('[data-remove-item]');
        if (removeButton) {
            removeButton.addEventListener('click', () => {
                cartItem.style.display = 'none';
                if (cartCount) {
                    cartCount.textContent = 0;
                }
                if (subtotalEl) {
                    subtotalEl.textContent = formatRupiah(0);
                }
                if (totalEl) {
                    totalEl.textContent = formatRupiah(0);
                }
                checkCartEmpty();
            });
        }
    }

    checkCartEmpty();
});
