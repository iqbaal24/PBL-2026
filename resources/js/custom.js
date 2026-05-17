document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('[data-search-input]');
    const categorySelect = document.querySelector('[data-category-select]');
    const cards = document.querySelectorAll('[data-product-card]');
    const isCatalogPage = searchInput && cards.length > 0;
    const productSearchData = document.querySelector('#product-search-data');
    const siteHeader = document.querySelector('[data-site-header]');

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

    const headerSearchRoots = Array.from(document.querySelectorAll('[data-header-search-root]'));
    const whatsappBuilders = Array.from(document.querySelectorAll('[data-whatsapp-builder]'));

    const renderHeaderSearch = (root, items) => {
        const searchDropdown = root.querySelector('[data-search-dropdown]');
        const searchResults = root.querySelector('[data-search-results]');

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
            li.innerHTML = `<a href="/katalog/${item.slug}">${item.name}</a>`;
            searchResults.appendChild(li);
        });

        searchDropdown.classList.remove('hidden');
    };

    const updateHeaderSearch = (root) => {
        const headerSearchInput = root.querySelector('[data-header-search-input]');

        if (!headerSearchInput) {
            return;
        }

        const query = headerSearchInput.value.trim().toLowerCase();
        if (!query) {
            renderHeaderSearch(root, []);
            return;
        }

        const matches = productSearchItems
            .filter((item) => item.name.toLowerCase().includes(query))
            .slice(0, 5);

        renderHeaderSearch(root, matches);
    };

    headerSearchRoots.forEach((root) => {
        const headerSearchInput = root.querySelector('[data-header-search-input]');
        const searchDropdown = root.querySelector('[data-search-dropdown]');

        if (!headerSearchInput || !searchDropdown) {
            return;
        }

        headerSearchInput.addEventListener('input', () => updateHeaderSearch(root));
        headerSearchInput.addEventListener('focus', () => updateHeaderSearch(root));
        headerSearchInput.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                searchDropdown.classList.add('hidden');
            }
        });
    });

    document.addEventListener('click', (event) => {
        headerSearchRoots.forEach((root) => {
            const searchDropdown = root.querySelector('[data-search-dropdown]');
            if (!searchDropdown) {
                return;
            }

            if (!root.contains(event.target)) {
                searchDropdown.classList.add('hidden');
            }
        });
    });

    const setMobileMenuState = (isOpen) => {
        if (!siteHeader) {
            return;
        }

        const menuButton = siteHeader.querySelector('[data-mobile-menu-toggle]');
        const mobilePanel = siteHeader.querySelector('[data-mobile-panel]');
        const openIcon = siteHeader.querySelector('[data-menu-icon="open"]');
        const closeIcon = siteHeader.querySelector('[data-menu-icon="close"]');

        siteHeader.dataset.mobileMenu = isOpen ? 'open' : 'closed';

        if (menuButton) {
            menuButton.setAttribute('aria-expanded', String(isOpen));
        }

        if (mobilePanel) {
            mobilePanel.setAttribute('aria-hidden', String(!isOpen));
        }

        if (openIcon && closeIcon) {
            openIcon.classList.toggle('hidden', isOpen);
            closeIcon.classList.toggle('hidden', !isOpen);
        }
    };

    if (siteHeader) {
        const menuButton = siteHeader.querySelector('[data-mobile-menu-toggle]');
        const mobilePanel = siteHeader.querySelector('[data-mobile-panel]');
        const mobileLinks = mobilePanel ? mobilePanel.querySelectorAll('a') : [];

        const updateHeaderState = () => {
            siteHeader.dataset.condensed = window.scrollY > 18 ? 'true' : 'false';
        };

        updateHeaderState();
        window.addEventListener('scroll', updateHeaderState, { passive: true });

        if (menuButton) {
            menuButton.addEventListener('click', () => {
                const isOpen = siteHeader.dataset.mobileMenu === 'open';
                setMobileMenuState(!isOpen);
            });
        }

        mobileLinks.forEach((link) => {
            link.addEventListener('click', () => setMobileMenuState(false));
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                setMobileMenuState(false);
            }
        });

        document.addEventListener('click', (event) => {
            const isOpen = siteHeader.dataset.mobileMenu === 'open';
            if (!isOpen) {
                return;
            }

            if (!siteHeader.contains(event.target)) {
                setMobileMenuState(false);
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                setMobileMenuState(false);
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

    whatsappBuilders.forEach((builder) => {
        const cta = builder.querySelector('[data-whatsapp-cta]');
        if (!cta) {
            return;
        }

        const productName = builder.dataset.productName || '';
        const productCategory = builder.dataset.productCategory || '';
        const number = builder.dataset.whatsappNumber || '';
        const variantField = builder.querySelector('[data-whatsapp-variant]');
        const quantityField = builder.querySelector('[data-whatsapp-quantity]');
        const noteField = builder.querySelector('[data-whatsapp-note]');
        const preview = builder.querySelector('[data-whatsapp-preview]');
        const priceLabel = builder.querySelector('[data-whatsapp-price]');

        const updateWhatsappLink = () => {
            const selectedVariant = variantField ? variantField.options[variantField.selectedIndex] : null;
            const variantLabel = selectedVariant ? selectedVariant.dataset.variantLabel || selectedVariant.textContent.trim() : 'Belum dipilih';
            const variantPrice = selectedVariant ? selectedVariant.dataset.variantPrice || '' : '';
            const quantity = quantityField && quantityField.value ? quantityField.value : 'Belum ditentukan';
            const note = noteField && noteField.value.trim() ? noteField.value.trim() : 'Tidak ada catatan tambahan';
            const lines = [
                'Halo Harapan Jaya Printing, saya ingin pesan produk berikut:',
                `Produk: ${productName}`,
                productCategory ? `Kategori: ${productCategory}` : null,
                `Varian: ${variantLabel}`,
                `Jumlah perkiraan: ${quantity}`,
                variantPrice ? `Harga acuan: ${variantPrice}` : null,
                `Catatan: ${note}`,
                'Mohon bantu proses pemesanan dan konfirmasi detail finalnya.',
            ].filter(Boolean);

            cta.href = `https://wa.me/${number}?text=${encodeURIComponent(lines.join('\n'))}`;

            if (preview) {
                preview.textContent = `${productName} • ${variantLabel} • ${quantity}`;
            }

            if (priceLabel) {
                priceLabel.textContent = variantPrice || priceLabel.dataset.fallback || 'Harga dikonfirmasi di WhatsApp';
            }
        };

        [variantField, quantityField, noteField].forEach((field) => {
            if (!field) {
                return;
            }

            field.addEventListener('input', updateWhatsappLink);
            field.addEventListener('change', updateWhatsappLink);
        });

        updateWhatsappLink();
    });
});
