<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>My Live Session Timetable</title>

  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background:#f7f7f7; }
    #calendar { max-width: 95%; margin: 0 auto; background:#fff; padding:15px; border-radius:8px; box-shadow:0 0 8px rgba(0,0,0,0.1); }
    .fc-event { cursor:pointer; }
  </style>
</head>
<body>

<h2>📅 My Live Class Timetable</h2>
<p>Click any session to join the Google Meet (opens in a new tab)</p>

<div id="calendar"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },
    navLinks: true,
    nowIndicator: true,
    selectable: false,
    editable: false,
    eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },

    // feed
    events: "<?php echo site_url('student/calendar/events'); ?>",

    // use the colors sent from server (backgroundColor, borderColor, textColor)
    eventDidMount: function(info) {
      // tooltip
      if (info.event.extendedProps.subject_name) {
        info.el.title = info.event.extendedProps.subject_name;
      }
    },

    eventClick: function(info) {
      info.jsEvent.preventDefault();
      var meet = info.event.extendedProps.meet_link || info.event.url;
      if (meet) {
        window.open(meet, '_blank');
      } else {
        alert('No meeting link available for this session.');
      }
    }
  });

  calendar.render();
});
</script>

</body>
</html>
