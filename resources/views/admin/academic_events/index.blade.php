@extends('layouts.admin.admin')

@section('title', 'Kalender Akademik - Admin')

@section('content')
    <div class="container-fluid px-4">
        <!-- Simple Header -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h1 class="h3 mb-0">Kalender Akademik - Admin</h1>
        </div>

        <!-- Admin Controls -->
        <div class="card shadow mb-4 mt-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Manajemen Kegiatan</h5>
                    <button id="addEventBtn" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Tambah Kegiatan
                    </button>
                </div>
            </div>
        </div>

        <!-- Calendar Navigation -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <button id="prevMonth" class="btn btn-primary">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <h3 id="currentMonth" class="mb-0 text-center">Oktober 2024</h3>
                    <button id="nextMonth" class="btn btn-primary">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Calendar -->
        <div class="card shadow mb-4">
            <div class="card-body p-0">
                <!-- Calendar Header -->
                <div class="row g-0 text-center fw-bold bg-success text-white">
                    <div class="col p-3">Minggu</div>
                    <div class="col p-3">Senin</div>
                    <div class="col p-3">Selasa</div>
                    <div class="col p-3">Rabu</div>
                    <div class="col p-3">Kamis</div>
                    <div class="col p-3">Jumat</div>
                    <div class="col p-3">Sabtu</div>
                </div>

                <!-- Calendar Grid -->
                <div id="calendarGrid" class="p-2">
                    <!-- Calendar will be rendered here -->
                </div>
            </div>
        </div>

        <!-- Events List -->
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0">Kegiatan Bulan Ini</h5>
            </div>
            <div class="card-body">
                <div id="eventsList">
                    <p class="text-muted text-center mb-0">Tidak ada kegiatan untuk bulan ini</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kegiatan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="eventForm">
                    <div class="modal-body">
                        <input type="hidden" id="eventId">
                        <div class="mb-3">
                            <label class="form-label">Nama Kegiatan</label>
                            <input type="text" id="eventTitle" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" id="eventStartDate" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" id="eventEndDate" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea id="eventDescription" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Warna</label>
                            <div class="d-flex gap-2">
                                <div class="color-option bg-primary rounded-circle" style="width: 30px; height: 30px;"
                                    data-color="blue"></div>
                                <div class="color-option bg-success rounded-circle" style="width: 30px; height: 30px;"
                                    data-color="green"></div>
                                <div class="color-option bg-danger rounded-circle" style="width: 30px; height: 30px;"
                                    data-color="red"></div>
                                <div class="color-option bg-warning rounded-circle" style="width: 30px; height: 30px;"
                                    data-color="yellow"></div>
                                <div class="color-option bg-secondary rounded-circle" style="width: 30px; height: 30px;"
                                    data-color="purple"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .calendar-table {
            width: 100%;
            border-collapse: collapse;
        }

        .calendar-table th {
            background: #d1e7dd;
            padding: 12px;
            text-align: center;
            font-weight: bold;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .calendar-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            vertical-align: top;
            height: 100px;
            background: white;
        }

        .calendar-day {
            position: relative;
            height: 100%;
        }

        .calendar-day.other-month {
            background: #f8f9fa;
            color: #6c757d;
        }

        .day-number {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .add-event-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            background: none;
            border: none;
            color: #198754;
            cursor: pointer;
            padding: 2px;
            border-radius: 3px;
        }

        .add-event-btn:hover {
            background: #198754;
            color: white;
        }

        .event-badge {
            font-size: 0.75em;
            padding: 2px 6px;
            margin: 1px 0;
            border-radius: 3px;
            color: white;
            cursor: pointer;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .color-option {
            cursor: pointer;
            border: 2px solid transparent;
        }

        .color-option.selected {
            border-color: #495057;
        }

        .event-item {
            border-left: 4px solid;
            padding-left: 12px;
            margin-bottom: 1rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentDate = new Date();
            let events = [];
            let selectedColor = 'blue';

            // Elements
            const calendarGrid = document.getElementById('calendarGrid');
            const currentMonthEl = document.getElementById('currentMonth');
            const eventsList = document.getElementById('eventsList');
            const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
            const eventForm = document.getElementById('eventForm');
            const addEventBtn = document.getElementById('addEventBtn');

            // Initialize
            loadEvents();

            // Load events (admin API)
            async function loadEvents() {
                try {
                    const year = currentDate.getFullYear();
                    const month = currentDate.getMonth() + 1;
                    const monthParam = `${year}-${month.toString().padStart(2, '0')}`;

                    const response = await fetch(`/admin/kalender/api?month=${monthParam}`, {
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (response.ok) {
                        events = await response.json();
                    } else {
                        events = [];
                        console.warn('Gagal load events admin API', response.status);
                    }
                } catch (error) {
                    console.error('Error loading events:', error);
                    events = [];
                }
                renderCalendar();
                renderEventsList();
            }

            // Render calendar as table (more reliable)
            function renderCalendar() {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();

                currentMonthEl.textContent = new Date(year, month).toLocaleDateString('id-ID', {
                    month: 'long',
                    year: 'numeric'
                });

                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);
                const startDay = firstDay.getDay();
                const daysInMonth = lastDay.getDate();

                let calendarHTML = `
            <table class="calendar-table">
                <thead>
                    <tr>
                        <th>Minggu</th>
                        <th>Senin</th>
                        <th>Selasa</th>
                        <th>Rabu</th>
                        <th>Kamis</th>
                        <th>Jumat</th>
                        <th>Sabtu</th>
                    </tr>
                </thead>
                <tbody>
        `;

                let dayCount = 1;
                for (let week = 0; week < 6; week++) {
                    calendarHTML += '<tr>';
                    for (let dayOfWeek = 0; dayOfWeek < 7; dayOfWeek++) {
                        if ((week === 0 && dayOfWeek < startDay) || dayCount > daysInMonth) {
                            calendarHTML += '<td class="calendar-day other-month"></td>';
                        } else {
                            const dateStr =
                                `${year}-${(month + 1).toString().padStart(2, '0')}-${dayCount.toString().padStart(2, '0')}`;
                            const dayEvents = getEventsForDate(dateStr);

                            calendarHTML += `
                        <td class="calendar-day">
                            <div class="day-number">${dayCount}</div>
                            <button class="add-event-btn" data-date="${dateStr}" type="button">
                                <i class="fas fa-plus fa-xs"></i>
                            </button>
                            <div class="event-list">
                    `;

                            dayEvents.slice(0, 2).forEach(event => {
                                calendarHTML += `
                            <div class="event-badge ${getEventColorClass(event.color)}"
                                 onclick="editEvent(${event.id})"
                                 title="${event.title}">
                                ${event.title}
                            </div>
                        `;
                            });

                            if (dayEvents.length > 2) {
                                calendarHTML += `<small class="text-muted">+${dayEvents.length - 2} lebih</small>`;
                            }

                            calendarHTML += `
                            </div>
                        </td>
                    `;
                            dayCount++;
                        }
                    }
                    calendarHTML += '</tr>';
                    if (dayCount > daysInMonth) break;
                }

                calendarHTML += '</tbody></table>';
                calendarGrid.innerHTML = calendarHTML;

                // Add event listeners to per-day add buttons
                document.querySelectorAll('.add-event-btn').forEach(btn => {
                    btn.addEventListener('click', function(ev) {
                        // read attribute from button, don't pass event to openAddModal
                        const date = this.getAttribute('data-date');
                        openAddModal(date);
                    });
                });
            }

            // Render events list
            function renderEventsList() {
                const currentMonthEvents = events.filter(event => {
                    const eventDate = new Date(event.start_date || event.start);
                    return eventDate.getMonth() === currentDate.getMonth() &&
                        eventDate.getFullYear() === currentDate.getFullYear();
                });

                if (currentMonthEvents.length === 0) {
                    eventsList.innerHTML =
                        '<p class="text-muted text-center mb-0">Tidak ada kegiatan untuk bulan ini</p>';
                    return;
                }

                eventsList.innerHTML = currentMonthEvents.map(event => `
            <div class="event-item ${getEventBorderColorClass(event.color)}">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">${event.title}</h6>
                        <p class="text-muted small mb-1">
                            <i class="fas fa-calendar me-1"></i>
                            ${formatEventDate(event)}
                        </p>
                        ${event.description ? `<p class="small mb-0">${event.description}</p>` : ''}
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" onclick="editEvent(${event.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteEvent(${event.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
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
                const colors = {
                    'blue': 'bg-primary',
                    'green': 'bg-success',
                    'red': 'bg-danger',
                    'yellow': 'bg-warning',
                    'purple': 'bg-secondary'
                };
                return colors[color] || 'bg-primary';
            }

            function getEventBorderColorClass(color) {
                const colors = {
                    'blue': 'border-primary',
                    'green': 'border-success',
                    'red': 'border-danger',
                    'yellow': 'border-warning',
                    'purple': 'border-secondary'
                };
                return colors[color] || 'border-primary';
            }

            function formatEventDate(event) {
                const startDate = new Date(event.start_date || event.start);
                const endDate = event.end_date ? new Date(event.end_date) :
                    event.end ? new Date(event.end) : startDate;

                const startStr = startDate.toLocaleDateString('id-ID');
                const endStr = endDate.toLocaleDateString('id-ID');

                return startStr === endStr ? startStr : `${startStr} - ${endStr}`;
            }

            // Event handlers
            // date parameter may be undefined or a string; guard against event object
            function openAddModal(date = '') {
                // if date is an Event (pointer), ignore it
                if (date && typeof date === 'object' && date.type) {
                    date = '';
                }

                document.getElementById('eventId').value = '';
                document.getElementById('eventTitle').value = '';
                document.getElementById('eventDescription').value = '';

                const today = new Date().toISOString().split('T')[0];
                document.getElementById('eventStartDate').value = date || today;
                document.getElementById('eventEndDate').value = date || today;

                selectedColor = 'blue';
                updateColorSelection();

                const modalTitle = document.querySelector('.modal-title');
                if (modalTitle) modalTitle.textContent = 'Tambah Kegiatan Baru';
                eventModal.show();
            }

            window.editEvent = function(eventId) {
                const event = events.find(e => e.id == eventId);
                if (!event) return;

                document.getElementById('eventId').value = event.id;
                document.getElementById('eventTitle').value = event.title;
                document.getElementById('eventStartDate').value = event.start_date || event.start;
                document.getElementById('eventEndDate').value = event.end_date || event.end || event
                    .start_date || event.start;
                document.getElementById('eventDescription').value = event.description || '';

                selectedColor = event.color || 'blue';
                updateColorSelection();

                const modalTitle = document.querySelector('.modal-title');
                if (modalTitle) modalTitle.textContent = 'Edit Kegiatan';
                eventModal.show();
            };

            window.deleteEvent = async function(eventId) {
                if (!confirm('Yakin ingin menghapus kegiatan ini?')) return;

                try {
                    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                    const token = tokenMeta ? tokenMeta.content : null;

                    const response = await fetch(`/admin/kalender/${eventId}`, {
                        method: 'DELETE',
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': token || '',
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        await loadEvents();
                    } else {
                        console.error('Delete failed', response.status);
                        alert('Gagal hapus event. Cek console/network/server log.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi error saat menghapus. Lihat console.');
                }
            };

            function updateColorSelection() {
                document.querySelectorAll('.color-option').forEach(option => {
                    if (option.getAttribute('data-color') === selectedColor) {
                        option.classList.add('selected');
                    } else {
                        option.classList.remove('selected');
                    }
                });
            }

            // Event listeners
            if (addEventBtn) {
                // wrap call so event object is not forwarded as `date`
                addEventBtn.addEventListener('click', () => openAddModal());
            }

            const prevBtn = document.getElementById('prevMonth');
            const nextBtn = document.getElementById('nextMonth');
            if (prevBtn) prevBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                loadEvents();
            });
            if (nextBtn) nextBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                loadEvents();
            });

            document.querySelectorAll('.color-option').forEach(option => {
                option.addEventListener('click', function() {
                    selectedColor = this.getAttribute('data-color');
                    updateColorSelection();
                });
            });

            eventForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                const token = tokenMeta ? tokenMeta.content : null;
                if (!token) {
                    alert(
                        'CSRF token tidak ditemukan. Pastikan layout admin menambahkan <meta name="csrf-token" /> di head.');
                    console.error('CSRF token missing: document.querySelector returned', tokenMeta);
                    return;
                }

                const formData = {
                    title: document.getElementById('eventTitle').value,
                    start_date: document.getElementById('eventStartDate').value,
                    end_date: document.getElementById('eventEndDate').value,
                    description: document.getElementById('eventDescription').value,
                    color: selectedColor,
                    is_published: true
                };

                const eventId = document.getElementById('eventId').value;
                const url = eventId ? `/admin/kalender/${eventId}` : '/admin/kalender';
                const method = eventId ? 'PUT' : 'POST';

                try {
                    const response = await fetch(url, {
                        method: method,
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(formData)
                    });

                    const text = await response.text();
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        data = text;
                    }

                    console.log('submit response', response.status, data);

                    if (response.ok) {
                        eventModal.hide();
                        await loadEvents();
                    } else {
                        // show helpful error messages
                        if (response.status === 422 && data.errors) {
                            const messages = Object.values(data.errors).flat().join('\n');
                            alert('Validation error:\n' + messages);
                        } else if (response.status === 419) {
                            alert('CSRF/session error (419). Silakan login ulang dan coba lagi.');
                        } else if (data.message) {
                            alert('Error: ' + data.message);
                        } else {
                            alert('Terjadi kesalahan. Lihat console/network dan laravel.log');
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Gagal mengirim request. Lihat console untuk detail.');
                }
            });
        });
    </script>
@endsection
