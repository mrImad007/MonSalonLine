<script setup>
import TheAppointments from "../components/TheAppointments.vue";
import BaseHeader from "../components/BaseHeader.vue";
import BaseFooter from "../components/BaseFooter.vue";
import { onMounted, ref } from "vue";
import weekDayTiming from "../data/weekDayTiming.json";
import { formatDate } from "@vueuse/shared";
import { useClientStore } from "../stores/ClientStore";
import Swal from "sweetalert2";

const ClientStore = useClientStore();
var userRef = ClientStore.getuserRef;
const date = new window.Date();

const today = new Date();
const year = today.getFullYear();
const month = String(today.getMonth() + 1).padStart(2, "0");
const day = String(today.getDate()).padStart(2, "0");
const formattedDate = `${year}-${month}-${day}`;
console.log(formattedDate);

const TodayDate = ref(new window.Date());
const DayHoursAvailable = ref(null);
let timings = null;
const hoursOfWork = [];
const selectedDate = ref(null);
const aviablesHours = ref([]);
const isUpdate = ref(false);
let appointmentID = null;
let updateForm = null;
let SelectedTime = ref(null);

onMounted(async () => {
  ClientStore.fetchClientAppointments();
  timings = getTimingsForDay(today.getDay());
  mapDayHoursAvailable(timings);
  await fetchTodaysHoursReserved(formattedDate);
});

const addMonths = (date, months) => {
  date.setMonth(date.getMonth() + months);
  return date;
};

const mapDayHoursAvailable = (dayTiming) => {
  var AviablesHours = [];
  var monringHoursNumbers = dayTiming.morning_end - dayTiming.morning_start;
  var afternoonHoursNumbers =
    dayTiming.afternoon_end - dayTiming.afternoon_start;
  var temp = dayTiming.morning_start;
  for (let i = 0; i < monringHoursNumbers; i++) {
    AviablesHours.push({
      time: `${temp}:00:00`,
      disabled: false,
    });
    temp++;
  }
  var temp2 = dayTiming.afternoon_start;
  for (let i = 0; i < afternoonHoursNumbers; i++) {
    AviablesHours.push({
      time: `${temp2}:00:00`,
      disabled: false,
    });
    temp2++;
  }
  aviablesHours.value = AviablesHours;
};

function getTimingsForDay(day) {
  return weekDayTiming.find((timing) => timing.day === day);
}

const fetchTodaysHoursReserved = async (today) => {
  aviablesHours.value.forEach((element) => {
    element.disabled = false;
  });
  var response = await fetch(
    `http://localhost:8001/api/Appointment?date=${today}`
  );
  if ((await response).status == 400) {
    localStorage.setItem("CustomerID",[-1]);
    return console.log("no hours found in this date ");
  }
  const todaysHoursReserved = await (await response).json();
  let appointmentTimes = todaysHoursReserved.map(function (appointment) {
    return appointment.AppointmentTime;
  });

  var CustomerID = todaysHoursReserved.map(function (appointment) {
    return appointment.CustomerID;
  });

  aviablesHours.value.forEach((element) => {
    if (appointmentTimes.includes(element.time)) {
      element.disabled = true;
    }
  });
  console.log(aviablesHours.value);
  console.log(CustomerID);
   const CustomerIDString = JSON.stringify(CustomerID);
  localStorage.setItem("CustomerID",CustomerIDString);
};


const confirmAppoitement = async (time) => {
    const CustomerIDString = localStorage.getItem('CustomerID');
    const userID = localStorage.getItem('UserID');
    const CustomerID = JSON.parse(CustomerIDString);
    let existflag = 0;
    for (let i=0;i< CustomerID.length;i++){
      if(CustomerID[i]==userID){
        existflag++;
      }
    }
    if(existflag==1){
      Swal.fire({
        title: "Vous Avez deja un Rdv ce jour là !", 
        confirmButtonText: "Compris"
      });
      }else{
        const myFormData = new FormData();
    myFormData.append("AppointmentDate", selectedDate.value.id);
    myFormData.append("AppointmentTIme", time);
    myFormData.append("CustomerID", userRef);
    myFormData.append("AppointmentStatus", "Scheduled");
    myFormData.append("EmployeeID", 1);
    myFormData.append("AppointmentType", "haircut");

    Swal.fire({
      title: "Confirmer votre RDV",
      showDenyButton: true,
      // showCancelButton: true,
      confirmButtonText: "Confirmer",
      denyButtonText: `Annuler`,
    }).then(async (result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        const response = await fetch("http://localhost:8001/api/Appointment", {
          method: "POST",
          headers: {},
          body: myFormData,
        });
        const data = await response.json();
        console.log(data);
        ClientStore.fetchClientAppointments();
        Swal.fire("Merci !", "Votre RDV est bien noté", "success");
        location.reload();
      } else if (result.isDenied) {
        Swal.fire("Changement annulé", "", "info");
      }
    });
  }
};

