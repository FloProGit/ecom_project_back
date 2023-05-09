/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    colors: {
      primary: "rgb(var(--color-primary) / <alpha-value>)",
      white: "rgb(var(--color-white) / <alpha-value>)",
      titletext: "rgb(var(--color-titletext) / <alpha-value>)",
      symplytext: "rgb(var(--color-symplytext) / <alpha-value>)",
      linktext: "rgb(var(--color-linktext) / <alpha-value>)",
      hoveredtext: "rgb(var(--color-hoveredtext) / <alpha-value>)",
      hovertext: "rgb(var(--color-hovertext) / <alpha-value>)",
      text: "rgb(var(--color-text) / <alpha-value>)",
      light: "rgb(var(--color-light) / <alpha-value>)",
      success: "rgb(var(--color-success) / <alpha-value>)",
      info: "rgb(var(--color-info) / <alpha-value>)",
      warn: "rgb(var(--color-warn) / <alpha-value>)",
      error: "rgb(var(--color-error) / <alpha-value>)",
      ring: "rgb(var(--color-ring) / <alpha-value>)",
      inputborder: "rgb(var(--color-inputborder) / <alpha-value>)",
      transparent: "transparent",
      current: "currentColor",
    },
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),

  ],
}
