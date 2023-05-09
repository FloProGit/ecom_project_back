/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';



import Alpine from 'alpinejs'
window.Alpine = Alpine

Alpine.start()

var toastLiveExample = document.getElementById('liveToast')

if (toastLiveExample) {
    toastLiveExample.classList.add('show');
}


// On page load or when changing themes, best to add inline in `head` to avoid FOUC
if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark');
};

function setDarkTheme() {
    document.documentElement.classList.add("dark");
    localStorage.theme = "dark";
};

function setLightTheme() {
    document.documentElement.classList.remove("dark");
    localStorage.theme = "light";
};

function onThemeSwitcherItemClick(event) {
    const theme = event.target.dataset.theme;

    if (theme === "system") {
        localStorage.removeItem("theme");
        setSystemTheme();
    } else if (theme === "dark") {
        setDarkTheme();
    } else {
        setLightTheme();
    }
};

const themeSwitcherItems = document.querySelectorAll("#theme-switcher");
themeSwitcherItems.forEach((item) => {
    item.addEventListener("click", onThemeSwitcherItemClick);
});