const cancelAppointment = async (e) => {
  const myFormData = new FormData(e.target);
  const response = await fetch("http://localhost:8001/api/Appointment", {
    method: "POST",
    headers: {},
    body: myFormData,
  });
  const data = await response.json();
  console.log(data);
  ClientStore.fetchClientAppointments();
};

// const cancelAppointment = async (e) => {
  // Get current date
  // const currentDate = new Date();
// const options = { day: '2-digit' };
// const currentDay = currentDate.toLocaleString(undefined, options).slice(0, 2);
// console.log(currentDay);
//   // Get appointment date from form data
//   const myFormData = new FormData(e.target);
//   myFormData.append("AppointmentDate", selectedDate.value);
//   const appointmentDate = myFormData.get('appointmentDate');
//   const formattedAppointmentDate = new Date(appointmentDate).toISOString().split('T')[0];


//   console.log(appointmentDate);
//   console.log(day);
//   console.log(currentDate.toISOString().split('T')[0]);

//   // Check if appointment date is the same day as current date
//   if (currentDay !== day) {
//     // Append formatted appointment date back to form data
//     myFormData.set("appointmentDate", formattedAppointmentDate);

//     const response = await fetch("http://localhost:8001/api/Appointment", {
//       method: "POST",
//       headers: {},
//       body: myFormData,
//     });

//     const data = await response.json();
//     console.log(data);

//     // Refresh client appointments after successful cancellation
//     ClientStore.fetchClientAppointments();
//   } else {
//     console.log("Cannot cancel appointment on the same day.");
//     return;
//   }
// };


const updateAppointment = async (event, date, time, IdAppointment) => {
  isUpdate.value = true;
  TodayDate.value = date;
  appointmentID = IdAppointment;
};

const confirmUpdate = async (time) => {
  const myFormData = new FormData();
  myFormData.append("AppointmentDate", selectedDate.value.id);
  myFormData.append("AppointmentTIme", time);
  myFormData.append("_method", "UPDATE");
  myFormData.append("CustomerID", userRef);
  myFormData.append("AppointmentStatus", "Scheduled");
  myFormData.append("EmployeeID", 1);
  myFormData.append("AppointmentType", "haircut");
  myFormData.append("AppointmentID", appointmentID);

  Swal.fire({
    title: "Confirmer le RDV",
    showDenyButton: true,
    // showCancelButton: true,
    confirmButtonText: "Confirmer",
    denyButtonText: `Annuler`,
  }).then(async (result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      const response = await fetch("http://localhost:8001/api/Appointment", {
        method: "POST",
        headers: {},
        body: myFormData,
      });
      const data = await response.json();
      console.log(data);
      ClientStore.fetchClientAppointments();
      Swal.fire(
        "Thank You !",
        "Votre RDV est mis à jour ",
        "success"
      );
    } else if (result.isDenied) {
      Swal.fire("Changement annulé", "", "info");
    }
  });
  isUpdate.value = false;
};

const submitForm = (e) => {
  // console.log("submit form ");
  if (isUpdate.value === true) {
    console.log("update form date remove old one and add new one");
    confirmUpdate(e);
    return;
  }
  confirmAppoitement(e);
};

const onDayClick = async (day) => {
  console.log(day);
  console.log("day clicked");
  selectedDate.value = day;
  timings = getTimingsForDay(day.weekdayPosition);
  mapDayHoursAvailable(timings);
  //filter aviablesHours based on if someSelse is reseved this hour
  // condition is the todays date
  var today = day.id;
  console.log(today);
  fetchTodaysHoursReserved(today);
};

