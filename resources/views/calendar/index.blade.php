@extends('layouts.app')

@section('title', 'Kalender Akademik')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-blue-400 mb-2">Kalender Akademik</h1>
            <p class="text-gray-300">Lihat kegiatan kampus per bulan. Klik judul acara untuk detail lengkap.</p>
        </div>

        <!-- Calendar Navigation - Large Icons -->
        <div class="flex justify-between items-center mb-6 bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-700">
            <button id="prevMonth"
                class="bg-blue-600 hover:bg-blue-500 text-white w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                <i class="fas fa-chevron-left text-lg"></i>
            </button>

            <div class="text-center flex-1 mx-4">
                <h2 id="currentMonth" class="text-2xl font-bold text-white">November 2024</h2>
                <p class="text-sm text-gray-400">Kalender Akademik</p>
            </div>

            <button id="nextMonth"
                class="bg-blue-600 hover:bg-blue-500 text-white w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                <i class="fas fa-chevron-right text-lg"></i>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Calendar Grid (besar) -->
            <div class="lg:col-span-3 bg-gray-800 rounded-lg shadow border border-gray-700 overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-700 border-b-2 border-gray-600">
                            <th class="p-4 text-center font-semibold text-blue-300 border-r border-gray-600">Minggu</th>
                            <th class="p-4 text-center font-semibold text-blue-300 border-r border-gray-600">Senin</th>
                            <th class="p-4 text-center font-semibold text-blue-300 border-r border-gray-600">Selasa</th>
                            <th class="p-4 text-center font-semibold text-blue-300 border-r border-gray-600">Rabu</th>
                            <th class="p-4 text-center font-semibold text-blue-300 border-r border-gray-600">Kamis</th>
                            <th class="p-4 text-center font-semibold text-blue-300 border-r border-gray-600">Jumat</th>
                            <th class="p-4 text-center font-semibold text-blue-300">Sabtu</th>
                        </tr>
                    </thead>
                    <tbody id="calendarGrid"></tbody>
                </table>
            </div>

            <!-- Events Sidebar -->
            <aside class="space-y-6">
                <!-- Kegiatan Mendatang -->
                <div class="bg-gray-800 rounded-lg shadow p-4 border border-gray-700">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-calendar-check text-blue-400"></i> Kegiatan Bulan Ini
                    </h3>
                    <div id="eventsList" class="space-y-3 max-h-96 overflow-y-auto text-sm"></div>
                </div>
            </aside>
        </div>
    </div>

    <!-- Event Detail Modal -->
    <div id="eventDetailModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-gray-800 rounded-lg shadow-2xl w-full max-w-md max-h-96 overflow-y-auto border border-gray-700">
            <div class="flex justify-between items-center p-6 border-b border-gray-600 sticky top-0 bg-gray-800">
                <h3 class="text-xl font-semibold text-white">Detail Kegiatan</h3>
                <button id="closeDetailModal" class="text-gray-400 hover:text-white text-2xl transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-start gap-3">
                    <div id="detailColorBadge" class="w-4 h-4 rounded-full mt-1"></div>
                    <h4 id="detailEventTitle" class="font-bold text-lg text-white flex-1"></h4>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-gray-300">
                        <i class="fas fa-calendar text-blue-400 w-5"></i>
                        <span id="detailEventDate" class="text-sm"></span>
                    </div>
                    <p id="detailEventDescription" class="text-gray-300 leading-relaxed"></p>
                </div>
            </div>
            <div class="flex justify-end p-6 border-t border-gray-600 gap-3 sticky bottom-0 bg-gray-800">
                <button id="closeDetail"
                    class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition">Tutup</button>
            </div>
        </div>
    </div>

    <style>
        .calendar-day {
            min-height: 120px;
            border: 1px solid #374151;
            padding: 8px;
            background: #1f2937;
            position: relative;
        }

        .calendar-day.other-month {
            background: #111827;
            color: #6b7280;
        }

        .calendar-day.today {
            background: #1e3a8a;
            border-color: #3b82f6;
        }

        .day-number {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .bg-blue-500 {
        background-color: #3b82f6 !important;
        color: white !important;
        border: none !important;
    }
    .bg-green-500 {
        background-color: #10b981 !important;
        color: white !important;
        border: none !important;
    }
    .bg-red-500 {
        background-color: #ef4444 !important;
        color: white !important;
        border: none !important;
    }
    .bg-yellow-500 {
        background-color: #f59e0b !important;
        color: #1f2937 !important;
        border: none !important;
    }
    .bg-purple-500 {
        background-color: #8b5cf6 !important;
        color: white !important;
        border: none !important;
    }

    /* Secondary colors untuk event list */
    .border-blue-500 { border-color: #3b82f6 !important; }
    .border-green-500 { border-color: #10b981 !important; }
    .border-red-500 { border-color: #ef4444 !important; }
    .border-yellow-500 { border-color: #f59e0b !important; }
    .border-purple-500 { border-color: #8b5cf6 !important; }

    /* === FIX EVENT BADGE STYLING === */
    .event-badge {
        font-size: 0.75em;
        padding: 4px 8px;
        margin: 2px 0;
        border-radius: 6px;
        cursor: pointer;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 600;
        display: block;
        text-align: center;
    }

    .event-badge:hover {
        opacity: 0.8;
        transform: scale(1.05);
    }

    .event-item {
        border-left: 4px solid;
        padding-left: 12px;
        margin-bottom: 1rem;
        cursor: pointer;
        border-radius: 0 8px 8px 0;
    }

    .event-item:hover {
        background: #374151;
    }

    /* Custom scrollbar untuk dark theme */
    #eventsList::-webkit-scrollbar {
        width: 6px;
    }

    #eventsList::-webkit-scrollbar-track {
        background: #374151;
        border-radius: 3px;
    }

    #eventsList::-webkit-scrollbar-thumb {
        background: #6b7280;
        border-radius: 3px;
    }

    #eventsList::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let events = [];
            let currentDate = new Date();

            // DOM Elements
            const prevMonthBtn = document.getElementById('prevMonth');
            const nextMonthBtn = document.getElementById('nextMonth');
            const currentMonthEl = document.getElementById('currentMonth');
            const calendarGrid = document.getElementById('calendarGrid');
            const eventsList = document.getElementById('eventsList');
            const eventDetailModal = document.getElementById('eventDetailModal');
            const closeDetailModal = document.getElementById('closeDetailModal');
            const closeDetail = document.getElementById('closeDetail');

            // Initialize calendar
            initCalendar();

            function initCalendar() {
                loadEvents();
                setupEventListeners();
            }

            // Load events from server
            async function loadEvents() {
                try {
                    const year = currentDate.getFullYear();
                    const month = currentDate.getMonth() + 1;
                    const monthParam = `${year}-${month.toString().padStart(2, '0')}`;

                    const response = await fetch(`/api/events?month=${monthParam}`);
                    if (response.ok) {
                        events = await response.json();
                    } else {
                        events = [];
                    }
                } catch (error) {
                    console.error('Error loading events:', error);
                    events = [];
                }

                renderCalendar();
                renderEventsList();
            }

            // Render calendar
            function renderCalendar() {
                if (!calendarGrid) return;

                calendarGrid.innerHTML = '';

                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();

                // Update month display
                currentMonthEl.textContent = new Date(year, month).toLocaleDateString('id-ID', {
                    month: 'long',
                    year: 'numeric'
                });

                // Get first day of month and last day of month
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);

                // Get day of week for first day (0 = Sunday, 1 = Monday, etc.)
                const firstDayOfWeek = firstDay.getDay();

                const today = new Date();
                let dayCount = 1;

                // Create weeks (max 6 weeks)
                for (let week = 0; week < 6; week++) {
                    const weekRow = document.createElement('tr');

                    // Create days for this week (7 days)
                    for (let dayOfWeek = 0; dayOfWeek < 7; dayOfWeek++) {
                        const dayCell = document.createElement('td');
                        dayCell.className = 'min-h-24 border border-gray-600 p-2 align-top';

                        // Check if we're still in the current month
                        if ((week === 0 && dayOfWeek < firstDayOfWeek) || dayCount > lastDay.getDate()) {
                            // Days from previous or next month
                            dayCell.className += ' bg-gray-900 text-gray-500';
                        } else {
                            // Current month days
                            const dateStr =
                                `${year}-${String(month + 1).padStart(2, '0')}-${String(dayCount).padStart(2, '0')}`;
                            const isToday = today.getDate() === dayCount &&
                                today.getMonth() === month &&
                                today.getFullYear() === year;

                            if (isToday) {
                                dayCell.className += ' bg-blue-900 border-blue-400 border-2';
                            } else {
                                dayCell.className += ' bg-gray-800 hover:bg-gray-700 transition';
                            }

                            const dayEvents = getEventsForDate(dateStr);

                            dayCell.innerHTML = `
                        <div class="day-number ${isToday ? 'text-blue-300' : 'text-white'}">${dayCount}</div>
                        <div class="mt-1 space-y-1">
                            ${dayEvents.map(event => `
                                    <div class="event-badge ${getEventColorClass(event.color)}"
                                         onclick="showEventDetail(${event.id})"
                                         title="${event.title}">
                                        ${event.title}
                                    </div>
                                `).join('')}
                            ${dayEvents.length > 2 ? `
                                    <div class="text-xs text-gray-400 font-medium">+${dayEvents.length - 2} lebih</div>
                                ` : ''}
                        </div>
                    `;

                            dayCount++;
                        }

                        weekRow.appendChild(dayCell);
                    }

                    calendarGrid.appendChild(weekRow);

                    // Stop if we've rendered all days
                    if (dayCount > lastDay.getDate()) break;
                }
            }

            // Render events list
            function renderEventsList() {
                if (!eventsList) return;

                eventsList.innerHTML = '';

                const currentMonthEvents = events.filter(event => {
                    const eventStart = new Date(event.start_date || event.start);
                    return eventStart.getMonth() === currentDate.getMonth() &&
                        eventStart.getFullYear() === currentDate.getFullYear();
                }).sort((a, b) => new Date(a.start_date || a.start) - new Date(b.start_date || b.start));

                if (currentMonthEvents.length === 0) {
                    eventsList.innerHTML =
                        '<p class="text-gray-500 text-center py-6">Tidak ada kegiatan untuk bulan ini.</p>';
                    return;
                }

                currentMonthEvents.forEach(event => {
                    const eventElement = document.createElement('div');
                    eventElement.className = 'event-item ' + getEventBorderColorClass(event.color);
                    eventElement.onclick = () => showEventDetail(event.id);

                    const startDate = new Date(event.start_date || event.start);
                    const day = startDate.getDate();

                    eventElement.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full ${getEventColorClass(event.color)} text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                        ${day}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-white truncate text-sm">${event.title}</div>
                        <div class="text-xs text-gray-400">${formatEventDate(event)}</div>
                    </div>
                </div>
            `;

                    eventsList.appendChild(eventElement);
                });
            }

            // Helper functions
            function getEventsForDate(dateStr) {
                return events.filter(event => {
                    const eventStart = new Date(event.start_date || event.start);
                    const eventEnd = event.end_date ? new Date(event.end_date) :
                        event.end ? new Date(event.end) : new Date(event.start_date || event.start);
                    const targetDate = new Date(dateStr);

                    eventStart.setHours(0, 0, 0, 0);
                    eventEnd.setHours(23, 59, 59, 999);
                    targetDate.setHours(12, 0, 0, 0);

                    return targetDate >= eventStart && targetDate <= eventEnd;
                });
            }

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

            function getEventBorderColorClass(color) {
                const colorMap = {
                    'blue': 'border-blue-500',
                    'green': 'border-green-500',
                    'red': 'border-red-500',
                    'yellow': 'border-yellow-500',
                    'purple': 'border-purple-500'
                };
                return colorMap[color] || 'border-blue-500';
            }

            function formatEventDate(event) {
                const startDate = new Date(event.start_date || event.start);
                const endDate = event.end_date ? new Date(event.end_date) :
                    event.end ? new Date(event.end) : startDate;

                const startStr = startDate.toLocaleDateString('id-ID');
                const endStr = endDate.toLocaleDateString('id-ID');

                return startStr === endStr ? startStr : `${startStr} - ${endStr}`;
            }

            // Show event detail
            window.showEventDetail = function(eventId) {
                const event = events.find(e => e.id == eventId);
                if (!event) return;

                document.getElementById('detailEventTitle').textContent = event.title || '';
                document.getElementById('detailEventDate').textContent = formatEventDate(event);
                document.getElementById('detailEventDescription').textContent = event.description ||
                    'Tidak ada deskripsi.';
                document.getElementById('detailColorBadge').className =
                    `w-4 h-4 rounded-full ${getEventColorClass(event.color)}`;

                eventDetailModal.classList.remove('hidden');
            };

            // Close event detail modal
            function closeEventDetailModal() {
                eventDetailModal.classList.add('hidden');
            }

            // Setup event listeners
            function setupEventListeners() {
                // Month navigation
                prevMonthBtn.addEventListener('click', function() {
                    currentDate.setMonth(currentDate.getMonth() - 1);
                    loadEvents();
                });

                nextMonthBtn.addEventListener('click', function() {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    loadEvents();
                });

                // Modal controls
                closeDetailModal.addEventListener('click', closeEventDetailModal);
                closeDetail.addEventListener('click', closeEventDetailModal);

                // Close modal when clicking outside
                eventDetailModal.addEventListener('click', function(e) {
                    if (e.target === eventDetailModal) {
                        closeEventDetailModal();
                    }
                });

                // Close modal with Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeEventDetailModal();
                    }
                });
            }
        });
    </script>

<style>
/* MEMASTIKAN SELURUH HALAMAN TETAP GELAP MESKIPUN MODE LIGHT */
body {
    background-color: #111827 !important;
    color: #e5e7eb !important;
}

/* Override untuk semua elemen container */
.bg-white, .bg-gray-50, .bg-gray-100 {
    background-color: #1f2937 !important;
}

/* Memastikan text tetap terang */
.text-gray-800, .text-gray-900, .text-gray-700, .text-gray-600 {
    color: #e5e7eb !important;
}

/* Untuk card/container spesifik */
.bg-gray-800 {
    background-color: #1f2937 !important;
}

.bg-gray-900 {
    background-color: #111827 !important;
}

.bg-gray-700 {
    background-color: #374151 !important;
}

.border-gray-300, .border-gray-200 {
    border-color: #374151 !important;
}

.border-gray-600 {
    border-color: #4b5563 !important;
}

.border-gray-700 {
    border-color: #374151 !important;
}

/* Shadow override */
.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2) !important;
}

.shadow-2xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
}

/* Override khusus untuk mode light */
@media (prefers-color-scheme: light) {
    body {
        background-color: #111827 !important;
        color: #e5e7eb !important;
    }

    .bg-white {
        background-color: #1f2937 !important;
    }

    .text-gray-900, .text-gray-800, .text-gray-700 {
        color: #e5e7eb !important;
    }

    .border-gray-200 {
        border-color: #374151 !important;
    }
}
</style>
@endsection
