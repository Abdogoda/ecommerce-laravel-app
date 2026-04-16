<div class="relative" id="globalSearchContainer">
    <!-- Desktop Search Form -->
    <form
        class="hidden md:flex md:flex-1 md:max-w-md items-center bg-white/5 rounded-xl px-4 py-2 border border-white/10 focus-within:border-blue-500 transition-colors"
        onsubmit="event.preventDefault()">
        <i class="fas fa-search text-gray-400 text-sm mr-3"></i>
        <input id="globalSearchInput" type="search" placeholder="Search products, categories, orders, users..."
            class="bg-transparent text-white placeholder-gray-500 outline-none w-full text-sm" autocomplete="off" />
    </form>

    <!-- Desktop Results Dropdown -->
    <div id="globalSearchResults"
        class="hidden absolute top-full mt-2 left-0 w-full md:min-w-[500px] bg-gray-900/95 backdrop-blur border border-white/10 rounded-xl shadow-2xl z-50 max-h-96 overflow-y-auto">
        <!-- Results will be inserted here by JavaScript -->
    </div>

    <!-- Mobile Search Form (Inside Expandable) -->
    <div id="mobileSearchForm"
        class="hidden md:hidden overflow-hidden transition-all duration-300 ease-in-out bg-white/5 border-b border-white/10"
        style="max-height: 0px">
        <form class="p-3" onsubmit="event.preventDefault()">
            <div
                class="flex items-center bg-white/5 rounded-lg px-3 py-2 border border-white/10 focus-within:border-blue-500 transition-colors">
                <i class="fas fa-search text-gray-400 text-sm mr-3"></i>
                <input id="mobileSearchInput" type="search" placeholder="Search products, categories, orders, users..."
                    class="bg-transparent text-white placeholder-gray-500 outline-none w-full text-sm"
                    autocomplete="off" />
            </div>
        </form>
        <!-- Mobile Results Dropdown -->
        <div id="globalSearchResultsMobile"
            class="hidden bg-gray-800 border-t border-white/10 max-h-96 overflow-y-auto">
            <!-- Results will be inserted here by JavaScript -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const desktopInput = document.getElementById('globalSearchInput');
            const mobileInput = document.getElementById('mobileSearchInput');
            const desktopResults = document.getElementById('globalSearchResults');
            const mobileResults = document.getElementById('globalSearchResultsMobile');
            const mobileSearchForm = document.getElementById('mobileSearchForm');
            let searchTimeout;
            let currentActiveIndex = -1;
            let allResults = [];

            // Bind events for both inputs
            [desktopInput, mobileInput].forEach(input => {
                input.addEventListener('input', performSearch);
                input.addEventListener('focus', showResults);
                input.addEventListener('keydown', handleKeydown);
            });

            // Hide results when clicking outside
            document.addEventListener('click', function(e) {
                if (!document.getElementById('globalSearchContainer').contains(e.target)) {
                    desktopResults.classList.add('hidden');
                    mobileResults.classList.add('hidden');
                    currentActiveIndex = -1;
                }
            });

            // Toggle mobile search form
            document.getElementById('searchToggle')?.addEventListener('click', function() {
                if (mobileSearchForm.style.maxHeight === '0px' || mobileSearchForm.style.maxHeight === '') {
                    mobileSearchForm.style.maxHeight = '200px';
                    mobileInput.focus();
                } else {
                    mobileSearchForm.style.maxHeight = '0px';
                    mobileResults.classList.add('hidden');
                }
            });

            function handleKeydown(e) {
                const isDesktop = e.target === desktopInput;
                const resultsContainer = isDesktop ? desktopResults : mobileResults;
                const resultLinks = resultsContainer.querySelectorAll('a[href]');

                switch (e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        if (!resultsContainer.classList.contains('hidden')) {
                            currentActiveIndex = Math.min(currentActiveIndex + 1, resultLinks.length - 1);
                            highlightResult(resultLinks);
                        }
                        break;
                    case 'ArrowUp':
                        e.preventDefault();
                        if (!resultsContainer.classList.contains('hidden')) {
                            currentActiveIndex = Math.max(currentActiveIndex - 1, -1);
                            highlightResult(resultLinks);
                        }
                        break;
                    case 'Enter':
                        e.preventDefault();
                        if (currentActiveIndex >= 0 && resultLinks[currentActiveIndex]) {
                            window.location.href = resultLinks[currentActiveIndex].href;
                        } else if (allResults.length > 0) {
                            window.location.href = allResults[0].url;
                        }
                        break;
                    case 'Escape':
                        resultsContainer.classList.add('hidden');
                        currentActiveIndex = -1;
                        break;
                }
            }

            function highlightResult(links) {
                links.forEach((link, index) => {
                    if (index === currentActiveIndex) {
                        link.classList.add('bg-white/10');
                    } else {
                        link.classList.remove('bg-white/10');
                    }
                });
            }

            function performSearch(e) {
                const query = e.target.value.trim();
                const isDesktop = e.target === desktopInput;

                clearTimeout(searchTimeout);

                if (query.length < 2) {
                    (isDesktop ? desktopResults : mobileResults).classList.add('hidden');
                    currentActiveIndex = -1;
                    return;
                }

                // Add loading state
                const resultsContainer = isDesktop ? desktopResults : mobileResults;
                resultsContainer.innerHTML =
                    '<div class="p-4 text-center text-gray-400"><i class="fas fa-spinner fa-spin"></i> Searching...</div>';
                resultsContainer.classList.remove('hidden');

                searchTimeout = setTimeout(() => {
                    fetch(`{{ route('admin.search') }}?q=${encodeURIComponent(query)}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        })
                        .then(response => response.json())
                        .then(data => renderResults(data, isDesktop))
                        .catch(error => {
                            console.error('Search error:', error);
                            resultsContainer.innerHTML =
                                '<div class="p-4 text-center text-red-400"><i class="fas fa-exclamation-circle"></i> Search failed</div>';
                        });
                }, 300); // Debounce search
            }

            function showResults(e) {
                const query = e.target.value.trim();
                if (query.length >= 2) {
                    const isDesktop = e.target === desktopInput;
                    performSearch(e);
                }
            }

            function renderResults(data, isDesktop) {
                const resultsContainer = isDesktop ? desktopResults : mobileResults;
                currentActiveIndex = -1;
                allResults = [];

                if (!data.results || Object.keys(data.results).length === 0) {
                    resultsContainer.innerHTML = `
                    <div class="p-4 text-center text-gray-400">
                        <i class="fas fa-search"></i>
                        <p class="mt-2">No results found for "${escapeHtml(data.query)}"</p>
                    </div>
                `;
                    resultsContainer.classList.remove('hidden');
                    return;
                }

                let html = '';

                // Build results by category
                Object.entries(data.results).forEach(([category, items]) => {
                    if (items.length > 0) {
                        html += `<div class="border-b border-white/10">`;
                        html += `<div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider bg-black/50">
                        <i class="fas fa-${getCategoryIcon(category)} mr-2"></i>${getCategoryLabel(category)}
                    </div>`;

                        items.forEach(item => {
                            allResults.push(item);
                            const name = escapeHtml(item.name);
                            const subtitle = item.subtitle ? escapeHtml(item.subtitle) : '';
                            const badge = escapeHtml(item.badge);
                            const url = escapeHtml(item.url);

                            html += `
                            <a href="${url}" 
                                class="flex items-center justify-between p-3 hover:bg-white/5 focus:bg-white/10 transition-colors border-b border-white/5 last:border-b-0 outline-none"
                                tabindex="0">
                                <div class="flex items-center flex-1 min-w-0">
                                    <div class="w-8 h-8 rounded-lg ${getCategoryBgColor(item.type)} flex items-center justify-center flex-shrink-0">
                                        <i class="fas ${item.icon} text-xs"></i>
                                    </div>
                                    <div class="ml-3 flex-1 min-w-0">
                                        <p class="text-white text-sm font-medium truncate">${name}</p>
                                        ${subtitle ? `<p class="text-gray-400 text-xs truncate">${subtitle}</p>` : ''}
                                    </div>
                                </div>
                                <span class="ml-2 px-2 py-1 bg-white/10 text-gray-300 text-xs rounded flex-shrink-0">${badge}</span>
                            </a>
                        `;
                        });

                        html += `</div>`;
                    }
                });

                if (data.total > 20) {
                    html += `
                    <div class="p-3 text-center border-t border-white/10">
                        <p class="text-gray-400 text-xs">
                            <i class="fas fa-info-circle mr-1"></i>
                            Showing ${data.total} of many results. Use filters for more precise search.
                        </p>
                    </div>
                `;
                }

                resultsContainer.innerHTML = html;
                resultsContainer.classList.remove('hidden');
            }

            function getCategoryIcon(category) {
                const icons = {
                    'products': 'box',
                    'categories': 'layer-group',
                    'orders': 'shopping-cart',
                    'users': 'users',
                };
                return icons[category] || 'search';
            }

            function getCategoryLabel(category) {
                const labels = {
                    'products': 'Products',
                    'categories': 'Categories',
                    'orders': 'Orders',
                    'users': 'Users',
                };
                return labels[category] || category;
            }

            function getCategoryBgColor(type) {
                const colors = {
                    'product': 'bg-blue-500/20',
                    'category': 'bg-purple-500/20',
                    'order': 'bg-green-500/20',
                    'user': 'bg-orange-500/20',
                };
                return colors[type] || 'bg-gray-500/20';
            }

            function escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return text.replace(/[&<>"']/g, m => map[m]);
            }
        });
    </script>
</div>
