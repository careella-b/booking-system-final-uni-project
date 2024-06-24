document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");
  fetch("./bookingHandler.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ fetch_projects:'fetch_projects'}),
        })
  .then(response => response.json())
          .then(data => {
          var projects = data;
          var projectsHtml = '<select id="projectId" class="swal2-input"> <option disabled selected>Select Project</option>';
          for(let k=0; k<projects.length; k++){
            projectsHtml+= '<option value="'+projects[k].projectID+'">'+projects[k].projectName+'</option>';
          }
          projectsHtml += "</select>";
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    height: 850,
    events: "./fetchBookings.php",
    headerToolbar: {
      start: "dayGridMonth,timeGridWeek,timeGridDay", //button that will switch the calendar to any of the available views
      center: "title", //month title w/ year -> June 2023
      end: "today prev,next",
    }, // button for moving foward or back one month/week/day,
    selectable: true,
    select: async function (start, end, allDay) {
      const { value: formValues } = await Swal.fire({
        title: 'Add Booking',
        confirmButtonText: 'Submit',
        confirmButtonColor: '#F05349',
        showCloseButton: true,
		    showCancelButton: true,
        html:
          '<div style="font-size:16px;"><input id="swalEvtTitle" class="swal2-input" placeholder= "Enter title"></div>' +
          '<div style="font-size:16px;"><textarea id="swalEvtDesc" class="swal2-input" placeholder="Type your message..."></textarea></div>' +
          projectsHtml,
        focusConfirm: false,
        preConfirm: () => {
          return [
            document.getElementById('swalEvtTitle').value,
            document.getElementById('swalEvtDesc').value,
            document.getElementById('projectId').value,
          ]
        }
      });

      if (formValues) {
        // Add event
        fetch("./bookingHandler.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ request_type:'addEvent', start:start.startStr, end:start.endStr, event_data: formValues}),
        })
        .then(data => {

          if (data.status == 1 || data.status == 200) {
            Swal.fire('Booking added successfully!', '', 'success');
          } else {
            Swal.fire(data.error, '', 'error');
          }

          // Refetch events from all sources and rerender
          calendar.refetchEvents();
        })
      
      }
    },

    eventClick: function(info) {
      info.jsEvent.preventDefault();
      
      // change the border color
      info.el.style.borderColor = 'red';
      
      Swal.fire({
        title: info.event.title,
        icon: 'info',
        html:'<p>'+info.event.extendedProps.description+'</p>',
        showCloseButton: true,
        showCancelButton: true,
        showDenyButton: true,
        cancelButtonText: 'Close',
        confirmButtonText: 'Delete',
        confirmButtonColor: '#F05349',
        cancelButtonColor: '##838383',
        denyButtonColor: '#2d2d2d',
        denyButtonText: 'Edit',
      }).then((result) => {
        if (result.isConfirmed) {
          // Delete event
          fetch("./bookingHandler.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ request_type:'deleteEvent', event_id: info.event.id}),
          })
          .then(response => response.json())
          .then(data => {
            if (data.status == 1) {
              Swal.fire('Booking deleted successfully!', '', 'success');
            } else {
              Swal.fire(data.error, '', 'error');
            }

            // Refetch events from all sources and rerender
            calendar.refetchEvents();
          })
          .catch(console.error);
        } else if (result.isDenied) {
          // Edit and update event
          Swal.fire({
            title: 'Edit Booking',
            html:
              '<input id="swalEvtTitle_edit" class="swal2-input" placeholder="Enter title" value="'+info.event.title+'">' +
              '<textarea id="swalEvtDesc_edit" class="swal2-input" placeholder="Enter description">'+info.event.extendedProps.description+'</textarea>',
            focusConfirm: false,
            confirmButtonText: 'Submit',
            confirmButtonColor: '#2d2d2d',
            preConfirm: () => {
            return [
              document.getElementById('swalEvtTitle_edit').value,
              document.getElementById('swalEvtDesc_edit').value,
            ]
            }
          }).then((result) => {
            if (result.value) {
              // Edit event
              fetch("./bookingHandler.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ request_type:'editEvent', start:info.event.startStr, end:info.event.endStr, event_id: info.event.id, event_data: result.value})
              })
              .then(response => response.json())
              .then(data => {
                if (data.status == 1) {
                  Swal.fire('Booking updated successfully!', '', 'success');
                } else {
                  Swal.fire(data.error, '', 'error');
                }

                // Refetch events from all sources and rerender
                calendar.refetchEvents();
              })
              .catch(console.error);
            }
          });
        } else {
          Swal.close();
        }
      });
    }
  });

  calendar.render();
})
});