const dateAfterMonth = addMonths(date, 1);
</script>

<template>
  <div>
    <BaseHeader />
    <div class="rendez-vous">
      <div class="rendez-card py-6 shadow-lg" id="card">
        <h1 class="text-center text-4xl font-semibold">Bienvenue dans votre Salon</h1>
        <div class="flex flex-col gap-6 justify-center items-center">
          <h3 class="text-center text-xl font-semibold">Choisissez le jour qui convient</h3>
          <v-date-picker
            v-model="TodayDate"
            :max-date="dateAfterMonth"
            :min-date="new Date()"
            @dayclick="onDayClick"
          />
          <h3 class="text-center text-xl font-semibold">Choisissez le RDV qui convient </h3>
          <div class="time-grid border rounded text-white">
            <div
              :class="!date.disabled ? 'bg-black' : 'bg-red-500'"
              @click="!date.disabled ? submitForm(date.time) : null"
              class="time"
              v-for="date in aviablesHours"
              :key="date"
            >
              <div class="time-hour">{{ date.time }}</div>
              <input type="hidden" :value="date.time" />
              <div class="time-available">
                <div class="time-available-circle"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      v-if="ClientStore.userAppointments"
      class="resevertion bg-white m-auto w-full"
    >
      <!-- get length of userAppointments -->
<div class="update-rendez-vous">
      <h1 class="text-center text-4xl font-semibold">Update mon Rdv</h1><br><br>

      <table class="m-auto">
        <thead>
          <tr>
            <th class="text-center">Date</th>
            <th class="text-center">Time</th>
            <th class="text-center">Status</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="appointment in ClientStore.userAppointments"
            :key="appointment"
          >
            <td class="px-2 py-4">{{ appointment.AppointmentDate }}</td>
            <td class="px-2 py-4">{{ appointment.AppointmentTime }}</td>
            <td class="px-2 py-4">{{ appointment.AppointmentStatus }}</td>
            <!-- <td class="px-2 py-4">
              <form @submit.prevent="cancelAppointment($event,appointment.AppointmentDate)">
                <input
                  type="hidden"
                  name="AppointmentID"
                  :value="appointment.AppointmentID"
                />
                <input
                  type="hidden"
                  name="AppointmentDate"
                  :value="appointment.AppointmentDate"
                />
                <input type="hidden" name="_method" value="DELETE" />
                <button
                  class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                >
                  Annuler
                </button>
              </form>
            </td> -->
            <!-- update appointment status -->
            <td class="px-2 py-4">
              <form
                @submit.prevent="
                  updateAppointment(
                    $event,
                    appointment.AppointmentDate,
                    appointment.AppointmentTime,
                    appointment.AppointmentID
                  )
                "
              >
                <input
                  type="hidden"
                  name="AppointmentID"
                  :value="appointment.AppointmentID"
                />
                <input type="hidden" name="_method" value="UPDATE" />
                <button
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                >
                  changer
                </button>
              </form>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
   
  </div>
</template>

<style scoped>
.rendez-vous {
  width: 100%;
  height: 100vh;
  background-size: cover;
  display: grid;
  justify-content: center;
  align-content: center;
}

.update-rendez-vous {
  width: 100%;
  height: 50vh;
  background-size: cover;
  display: grid;
  justify-content: center;
  align-content: center;
}

#card {
  width: 80vw;
  min-height: 60vh;
  background-color: whitesmoke;
  border-radius: 5px;
  padding: 0 0.5rem;
  display: grid;
  gap: 1rem;
  justify-content: center;
  align-content: center;
}

.time-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: repeat(3, 1fr);
  gap: 2rem;
  padding: 1rem;
  justify-items: center;
  align-items: center;
}


.time {
  width: 100%;
  height: 100%;
  display: grid;
  justify-content: center;
  align-content: center;
  border-radius: 5px;
  border: 1px solid #ccc;
  padding: 0.5rem;
  cursor: pointer;
}
.time-hour {
  font-size: 1rem;
  font-weight: 600;
}
.bg-black:hover {
  /* Background color on hover */
  background-color: rgb(13, 190, 13) !important;
}
@media (max-width: 850px) {
  #card {
    width: 90vw;
  }
}
</style>
