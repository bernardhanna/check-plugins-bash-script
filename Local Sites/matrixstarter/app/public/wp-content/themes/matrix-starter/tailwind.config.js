module.exports = {
  mode: 'jit',
  content: [
    './**/*.php',
    './assets/js/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        primary: ['Poppins', 'sans-serif'],
        secondary: ['Poppins', 'sans-serif'],
        tertiary: ['Poppins', 'sans-serif'],
      },
      colors: {
        primary: {
          DEFAULT: '#FFFFFF',
          light: '#50B847',
          dark: '#00672F',
        },
        secondary: {
          DEFAULT: '#F16623',
          light: '#ECCEBF',
          dark: '#C4D831',
        },
        background: {
          DEFAULT: '#F2F7F0',
          light: '#EFF5EC',
          dark: '#D0E2C8',
        },
        accent: {
          greenLight: '#50B847',
          greenDark: '#00672F',
          orange: '#F16623',
          yellowLight: '#FFF100',
          yellowDark: '#FDCC05',
        },
        neutral: {
          light: '#F5F5F5',
          DEFAULT: '#E7E7E7',
          dark: '#FFF6F1',
        },
        highlight: {
          light: '#FFF9E2',
          yellow: '#FFFAE8',
          orange: '#FDCC05',
        },
      },
      fontSize: {
        sm: '',
        base: '16px',
        lg: '',
        xl: '',
      },
      maxWidth: {
        'xxs': '320px',
        'xs': '480px',
        'mob': '575px',
        'sm': '640px',
        'md': '768px',
        'lg': '1024px',
        'xl': '1280px',
        'xxl': '1440px',
        'ultrawide': '1920px',
      }
    },
    pseudo: {
      'before': 'before',
      'after': 'after',
      'not-first': 'not(:first-child)',
    },
    screens: {
      xxs: '320px',
      xs: '480px',
      mob: '575px',
      sm: '640px',
      md: '768px',
      lg: '1024px',
      xl: '1280px',
      xxl: '1440px',
      ultrawide: '1920px',
    },
    container: {
      center: true,
      padding: '1.5rem',
      screens: {
        xxs: '320px',
        xs: '480px',
        mob: '575px',
        sm: '640px',
        md: '768px',
        lg: '1024px',
        xl: '1280px',
        xxl: '1440px',
        ultrawide: '1920px',
      }
    },
  },
  variants: {
    extend: {
      backgroundColor: ['not-first'],
      display: ['before', 'after'],
    },
  },
  plugins: [
    require('tailwindcss-pseudo')({
      empty: true,
      before: true,
      after: true,
    }),
  ],
  safelist: [
    // Layout utilities
    'absolute',
    'relative',
    'top-0',
    'left-0',
    'right-0',
    'bottom-0',
    'inset-0',
    'max-w-[745px]',
    'fit-content',

    // Container classes
    'container',
    'max-w-xxs',
    'max-w-xs',
    'max-w-mob',
    'max-w-sm',
    'max-w-md',
    'max-w-lg',
    'max-w-xl',
    'max-w-xxl',
    'max-w-ultrawide',
  ],
}