document.addEventListener('DOMContentLoaded', function () {
    const productSearchData = document.querySelector('#product-search-data');
    const siteHeader = document.querySelector('[data-site-header]');
    const isHomePage = window.location.pathname === '/';

    document.body.classList.toggle('is-home-page', isHomePage);

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
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!isHomePage) {
        const quietMotionTargets = [
            ...document.querySelectorAll('main > section, main > div, main article, main aside > div, main [data-product-card], main [data-whatsapp-builder]'),
        ];

        quietMotionTargets.forEach((item) => {
            if (!item.hasAttribute('data-reveal')) {
                item.setAttribute('data-reveal', 'quiet');
            }
        });
    }

    const revealItems = Array.from(document.querySelectorAll('[data-reveal]'));

    if (revealItems.length) {
        if (prefersReducedMotion || !('IntersectionObserver' in window)) {
            revealItems.forEach((item) => item.classList.add('is-visible'));
        } else {
            document.body.classList.add('reveal-ready');
            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                });
            }, {
                rootMargin: '0px 0px -12% 0px',
                threshold: 0.12,
            });

            revealItems.forEach((item, index) => {
                const delayStep = item.dataset.reveal === 'quiet' ? 45 : 70;
                item.style.animationDelay = `${Math.min(index % 5, 4) * delayStep}ms`;
                revealObserver.observe(item);
            });
        }
    }

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
            mobilePanel.hidden = !isOpen;
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
        setMobileMenuState(false);
        window.addEventListener('scroll', updateHeaderState, { passive: true });

        if (menuButton) {
            menuButton.dataset.mobileMenuBound = 'true';
            menuButton.addEventListener('click', (event) => {
                event.preventDefault();
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

    whatsappBuilders.forEach((builder) => {
        const cta = builder.querySelector('[data-whatsapp-cta]');
        if (!cta) {
            return;
        }

        const productName = builder.dataset.productName || '';
        const productCategory = builder.dataset.productCategory || '';
        const brandName = builder.dataset.brandName || 'Harapan Jaya Printing';
        const number = builder.dataset.whatsappNumber || '';
        const customerField = builder.querySelector('[data-whatsapp-customer]');
        const variantField = builder.querySelector('[data-whatsapp-variant]');
        const quantityField = builder.querySelector('[data-whatsapp-quantity]');
        const sizeField = builder.querySelector('[data-whatsapp-size]');
        const finishingField = builder.querySelector('[data-whatsapp-finishing]');
        const fileStatusField = builder.querySelector('[data-whatsapp-file-status]');
        const pickupField = builder.querySelector('[data-whatsapp-pickup]');
        const noteField = builder.querySelector('[data-whatsapp-note]');
        const preview = builder.querySelector('[data-whatsapp-preview]');
        const priceLabel = builder.querySelector('[data-whatsapp-price]');

        const updateWhatsappLink = () => {
            const selectedVariant = variantField ? variantField.options[variantField.selectedIndex] : null;
            const variantLabel = selectedVariant ? selectedVariant.dataset.variantLabel || selectedVariant.textContent.trim() : 'Belum dipilih';
            const variantPrice = selectedVariant ? selectedVariant.dataset.variantPrice || '' : '';
            const priceText = variantPrice || (priceLabel ? priceLabel.dataset.fallback || '' : '');
            const customer = customerField && customerField.value.trim() ? customerField.value.trim() : '';
            const quantity = quantityField && quantityField.value ? quantityField.value : 'Belum ditentukan';
            const size = sizeField && sizeField.value.trim() ? sizeField.value.trim() : 'Belum ditentukan';
            const selectedFinishing = finishingField ? finishingField.options[finishingField.selectedIndex] : null;
            const finishingText = selectedFinishing ? selectedFinishing.dataset.finishingLabel || selectedFinishing.textContent.trim() : '';
            const fileStatus = fileStatusField && fileStatusField.value ? fileStatusField.value : 'Belum ditentukan';
            const pickup = pickupField && pickupField.value ? pickupField.value : 'Belum ditentukan';
            const note = noteField && noteField.value.trim() ? noteField.value.trim() : 'Tidak ada detail tambahan';
            const lines = [
                `Halo ${brandName}, saya ingin pesan produk berikut:`,
                customer ? `Nama: ${customer}` : null,
                `Produk: ${productName}`,
                productCategory ? `Kategori: ${productCategory}` : null,
                `Varian: ${variantLabel}`,
                `Jumlah perkiraan: ${quantity}`,
                `Ukuran: ${size}`,
                finishingText ? `Finishing: ${finishingText}` : null,
                `Status file desain: ${fileStatus}`,
                `Metode pengambilan: ${pickup}`,
                priceText ? `Harga acuan: ${priceText}` : null,
                `Detail kebutuhan: ${note}`,
                'Mohon bantu proses pemesanan dan konfirmasi detail finalnya.',
            ].filter(Boolean);

            cta.href = `https://wa.me/${number}?text=${encodeURIComponent(lines.join('\n'))}`;

            if (preview) {
                preview.textContent = `${productName} • ${variantLabel} • ${quantity} • ${size}`;
            }

            if (priceLabel) {
                priceLabel.textContent = priceText || 'Harga dikonfirmasi di WhatsApp';
            }
        };

        [customerField, variantField, quantityField, sizeField, finishingField, fileStatusField, pickupField, noteField].forEach((field) => {
            if (!field) {
                return;
            }

            field.addEventListener('input', updateWhatsappLink);
            field.addEventListener('change', updateWhatsappLink);
        });

        updateWhatsappLink();
    });

    // Product Carousel
    const carouselTrack = document.querySelector('[data-carousel-track]');
    const carouselPrev = document.querySelector('[data-carousel-prev]');
    const carouselNext = document.querySelector('[data-carousel-next]');

    if (carouselTrack && carouselTrack.firstElementChild) {
        const updateCarouselState = () => {
            const maxScrollLeft = carouselTrack.scrollWidth - carouselTrack.clientWidth;
            const scrollLeft = carouselTrack.scrollLeft;

            if (carouselPrev) {
                carouselPrev.disabled = scrollLeft <= 8;
            }
            if (carouselNext) {
                carouselNext.disabled = scrollLeft >= maxScrollLeft - 8;
            }
        };

        const scrollCarousel = (direction) => {
            const cardWidth = carouselTrack.firstElementChild.getBoundingClientRect().width;
            const style = window.getComputedStyle(carouselTrack);
            const gap = parseFloat(style.columnGap || style.gap) || 24;
            const step = cardWidth + gap;
            
            carouselTrack.scrollBy({
                left: direction * step,
                behavior: 'smooth'
            });
        };

        if (carouselPrev) {
            carouselPrev.addEventListener('click', () => {
                scrollCarousel(-1);
            });
        }
        if (carouselNext) {
            carouselNext.addEventListener('click', () => {
                scrollCarousel(1);
            });
        }

        carouselTrack.addEventListener('scroll', updateCarouselState, { passive: true });
        updateCarouselState();
        window.addEventListener('resize', updateCarouselState, { passive: true });

        carouselTrack.setAttribute('tabindex', '0');
        carouselTrack.setAttribute('aria-label', 'Katalog produk pilihan. Gunakan panah kiri dan kanan untuk berpindah produk.');
        carouselTrack.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                scrollCarousel(-1);
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                scrollCarousel(1);
            }
        });

        // Touch / Mouse Dragging Interaction
        let isDown = false;
        let startX;
        let scrollLeftVal;
        let dragThreshold = 5;
        let hasDragged = false;

        carouselTrack.addEventListener('pointerdown', (e) => {
            isDown = true;
            carouselTrack.classList.replace('cursor-grab', 'cursor-grabbing');
            startX = e.pageX - carouselTrack.offsetLeft;
            scrollLeftVal = carouselTrack.scrollLeft;
            hasDragged = false;
            carouselTrack.setPointerCapture(e.pointerId);
        });

        carouselTrack.addEventListener('pointermove', (e) => {
            if (!isDown) return;
            const x = e.pageX - carouselTrack.offsetLeft;
            const walk = (x - startX) * 1.5; // Drag sensitivity multiplier
            if (Math.abs(walk) > dragThreshold) {
                hasDragged = true;
            }
            carouselTrack.scrollLeft = scrollLeftVal - walk;
        });

        const stopDragging = (e) => {
            if (!isDown) return;
            isDown = false;
            carouselTrack.classList.replace('cursor-grabbing', 'cursor-grab');
            carouselTrack.releasePointerCapture(e.pointerId);
            
            // If user did drag, prevent any accidental clicks on links inside cards
            if (hasDragged) {
                const preventClick = (clickEvent) => {
                    clickEvent.preventDefault();
                    clickEvent.stopImmediatePropagation();
                    carouselTrack.removeEventListener('click', preventClick, true);
                };
                carouselTrack.addEventListener('click', preventClick, true);
            }
        };

        carouselTrack.addEventListener('pointerup', stopDragging);
        carouselTrack.addEventListener('pointercancel', stopDragging);
    }
});
