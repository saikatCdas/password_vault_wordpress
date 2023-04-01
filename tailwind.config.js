/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.html",
    "./resources/admin/**/*.{vue,js,ts,jsx,tsx}",
    ".app/Modules/Builder/**/*.php"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
  important: true,
}
