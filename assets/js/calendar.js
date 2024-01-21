import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import { Modal } from "bootstrap";

document.addEventListener("DOMContentLoaded", function () {
  let calendarEl = document.getElementById("calendar");

  let calendar = new Calendar(calendarEl, {
    plugins: [dayGridPlugin, timeGridPlugin, listPlugin],

    initialView: "dayGridMonth",
    locale: "fr",
    timeZone: "Europe/Paris",
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
    },
    // events: function (successCallback, failureCallback) {
    //   successCallback([{ title: "Test Event", start: new Date() }]);
    // },
    events: function (fetchInfo, successCallback, failureCallback) {
      fetchTasks(successCallback, failureCallback);
    },
    eventClick: function (info) {
      let id = info.event.id;
      let title = info.event.title;
      let user = info.event.user;
      let start = info.event.start;
      let end = info.event.end;
      let url = "/task/" + id + "/show";

      let modal = document.getElementById("modal");
      let modalTitle = modal.querySelector("#modalTitle");
      let modalBody = modal.querySelector("#modalBody");
      let modalFooter = modal.querySelector("#modalFooter");

      modalTitle.textContent = title;
      modalBody.textContent =
        `Du ${start} au ${end}` + (user ? ` (utilisateur ${user})` : "");
      modalFooter.innerHTML = `<a href="${url}" class="btn btn-primary">Voir la tâche</a>
                               <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>`;

      let bootstrapModal = new Modal(document.getElementById("modal"));
      bootstrapModal.show();
    },
  });

  calendar.render();
});

async function fetchTasks(successCallback, failureCallback) {
  try {
    // Effectuez la requête fetch
    const response = await fetch("/task/new/json");

    // Gérez une réponse non réussie
    if (!response.ok) {
      throw new Error(`Erreur HTTP: ${response.status}`);
    }

    // Parsez la réponse en JSON
    const tasks = await response.json();
    console.log("Raw tasks:", tasks);

    // Formatez les événements pour FullCalendar
    const events = tasks.map((task) => ({
      id: task.id.toString(),
      user: task.user,
      title: task.title,
      start: task.start,
      end: task.end,
    }));
    console.log("Formatted events:", events);

    // Utilisez le callback de succès pour envoyer les événements à FullCalendar
    successCallback(events);
  } catch (error) {
    // Gérez les erreurs ici
    console.error("Erreur lors de la récupération des tâches:", error);
    failureCallback(error);
  }

  // function fetchTasks(successCallback, failureCallback) {
  //   try {
  //     const staticTasks = [
  //       {
  //         id: 1,
  //         user: "test@test.fr",
  //         title: "faire dodo",
  //         start: "2024-01-20T23:46:52+01:00",
  //         end: "2024-01-20T23:48:00+01:00",
  //       },
  //       {
  //         id: 2,
  //         user: "test3@test.fr",
  //         title: "test",
  //         start: "2019-01-01T01:00:00+01:00",
  //         end: "2019-01-01T02:00:00+01:00",
  //       },
  //     ];

  //     const events = staticTasks.map((task) => ({
  //       id: task.id.toString(),
  //       user: task.user,
  //       title: task.title,
  //       start: task.start,
  //       end: task.end,
  //     }));
  //     console.log("successCallback type:", typeof successCallback);
  //     successCallback(events);
  //   } catch (error) {
  //     console.log("failureCallback type:", typeof failureCallback);
  //     failureCallback(error);
  //     console.error("Erreur lors du traitement des tâches statiques:", error);
  //   }
}
