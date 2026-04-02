let people = [];
const groupPhoneNumber = "491781534757";
const baseMonday = new Date("2025-08-25");

// Load people.json ONLY (no localStorage)
async function loadPeople() {
  try {
    const response = await fetch("people.json?cache=" + Date.now());
    people = await response.json();
  } catch (e) {
    console.error("Failed to load people.json", e);
    people = [];
  }

  generateRecurringSchedule();
}

// Get Monday of current week
function getCurrentMonday() {
  const today = new Date();
  const monday = new Date(today);
  monday.setDate(monday.getDate() - ((monday.getDay() + 6) % 7));
  monday.setHours(0, 0, 0, 0);
  return monday;
}

// Generate schedule (weeks = number of people)
function generateRecurringSchedule() {
  const tbody = $("#scheduleTable tbody");
  tbody.empty();

  if (!people.length) {
    tbody.append(`<tr><td colspan="4">No people found.</td></tr>`);
    return;
  }

  const currentMonday = getCurrentMonday();
  const today = new Date();
  const totalWeeks = people.length;

  for (let i = 0; i < totalWeeks; i++) {
    const weekStart = new Date(currentMonday);
    weekStart.setDate(currentMonday.getDate() + i * 7);

    const weekEnd = new Date(weekStart);
    weekEnd.setDate(weekStart.getDate() + 6);

    const weeksSinceBase = Math.floor((weekStart - baseMonday) / (7 * 86400000));
    const personIndex = ((weeksSinceBase % people.length) + people.length) % people.length;
    const assigned = people[personIndex];

    const isCurrentWeek = today >= weekStart && today <= weekEnd;

    const row = `
      <tr class="${isCurrentWeek ? "current-week" : ""}">
        <td>${weekStart.toDateString()}</td>
        <td>${weekEnd.toDateString()}</td>
        <td>${assigned.name}</td>
        <td>
          <button class="sendMessage"
            data-phone="${assigned.phone}"
            data-name="${assigned.name}"
            data-start="${weekStart.toDateString()}"
            data-end="${weekEnd.toDateString()}">
            Send WhatsApp
          </button>
        </td>
      </tr>
    `;

    tbody.append(row);
  }
}

// WhatsApp button
$(document).on("click", ".sendMessage", function () {
  const phone = $(this).data("phone");
  const name = $(this).data("name");
  const start = $(this).data("start");
  const end = $(this).data("end");

  const msg = `Auto notification: Hello ${name}, you are assigned for house cleaning this week (${start} – ${end}).`;
  const link = `https://api.whatsapp.com/send?phone=${phone}&text=${encodeURIComponent(msg)}`;
  window.open(link, "_blank");
});

// Screenshot
$("#captureBtn").click(() => {
  html2canvas(document.querySelector("#scheduleTable")).then(canvas => {
    const link = document.createElement("a");
    link.download = "schedule.png";
    link.href = canvas.toDataURL("image/png");
    link.click();
  });
});

// Manual refresh button (works 100%)
$(document).on("click", "#refreshNow", function () {
  loadPeople();
});

// Start
loadPeople();