

// On page load or when changing themes, best to add inline in `head` to avoid FOUC
if (localStorage.theme === 'dark'|| (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) ) {
  document.documentElement.classList.add('dark');
} else {
  document.documentElement.classList.remove('dark');
};

function setDarkTheme() {
  document.documentElement.classList.add("dark");
  createTransition();
  localStorage.theme = "dark";
};

function setLightTheme() {
  createTransition();
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
function createTransition()
{
  const ruleList = document.styleSheets[0].cssRules;
  const style = document.createElement('style')
  style.textContent = '* {transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);transition-duration: 500ms;}';
  const newStyle = document.head.appendChild(style)
  setTimeout(() => {
    document.head.removeChild(newStyle);
  }, 500);


}

const themeSwitcherItems = document.querySelectorAll("#theme-switcher");
themeSwitcherItems.forEach((item) => {
  item.addEventListener("click", onThemeSwitcherItemClick);
});
