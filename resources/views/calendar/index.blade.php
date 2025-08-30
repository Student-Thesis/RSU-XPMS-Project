@extends('layouts.app')

@section('content')

            <!-- Content -->
            <div id="content">
                <!-- Topbar -->
                <div class="topbar">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="full">
                            <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i
                                    class="fa fa-bars"></i></button>
                            <div class="logo_section">
                                <a href="index.html"><img class="img-responsive" src="images/logo/logo.png"
                                        alt="#" /></a>
                            </div>
                            <div class="right_topbar">
                                <div class="icon_info">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-bell-o"></i><span
                                                    class="badge">2</span></a></li>
                                        <li><a href="#"><i class="fa fa-question-circle"></i></a></li>
                                        <li><a href="#"><i class="fa fa-envelope-o"></i><span
                                                    class="badge">3</span></a></li>
                                    </ul>
                                    <ul class="user_profile_dd">
                                        <li>
                                            <a class="dropdown-toggle" data-toggle="dropdown">
                                                <img class="img-responsive rounded-circle"
                                                    src="images/layout_img/user_img.jpg" alt="#" />
                                                <span class="name_user">John David</span>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="profile.html">My Profile</a>
                                                <a class="dropdown-item" href="settings.html">Settings</a>
                                                <a class="dropdown-item" href="help.html">Help</a>
                                                <a class="dropdown-item" href="#"><span>Log Out</span> <i
                                                        class="fa fa-sign-out"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
                <!-- End Topbar -->

                <!-- Main Content -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Calendar</h2>
                                </div>
                            </div>
                        </div>

                        <div class="white_shd full margin_bottom_30">
                            <div class="full">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h4>Project Events Calendar</h4>
                                    </div>
                                </div>
                                <div class="full padding_infor_info">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Main Content -->
            </div>
            <!-- End Content -->
        </div>
    </div>

    <!-- Add Event Modal -->
    <div id="addEventModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add New Project Event</h3>
                    <button class="close-btn" onclick="closeAddEventModal()">&times;</button>
                </div>
                <form id="eventForm">
                    <div class="form-group">
                        <label class="form-label">Project Title *</label>
                        <input type="text" id="eventTitle" class="form-input"
                            placeholder="Enter project title..." required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea id="eventDescription" class="form-input form-textarea" placeholder="Enter project description..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date *</label>
                        <input type="date" id="eventDate" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">End Date (Optional)</label>
                        <input type="date" id="eventEndDate" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Project Type</label>
                        <select id="eventType" class="form-input">
                            <option value="">Select project type...</option>
                            <option value="Development">Development</option>
                            <option value="Testing">Testing</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Deadline">Deadline</option>
                            <option value="Review">Review</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Priority</label>
                        <select id="eventPriority" class="form-input">
                            <option value="Low">Low</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="High">High</option>
                            <option value="Critical">Critical</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Color</label>
                        <div class="color-picker-container">
                            <div class="color-option selected" style="background-color: #007bff;"
                                data-color="#007bff"></div>
                            <div class="color-option" style="background-color: #28a745;" data-color="#28a745"></div>
                            <div class="color-option" style="background-color: #dc3545;" data-color="#dc3545"></div>
                            <div class="color-option" style="background-color: #ffc107;" data-color="#ffc107"></div>
                            <div class="color-option" style="background-color: #6f42c1;" data-color="#6f42c1"></div>
                            <div class="color-option" style="background-color: #fd7e14;" data-color="#fd7e14"></div>
                            <div class="color-option" style="background-color: #20c997;" data-color="#20c997"></div>
                            <div class="color-option" style="background-color: #6c757d;" data-color="#6c757d"></div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary"
                            onclick="closeAddEventModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Event Modal -->
    <div id="viewEventModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Project Event Details</h3>
                    <button class="close-btn" onclick="closeViewEventModal()">&times;</button>
                </div>
                <div id="eventDetails">
                    <!-- Event details will be populated here -->
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-danger" onclick="deleteEvent()">Delete Event</button>
                    <button type="button" class="btn btn-secondary" onclick="closeViewEventModal()">Close</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <!-- End Main Content -->
    </div>
    <!-- End Content -->
    </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/perfect-scrollbar.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/settings.js"></script>

    <!-- FullCalendar Scripts - Load these in the correct order -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        let currentCalendar;
        let currentSelectedEvent;
        let selectedColor = '#007bff';

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            if (calendarEl) {
                try {
                    currentCalendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        selectable: true,
                        editable: true,
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        height: 'auto',
                        // Sample events for demonstration
                        events: [{
                                id: 'sample1',
                                title: 'Website Development',
                                start: '2025-07-10',
                                color: '#28a745',
                                extendedProps: {
                                    description: 'Frontend development phase of the company website',
                                    type: 'Development',
                                    priority: 'High'
                                }
                            },
                            {
                                id: 'sample2',
                                title: 'Client Meeting',
                                start: '2025-07-15',
                                end: '2025-07-15',
                                color: '#007bff',
                                extendedProps: {
                                    description: 'Quarterly review meeting with client stakeholders',
                                    type: 'Meeting',
                                    priority: 'Medium'
                                }
                            },
                            {
                                id: 'sample3',
                                title: 'Project Deadline',
                                start: '2025-07-20',
                                color: '#dc3545',
                                extendedProps: {
                                    description: 'Final submission deadline for Phase 1',
                                    type: 'Deadline',
                                    priority: 'Critical'
                                }
                            }
                        ],
                        dateClick: function(info) {
                            openAddEventModal(info.dateStr);
                        },
                        eventClick: function(info) {
                            currentSelectedEvent = info.event;
                            showEventDetails(info.event);
                        },
                        eventDidMount: function(info) {
                            if (info.event.extendedProps.description) {
                                info.el.setAttribute('title', info.event.title + '\n' + info.event
                                    .extendedProps.description);
                            }
                        }
                    });

                    currentCalendar.render();
                    console.log('Calendar loaded successfully');

                } catch (e) {
                    console.error('Calendar loading error:', e);
                    calendarEl.classList.add('error');
                    calendarEl.innerHTML =
                        '<div style="padding: 20px; text-align: center;"><h3>Failed to load calendar</h3><p>Error: ' +
                        e.message + '</p></div>';
                }
            } else {
                console.error('Calendar element not found');
            }

            // Initialize color picker
            setupColorPicker();
        });

        function setupColorPicker() {
            const colorOptions = document.querySelectorAll('.color-option');
            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    colorOptions.forEach(opt => opt.classList.remove('selected'));
                    // Add selected class to clicked option
                    this.classList.add('selected');
                    selectedColor = this.dataset.color;
                });
            });
        }

        function openAddEventModal(dateStr) {
            document.getElementById('eventDate').value = dateStr;
            document.getElementById('addEventModal').style.display = 'block';
            document.getElementById('eventTitle').focus();
        }

        function closeAddEventModal() {
            document.getElementById('addEventModal').style.display = 'none';
            document.getElementById('eventForm').reset();
            // Reset color selection
            document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
            document.querySelector('.color-option[data-color="#007bff"]').classList.add('selected');
            selectedColor = '#007bff';
        }

        function showEventDetails(event) {
            const modal = document.getElementById('viewEventModal');
            const detailsContainer = document.getElementById('eventDetails');

            const startDate = new Date(event.start);
            const endDate = event.end ? new Date(event.end) : null;

            detailsContainer.innerHTML = `
        <div class="event-detail">
          <div class="event-detail-label">Project Title:</div>
          <div class="event-detail-value">
            <span class="event-color-indicator" style="background-color: ${event.color || '#007bff'}"></span>
            ${event.title}
          </div>
        </div>
        <div class="event-detail">
          <div class="event-detail-label">Description:</div>
          <div class="event-detail-value">${event.extendedProps.description || 'No description provided'}</div>
        </div>
        <div class="event-detail">
          <div class="event-detail-label">Start Date:</div>
          <div class="event-detail-value">${startDate.toLocaleDateString()}</div>
        </div>
        ${endDate ? `
            <div class="event-detail">
              <div class="event-detail-label">End Date:</div>
              <div class="event-detail-value">${endDate.toLocaleDateString()}</div>
            </div>
            ` : ''}
        <div class="event-detail">
          <div class="event-detail-label">Project Type:</div>
          <div class="event-detail-value">${event.extendedProps.type || 'Not specified'}</div>
        </div>
        <div class="event-detail">
          <div class="event-detail-label">Priority:</div>
          <div class="event-detail-value">
            <span style="color: ${getPriorityColor(event.extendedProps.priority)}; font-weight: bold;">
              ${event.extendedProps.priority || 'Medium'}
            </span>
          </div>
        </div>
      `;

            modal.style.display = 'block';
        }

        function closeViewEventModal() {
            document.getElementById('viewEventModal').style.display = 'none';
            currentSelectedEvent = null;
        }

        function deleteEvent() {
            if (currentSelectedEvent && confirm('Are you sure you want to delete this event?')) {
                currentSelectedEvent.remove();
                closeViewEventModal();
            }
        }

        function getPriorityColor(priority) {
            switch (priority) {
                case 'Critical':
                    return '#dc3545';
                case 'High':
                    return '#fd7e14';
                case 'Medium':
                    return '#ffc107';
                case 'Low':
                    return '#28a745';
                default:
                    return '#6c757d';
            }
        }

        // Handle form submission
        document.getElementById('eventForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const title = document.getElementById('eventTitle').value;
            const description = document.getElementById('eventDescription').value;
            const startDate = document.getElementById('eventDate').value;
            const endDate = document.getElementById('eventEndDate').value;
            const type = document.getElementById('eventType').value;
            const priority = document.getElementById('eventPriority').value;

            if (title && startDate) {
                const eventData = {
                    id: 'event_' + Date.now(),
                    title: title,
                    start: startDate,
                    color: selectedColor,
                    extendedProps: {
                        description: description,
                        type: type,
                        priority: priority
                    }
                };

                if (endDate) {
                    eventData.end = endDate;
                }

                currentCalendar.addEvent(eventData);
                closeAddEventModal();
            }
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                if (e.target.id === 'addEventModal') {
                    closeAddEventModal();
                } else if (e.target.id === 'viewEventModal') {
                    closeViewEventModal();
                }
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddEventModal();
                closeViewEventModal();
            }
        });
    </script>
@endsection
