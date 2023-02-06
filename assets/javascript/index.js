

/* ------------------ POPUP ------------------ */
const welcome_pop = document.getElementById("welcome-popup");
// document.getElementById('welcome-popup-test').innerHTML = new Date().getHours() >= 12 ? 'Good Afternoon' : 'Good Morning';
// welcome_pop.innerHTML = new Date().getHours() >= 12 ? 'Good Afternoon' : 'Good Morning';
function counterFunction() {
  welcome_pop.classList.add("showpop");
}
setTimeout(counterFunction, 3000);

/* ------------------ MENU BURGER ------------------ */

const menuBtn = document.querySelector(".menu-btn");
let menuOpen = false;

menuBtn.addEventListener("click", () => {
  if (!menuOpen) {
    menuBtn.classList.add("open");
    menuOpen = true;
  } else {
    menuBtn.classList.remove("open");
    menuOpen = false;
  }
});

/* ------------------ SIDE BARE ------------------ */

const body = document.querySelector("body");
const sidebar = body.querySelector(".sidebar");
const toggle = body.querySelector(".toggle");
const toggleSwitch = document.querySelector(".toggle-switch");
const modeText = body.querySelector(".mode-text");

toggle.addEventListener("click", function () {
  sidebar.classList.toggle("close");
});

/* ------------------ BTN BACK TO TOP ------------------ */

const btn_top = document.getElementById("btn-back-to-top");

window.addEventListener("scroll", function () {
  if (window.scrollY > 300) {
    btn_top.style.display = "block";
  } else {
    btn_top.style.display = "none";
  }
});

btn_top.addEventListener("click", function () {
  window.scrollTo({ top: 0, behavior: "smooth" });
});

/* ------------------ DARK LIGHT MODE ------------------ */

const sunBtnToggle = document.getElementById("sun-btn");
const moonBtnToggle = document.getElementById("moon-btn");
let darkMode = localStorage.getItem("darkMode");

const enableDarkMode = () => {
  // 1. add the class darkmode to the body
  document.body.classList.add("darkmode");
  sunBtnToggle.style.display = "none";
  moonBtnToggle.style.display = "block";
  // 2.update darkmode in the localstorage
  localStorage.setItem("darkMode", "enabled");
};
const disableDarkMode = () => {
  // 1. add the class darkmode to the body
  document.body.classList.remove("darkmode");
  sunBtnToggle.style.display = "block";
  moonBtnToggle.style.display = "none";
  // 2.update darkmode in the localstorage
  localStorage.setItem("darkMode", "disable");
};

if (darkMode == "enabled") {
  enableDarkMode();
}

sunBtnToggle.addEventListener("click", function () {
  //update the darkMode every click
  darkMode = localStorage.getItem("darkMode");
  if (darkMode !== "enabled") {
    enableDarkMode();
    document.getElementById("mode-text").innerHTML = "Dark Mode";
  } else {
    disableDarkMode();
    document.getElementById("mode-text").innerHTML = "Light Mode";
  }
});

moonBtnToggle.addEventListener("click", function () {
  //update the darkMode every click
  darkMode = localStorage.getItem("darkMode");
  if (darkMode !== "enabled") {
    enableDarkMode();
    document.getElementById("mode-text").innerHTML = "Dark Mode";
  } else {
    disableDarkMode();
    document.getElementById("mode-text").innerHTML = "Light Mode";
  }
});

