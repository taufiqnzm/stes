// calendar.js

document.addEventListener("DOMContentLoaded", function () {
    const currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();

    const calendarDates = document.getElementById("calendar-dates");
    const currentMonthElement = document.getElementById("current-month");
    const prevMonthButton = document.getElementById("prev-month");
    const nextMonthButton = document.getElementById("next-month");
    const eventDateInput = document.getElementById("event-date");
    const eventDescriptionInput = document.getElementById("event-description");
    const addEventButton = document.getElementById("add-event");

    // Function to generate the calendar grid
    function generateCalendar(year, month) {
        calendarDates.innerHTML = "";
        currentMonthElement.textContent = new Date(year, month).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();

        // Fill in the leading empty cells
        for (let i = 0; i < firstDay.getDay(); i++) {
            const emptyCell = document.createElement("div");
            calendarDates.appendChild(emptyCell);
        }

        // Fill in the days of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const dateCell = document.createElement("div");
            dateCell.textContent = day;
            calendarDates.appendChild(dateCell);

            // Add event listener to each date cell
            dateCell.addEventListener("click", function () {
                const selectedDate = new Date(year, month, day);
                eventDateInput.value = selectedDate.toISOString().substr(0, 10);
            });
        }
    }

    // Initial calendar generation
    generateCalendar(currentYear, currentMonth);

    // Event listeners for changing months
    prevMonthButton.addEventListener("click", function () {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentYear, currentMonth);
    });

    nextMonthButton.addEventListener("click", function () {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentYear, currentMonth);
    });

    // Event listener for adding events
    addEventButton.addEventListener("click", function () {
        const date = eventDateInput.value;
        const description = eventDescriptionInput.value;
        if (date && description) {
            // You can handle the event data here (e.g., store it in an array or send it to a server)
            alert(`Event added for ${date}: ${description}`);
            eventDateInput.value = "";
            eventDescriptionInput.value = "";
        } else {
            alert("Please select a date and enter a description for the event.");
        }
    });
});
