import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import daisyui from 'daisyui'

export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [forms, daisyui],
  daisyui: {
    themes: [
      {
        kids: {
          primary: "#f06292",
          secondary: "#ffcc80",
          accent: "#ba68c8",
          neutral: "#f5f5f5",
          "base-100": "#ffffff",
          "base-content": "#212121",
          info: "#81d4fa",
          success: "#aed581",
          warning: "#fff176",
          error: "#e57373",
        },
      },
      {
        teens: {
          primary: "#64b5f6",
          secondary: "#9575cd",
          accent: "#4db6ac",
          neutral: "#e0f7fa",
          "base-100": "#ffffff",
          "base-content": "#212121",
          info: "#4fc3f7",
          success: "#81c784",
          warning: "#ffd54f",
          error: "#e53935",
        },
      },
      {
        adults: {
          primary: "#455a64",
          secondary: "#8d6e63",
          accent: "#607d8b",
          neutral: "#eceff1",
          "base-100": "#ffffff",
          "base-content": "#212121",
          info: "#29b6f6",
          success: "#66bb6a",
          warning: "#ffa726",
          error: "#ef5350",
        },
      },
      "light",
      "dark",
      "cyberpunk",
    ],
  },
}
