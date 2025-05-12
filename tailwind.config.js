/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      // "./resources/**/*.vue", 
      // "./app/Http/Livewire/**/*.php", // Jika pakai Livewire
      // "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    ],
    theme: {
      extend: {},
    },
    plugins: [],
  }