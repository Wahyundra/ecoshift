function updateClock() {
    const clockElement = document.getElementById('live-clock');
    if (clockElement) {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;
        clockElement.textContent = timeString;
    }
}

function updateAdminClock() {
    const dateElement = document.getElementById('live-date');
    const timeElement = document.getElementById('live-time');

    if (dateElement && timeElement) {
        const now = new Date();
        const dateString = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        const timeString = now.toLocaleTimeString('id-ID');

        dateElement.textContent = dateString;
        timeElement.textContent = timeString;
    }
}

function suggestTaskDate() {
    const dayOfWeekSelect = document.getElementById('day_of_week');
    const taskDateInput = document.getElementById('task_date');
    const selectedDay = parseInt(dayOfWeekSelect.value);

    if (selectedDay) {
        const today = new Date();
        const currentDay = today.getDay(); // 0 for Sunday, 1 for Monday, ..., 6 for Saturday
        let daysUntilNext = selectedDay - currentDay;

        if (daysUntilNext <= 0) {
            daysUntilNext += 7; // Go to next week if the day has already passed or is today
        }

        const nextDate = new Date(today);
        nextDate.setDate(today.getDate() + daysUntilNext);

        const year = nextDate.getFullYear();
        const month = (nextDate.getMonth() + 1).toString().padStart(2, '0');
        const day = nextDate.getDate().toString().padStart(2, '0');

        taskDateInput.value = `${year}-${month}-${day}`;
    } else {
        taskDateInput.value = '';
    }
}

function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tab-button");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Update the clocks every second
setInterval(updateClock, 1000);
setInterval(updateAdminClock, 1000);

// Initial call to display the clocks immediately
updateClock();
updateAdminClock();

// Loading screen logic
window.addEventListener('load', function() {
    const loadingScreen = document.getElementById('loading-screen');
    const loginContainer = document.querySelector('.login-container');
    
    if (loadingScreen && loginContainer) {
        setTimeout(function() {
            loadingScreen.style.display = 'none';
            loginContainer.style.display = 'flex';
        }, 1000); // 1 second delay
    }
});

// DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', function() {
    // Active link indicator
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.nav-links ul li a');

    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href');
        if (linkPage === currentPage) {
            link.classList.add('active-link');
        }
    });

    // Hamburger menu toggle
    const hamburgerButton = document.querySelector('.hamburger-menu');
    const navLinksContainer = document.querySelector('.nav-links');

    if (hamburgerButton && navLinksContainer) {
        hamburgerButton.addEventListener('click', function() {
            navLinksContainer.classList.toggle('active');
        });
    }

    // Auto-scroll to user's schedule
    const userScheduleEntry = document.getElementById('user-schedule-entry');
    if (userScheduleEntry) {
        userScheduleEntry.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Collapsible today's schedule list on dashboard_student.php
    const toggleTodayBtn = document.getElementById('toggle-today-schedule');
    const todayScheduleList = document.getElementById('today-schedule-list');

    if (toggleTodayBtn && todayScheduleList) {
        toggleTodayBtn.addEventListener('click', function() {
            todayScheduleList.classList.toggle('expanded');
            if (todayScheduleList.classList.contains('expanded')) {
                toggleTodayBtn.textContent = 'Sembunyikan';
            } else {
                toggleTodayBtn.textContent = 'Lihat Semuanya';
            }
        });
    }
});

// Scroll to top button logic
const scrollTopBtn = document.getElementById("scrollTopBtn");

if (scrollTopBtn) {
    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            scrollTopBtn.style.display = "block";
        } else {
            scrollTopBtn.style.display = "none";
        }
    };

    // When the user clicks on the button, scroll to the top of the document
    scrollTopBtn.addEventListener("click", function() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    });
}

// Collapsible schedule list on manage_schedule.php
const toggleBtn = document.getElementById('toggleScheduleBtn');
const scheduleList = document.getElementById('scheduleListContainer');

if (toggleBtn && scheduleList) {
    toggleBtn.addEventListener('click', function() {
        scheduleList.classList.toggle('expanded');
        if (scheduleList.classList.contains('expanded')) {
            toggleBtn.textContent = 'Sembunyikan';
        } else {
            toggleBtn.textContent = 'Lihat Semuanya';
        }
    });
}