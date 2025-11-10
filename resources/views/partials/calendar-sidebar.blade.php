<div class="bg-white rounded-xl shadow p-4 border border-gray-200">
    <h3 class="text-lg font-bold mb-4 text-blue-600">Kalender Akademik</h3>

    <!-- Navigation -->
    <div class="flex items-center justify-between mb-4">
        <button id="sidebar-prevMonth" class="bg-blue-100 hover:bg-blue-200 text-blue-600 p-2 rounded-lg transition">
            <i class="fas fa-chevron-left text-sm"></i>
        </button>
        <h4 id="sidebar-currentMonth" class="text-sm font-semibold text-gray-800">Loading...</h4>
        <button id="sidebar-nextMonth" class="bg-blue-100 hover:bg-blue-200 text-blue-600 p-2 rounded-lg transition">
            <i class="fas fa-chevron-right text-sm"></i>
        </button>
    </div>

    <!-- Calendar Grid -->
    <div class="bg-white rounded-lg overflow-hidden mb-4 border border-gray-200">
        <table class="w-full text-center text-sm">
            <thead>
                <tr class="bg-gray-100 border-b border-gray-200">
                    <th class="py-2 font-semibold text-gray-700 border-r border-gray-200">Minggu</th>
                    <th class="py-2 font-semibold text-gray-700 border-r border-gray-200">Senin</th>
                    <th class="py-2 font-semibold text-gray-700 border-r border-gray-200">Selasa</th>
                    <th class="py-2 font-semibold text-gray-700 border-r border-gray-200">Rabu</th>
                    <th class="py-2 font-semibold text-gray-700 border-r border-gray-200">Kamis</th>
                    <th class="py-2 font-semibold text-gray-700 border-r border-gray-200">Jumat</th>
                    <th class="py-2 font-semibold text-gray-700">Sabtu</th>
                </tr>
            </thead>
            <tbody id="sidebar-calendarGrid">
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-500">Memuat kalender...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Events List -->
    <div class="mt-4">
        <h5 class="text-sm font-semibold text-gray-700 mb-3">Kegiatan Mendatang</h5>
        <div id="sidebar-eventsList" class="space-y-2 max-h-48 overflow-y-auto">
            <div class="text-gray-500 text-xs text-center py-2">Memuat kegiatan...</div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('calendar.index') }}" class="text-xs text-blue-600 hover:underline">Lihat kalender lengkap »</a>
    </div>

    <style>
        /* === WARNA UNTUK SIDEBAR CALENDAR === */
        .bg-blue-500 { background-color: #3b82f6 !important; color: white !important; }
        .bg-green-500 { background-color: #10b981 !important; color: white !important; }
        .bg-red-500 { background-color: #ef4444 !important; color: white !important; }
        .bg-yellow-500 { background-color: #f59e0b !important; color: #1f2937 !important; }
        .bg-purple-500 { background-color: #8b5cf6 !important; color: white !important; }

        .bg-blue-100 { background-color: #dbeafe !important; }
        .bg-green-100 { background-color: #dcfce7 !important; }
        .bg-red-100 { background-color: #fee2e2 !important; }
        .bg-yellow-100 { background-color: #fef3c7 !important; }
        .bg-purple-100 { background-color: #f3e8ff !important; }

        .text-blue-800 { color: #1e40af !important; }
        .text-green-800 { color: #166534 !important; }
        .text-red-800 { color: #991b1b !important; }
        .text-yellow-800 { color: #92400e !important; }
        .text-purple-800 { color: #6b21a8 !important; }

        /* Event indicator dot */
        .event-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
            margin-left: 2px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        (function() {
            console.log('🔄 Sidebar Calendar Script Loading...');

            // State
            let academicEvents = [];
            let sidebarCurrentDate = new Date();

            // Elements
            const grid = document.getElementById('sidebar-calendarGrid');
            const monthLabel = document.getElementById('sidebar-currentMonth');
            const eventsList = document.getElementById('sidebar-eventsList');
            const prevBtn = document.getElementById('sidebar-prevMonth');
            const nextBtn = document.getElementById('sidebar-nextMonth');

            // Check if elements exist
            if (!grid || !monthLabel || !eventsList) {
                console.error('❌ SIDEBAR ELEMENTS NOT FOUND!');
                console.log('Grid:', grid, 'MonthLabel:', monthLabel, 'EventsList:', eventsList);
                return;
            }

            console.log('✅ Sidebar elements found');

            // Fetch events dari API
            async function fetchEvents(year, month) {
                try {
                    const monthParam = `${year}-${String(month).padStart(2,'0')}`;
                    console.log('📡 Fetching events for:', monthParam);

                    const res = await axios.get('/api/events', {
                        params: {
                            month: monthParam
                        }
                    });

                    const data = res.data || [];
                    console.log('📦 Events received:', data.length);

                    // Normalisasi data
                    return data.map(ev => {
                        const start = ev.start || ev.start_date || null;
                        const end = ev.end || ev.end_date || start;
                        const color = ev.color || 'blue';

                        return {
                            ...ev,
                            start,
                            end,
                            color
                        };
                    });
                } catch (err) {
                    console.error('❌ fetchEvents error:', err);
                    return [];
                }
            }

            // Get events untuk tanggal tertentu
            function getEventsForDate(dateStr) {
                if (!academicEvents || academicEvents.length === 0) return [];

                return academicEvents.filter(ev => {
                    if (!ev.start) return false;

                    const start = new Date(ev.start);
                    const end = ev.end ? new Date(ev.end) : new Date(ev.start);
                    const target = new Date(dateStr);

                    start.setHours(0, 0, 0, 0);
                    end.setHours(23, 59, 59, 999);
                    target.setHours(12, 0, 0, 0);

                    return target >= start && target <= end;
                });
            }

            // Get color class untuk event
            function getEventColorClass(color) {
                const colorMap = {
                    'blue': 'bg-blue-500',
                    'green': 'bg-green-500',
                    'red': 'bg-red-500',
                    'yellow': 'bg-yellow-500',
                    'purple': 'bg-purple-500'
                };
                return colorMap[color] || 'bg-blue-500';
            }

            // Render kalender
            function renderSidebarCalendar() {
                console.log('📅 Rendering sidebar calendar...');

                const year = sidebarCurrentDate.getFullYear();
                const month = sidebarCurrentDate.getMonth();

                // Update month label
                monthLabel.textContent = new Date(year, month).toLocaleDateString('id-ID', {
                    month: 'long',
                    year: 'numeric'
                });

                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);
                const firstDayOfWeek = firstDay.getDay();
                const daysInMonth = lastDay.getDate();

                const today = new Date();
                let calendarHTML = '';
                let dayCount = 1;

                // Create calendar rows
                for (let week = 0; week < 6; week++) {
                    calendarHTML += '<tr>';

                    for (let dayOfWeek = 0; dayOfWeek < 7; dayOfWeek++) {
                        if ((week === 0 && dayOfWeek < firstDayOfWeek) || dayCount > daysInMonth) {
                            // Empty cell
                            calendarHTML += '<td class="p-2 border border-gray-200 bg-gray-50 text-gray-300"></td>';
                        } else {
                            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(dayCount).padStart(2, '0')}`;
                            const dayEvents = getEventsForDate(dateStr);
                            const isToday = today.getDate() === dayCount &&
                                           today.getMonth() === month &&
                                           today.getFullYear() === year;

                            let cellClass = 'p-2 border border-gray-200 font-medium text-sm relative ';

                            if (isToday) {
                                cellClass += 'bg-blue-600 text-white font-bold';
                            } else {
                                cellClass += 'bg-white text-gray-700';
                            }

                            let eventIndicator = '';
                            if (dayEvents.length > 0) {
                                const eventColor = dayEvents[0].color || 'blue';
                                eventIndicator = `<div class="event-dot ${getEventColorClass(eventColor)} absolute bottom-1 left-1/2 transform -translate-x-1/2"></div>`;
                            }

                            calendarHTML += `
                                <td class="${cellClass}" style="position: relative;">
                                    <div>${dayCount}</div>
                                    ${eventIndicator}
                                </td>
                            `;

                            dayCount++;
                        }
                    }

                    calendarHTML += '</tr>';
                    if (dayCount > daysInMonth) break;
                }

                grid.innerHTML = calendarHTML;
                console.log('✅ Calendar rendered');
            }

            // Render events list
            function renderSidebarEventsList() {
                console.log('📋 Rendering events list...');

                eventsList.innerHTML = '';

                if (!academicEvents || academicEvents.length === 0) {
                    eventsList.innerHTML = '<div class="text-gray-500 text-xs text-center py-4">Tidak ada kegiatan</div>';
                    return;
                }

                const curMonthEvents = academicEvents
                    .filter(ev => {
                        if (!ev.start) return false;
                        const start = new Date(ev.start);
                        return start.getMonth() === sidebarCurrentDate.getMonth() &&
                               start.getFullYear() === sidebarCurrentDate.getFullYear();
                    })
                    .sort((a, b) => new Date(a.start) - new Date(b.start))
                    .slice(0, 5);

                if (curMonthEvents.length === 0) {
                    eventsList.innerHTML = '<div class="text-gray-500 text-xs text-center py-2">Tidak ada kegiatan bulan ini</div>';
                    return;
                }

                console.log('🎯 Events to display:', curMonthEvents.length);

                curMonthEvents.forEach(ev => {
                    const start = new Date(ev.start);
                    const day = start.getDate();
                    const monthName = start.toLocaleDateString('id-ID', { month: 'short' });

                    const el = document.createElement('div');
                    el.className = 'flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition border border-gray-100';

                    el.innerHTML = `
                        <div class="w-8 h-8 rounded-full ${getEventColorClass(ev.color)} text-white flex items-center justify-center text-xs font-bold flex-shrink-0">
                            ${day}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-sm text-gray-800 truncate">${ev.title || 'No Title'}</div>
                            <div class="text-xs text-gray-500">${monthName} ${day}${ev.end && ev.end !== ev.start ? ' - ' + new Date(ev.end).getDate() : ''}</div>
                        </div>
                    `;

                    el.addEventListener('click', () => {
                        alert(`${ev.title}\n\n${ev.description || 'Tidak ada deskripsi.'}\n\nTanggal: ${ev.start}${ev.end && ev.end !== ev.start ? ' sampai ' + ev.end : ''}`);
                    });

                    eventsList.appendChild(el);
                });

                console.log('✅ Events list rendered');
            }

            // Load sidebar
            function loadSidebar() {
                renderSidebarCalendar();
                renderSidebarEventsList();
            }

            // Event listeners
            prevBtn.addEventListener('click', function() {
                sidebarCurrentDate.setMonth(sidebarCurrentDate.getMonth() - 1);
                console.log('⬅️ Previous month clicked');
                loadSidebar();
            });

            nextBtn.addEventListener('click', function() {
                sidebarCurrentDate.setMonth(sidebarCurrentDate.getMonth() + 1);
                console.log('➡️ Next month clicked');
                loadSidebar();
            });

            // Load data
            async function initSidebar() {
                console.log('🚀 Sidebar initialization started');

                const year = sidebarCurrentDate.getFullYear();
                const month = sidebarCurrentDate.getMonth() + 1;

                try {
                    academicEvents = await fetchEvents(year, month);
                    console.log('✅ Events loaded successfully');
                    loadSidebar();
                } catch (error) {
                    console.error('❌ Failed to initialize sidebar:', error);
                    grid.innerHTML = '<tr><td colspan="7" class="p-4 text-center text-red-500">Gagal memuat kalender</td></tr>';
                    eventsList.innerHTML = '<div class="text-red-500 text-xs text-center py-2">Error loading events</div>';
                }
            }

            // Initialize
            console.log('🔧 Setting up sidebar initialization...');

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('📄 DOM Content Loaded - initializing sidebar');
                    initSidebar();
                });
            } else {
                console.log('⚡ DOM already ready - initializing sidebar immediately');
                initSidebar();
            }

            console.log('🎉 Sidebar script setup complete');
        })();
    </script>
</div>
