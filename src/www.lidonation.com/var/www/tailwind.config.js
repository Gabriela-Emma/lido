const defaultTheme = require('tailwindcss/defaultTheme');
const bodyFont = [
    'Roboto',
    'sans-serif',
    'ui-sans-serif',
    'system-ui',
    '-apple-system',
    'BlinkMacSystemFont',
    '"Segoe UI"',
    '"Helvetica Neue"',
    'Arial',
    '"Noto Sans"',
    'sans-serif',
    '"Apple Color Emoji"',
    '"Segoe UI Emoji"',
    '"Segoe UI Symbol"',
    // ...defaultTheme.fontFamily.sans
];

// original red
// const themeColors = {
//     50: '#fb99ae',
//     100: '#fa849d',
//     200: '#f9708d',
//     300: '#f85b7d',
//     400: '#f7476d',
//     500: '#f7335d',
//     600: '#de2d53',
//     700: '#c5284a',
//     800: '#ac2341',
//     900: '#941e37'
// };

const gridColumn = {};
// for (let count = 1; count < 101; count++) {
//     gridColumn[`span-${count}`] = `span ${count} / span ${count}`
// }
const themeColors = {
    'eggplant': {
        10: '#ece7eb',
        20: '#dad0d7',
        30: '#c8b8c4',
        40: '#b5a1b0',
        50: '#a3899d',
        100: '#917289',
        200: '#7e5a75',
        300: '#6c4262',
        400: '#5a2b4e',
        500: '#48143b', // base
        600: '#401235',
        700: '#39102f',
        800: '#320e29',
        900: '#2b0c23',
    },
    'brown': {
        500: '#400101' // base
    },
    'teal-light': {
        10: '#edf8fd',
        20: '#dcf1fb',
        30: '#cbeaf9',
        40: '#bae3f7',
        50: '#a9ddf5',
        100: '#98d6f3',
        200: '#87cff1',
        300: '#76c8ef',
        400: '#65c1ed',
        500: '#54bbeb', // base
        600: '#4ba8d3',
        700: '#4395bc',
        800: '#32708d',
        900: '#2a5d75'
    },
    'teal': {
        10: '#e9f4f8',
        20: '#d3eaf2',
        30: '#bddfeb',
        40: '#a7d5e5',
        50: '#92cade',
        100: '#7cc0d8',
        200: '#66b5d1',
        300: '#50abcb',
        400: '#3aa0c4',
        500: '#2596be', // base
        600: '#2187ab',
        700: '#1d7898',
        800: '#196985',
        900: '#165a72'
    },
    'green': {
        500: '#62BF04', // base
        600: '#58ab03',
        700: '#4e9803',
        800: '#448502',
        900: '#3a7202',
    },
    'yellow': {
        10: '#fefbe6',
        20: '#fef8ce',
        30: '#fef4b5',
        40: '#fdf19d',
        50: '#fded85',
        100: '#fdea6c',
        200: '#fce654',
        300: '#fce33b',
        400: '#fcdf23',
        500: '#fcdc0b', // base
        600: '#e2c609',
        700: '#c9b008',
        800: '#b09a07',
        900: '#7e6e05',
    },
    'blue-light': {
        10: '#f7fafd',
        20: '#f0f5fc',
        30: '#e9f0fb',
        40: '#e1ecf9',
        50: '#dae7f8',
        100: '#d3e2f7',
        200: '#cbdef5',
        300: '#c4d9f4',
        400: '#bdd4f3',
        500: '#B6D0F2', // base
        600: '#a3bbd9',
        700: '#91a6c1',
        800: '#7f91a9',
        900: '#6d7c91'
    },
    'blue-dark': {
        500: '#181240', // base
    },
    'dark': {
        10: '#eefafd',
        20: '#ddf6fc',
        30: '#ccf2fb',
        40: '#bbeef9',
        50: '#abeaf8',
        100: '#9ae6f7',
        200: '#89e2f5',
        300: '#78def4',
        400: '#67daf3',
        500: '#0D0000', // base
        600: '#4ec0d9',
        700: '#45abc1',
        800: '#3c95a9',
        900: '#348091'
    },



    'labs': {
        'black': '#0D0000',
        'red': '#C02025',
        'red-light': '#CE2026',
        'green': '#509743',
        'green-light': '#52A546',
        'yellow': '#D0A52B',
        'yellow-light': '#FBDC08',
        'orange': '#ff7400',
    },

    'post-type': {
        'insights': '#ff8700',
        'news': '#4bb92f',
        'reviews': '#8d00ff'
    },

    phuffy: {
        100: '#9dedf0',
        200: '#8ceaed',
        300: '#7ce7eb',
        400: '#6ce4e8',
        500: '#5CE1E6',
        600: '#52cacf',
        700: '#49b4b8',
        800: '#409da1',
        900: '#37878a',
    },
    phuffy2: {
        100: '#d4d1eb',
        200: '#cdc9e8',
        300: '#c6c2e5',
        400: '#bfbae2',
        500: '#b8b3df',
        600: '#a5a1c8',
        700: '#938fb2',
        800: '#807d9c',
        900: '#6e6b85',
    },
    primary: {
        10: '#f6f9fd',
        20: '#eef3fc',
        30: '#e5edfa',
        40: '#dde7f9',
        50: '#abc4f1',
        100: '#9ab8ee',
        200: '#89adec',
        300: '#78a1e9',
        400: '#6795e6',
        500: '#578AE4',
        600: '#4e7ccd',
        700: '#456eb6',
        800: '#3c609f',
        800: '#3c609f',
        900: '#345288',
        1000: '#002557',
    },
    secondary: {
        50: '#c3bbf4',
        100: '#b5abf1',
        200: '#a69aee',
        300: '#8878e9',
        400: '#7967e6',
        500: '#6B57E4',
        600: '#604ecd',
        700: '#5545b6',
        800: '#4a3c9f',
        900: '#403488',
    },
    accent: {
        50: '#ccffff',
        100: '#b2ffff',
        200: '#99ffff',
        300: '#32ffff',
        400: '#19ffff',
        500: '#00FFFF',
        600: '#00e5e5',
        700: '#00cccc',
        800: '#00b2b2',
        900: '#009999',
    },
    pink: {
        50: '#f1abc4',
        100: '#ee9ab8',
        200: '#ec89ad',
        300: '#e978a1',
        400: '#e66795',
        500: '#E4578A',
        600: '#cd4e7c',
        700: '#b6456e',
        800: '#9f3c60',
        900: '#883452',
    },
    // yellow: {
    //     50: '#fee87f',
    //     100: '#fde366',
    //     200: '#fdde4c',
    //     300: '#fdda32',
    //     400: '#fdd519',
    //     500: '#FDD100',
    //     600: '#e3bc00',
    //     700: '#caa700',
    //     800: '#b19200',
    //     900: '#977d00',
    // }
};

module.exports = {
    mode: "jit",

    content: {
        files: [
            "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
            "./vendor/laravel/jetstream/**/*.blade.php",
            "./storage/framework/views/*.php",
            "./resources/views/**/*.blade.php",
            "./resources/js/**/*.vue",
        ],
    },
    safelist: [
        "sm:max-w-2xl",
        "sm:max-w-3xl",
        "sm:max-w-5xl",
        "max-w-5xl",
        "max-w-3xl",
        "bg-green-600",
        "hover:bg-green-800",
        "bg-post-type-news",
        "border-post-type-news",
        "bg-post-type-reviews",
        "border-post-type-reviews",
        "bg-post-type-insights",
        "border-post-type-insights",
        "from-green-700",
        "via-green-600",
        "to-green-500",
        "from-teal-700",
        "via-teal-600",
        "to-teal-500",
        {
            pattern: /order-(1|2|3|4||5|6|12)/,
        },
    ],
    darkMode: "media", // or 'media' or 'class'
    theme: {
        extend: {
            animation: {
                marquee: "marquee 18s linear infinite",
            },
            keyframes: {
                marquee: {
                    "0%": { transform: "translateX(0%)" },
                    "100%": { transform: "translateX(-100%)" },
                },
            },
            spacing: {
                128: "32rem",
            },
            gridTemplateColumns: {
                100: "repeat(100, minmax(0, 1fr))",
            },
            gridTemplateRows: {
                9: "repeat(9, minmax(0, 1fr))",
                12: "repeat(12, minmax(0, 1fr))",
                18: "repeat(18, minmax(0, 1fr))",
            },
            gridRow: {
                "span-9": "span 9 / span 9",
                "span-10": "span 10 / span 10",
                "span-12": "span 12 / span 12",
                "span-14": "span 14 / span 14",
            },
            gridAutoRows: {
                "2fr": "minmax(0, 2fr)",
            },
            backgroundImage: (theme) => ({
                "pool-bw-light": "url('/img/pool-black-and-white.jpg')",
                "pool-bw-dark": "url('/img/pool-black-and-black.jpg')",
                "lido-nature": "url('/img/lido-nature.jpg')",
                "lido-accent-liquid-border": "url('/img/liquid-border.png')",
                "lido-boy": "url('/img/what-is-cardano-full.jpg')",
            }),
            fontFamily: {
                sans: bodyFont,
                display: ["Balmy"],
                title: ["Balmy"],
                body: bodyFont,
            },
            fontSize: {
                "8xl": "7rem",
                "9xl": "9.375rem",
                "10xl": "10.75rem",
            },
            height: {
                100: "25rem",
                110: "30rem",
                115: "35rem",
                120: "40rem",
                125: "45rem",
                130: "50rem",
                inherit: "inherit",
            },
            width: {
                100: "25rem",
                110: "30rem",
                115: "35rem",
                120: "40rem",
                125: "45rem",
                130: "50rem",
            },
            minWidth: {
                0: "0",
                1: "1rem",
                5: "5rem",
                15: "15rem",
                20: "20rem",
                25: "25rem",
                35: "35rem",
                "1/4": "25%",
                "2/6": "33%",
                "2/5": "40%",
                "1/2": "50%",
                "3/5": "60%",
                "3/4": "75%",
                full: "100%",
            },
            opacity: {
                1: ".01",
                2: ".02",
                3: ".03",
                4: ".04",
            },
            screens: {
                "3xl": "1840px",
                "4xl": "2160px",
            },
            lineHeight: {
                "extra-loose": "2.5",
                11: "3rem",
                12: "3.45rem",
                13: "4rem",
                14: "4.45rem",
                15: "5rem",
                16: "6rem",
                17: "7rem",
            },
            rotate: {
                110: "110deg",
                115: "115deg",
                125: "125deg",
                135: "135deg",
                270: "270deg",
            },
            inset: {
                "-40": "-14rem",
                "-50": "-22rem",
                "-60": "-35rem",
                "-70": "-50rem",
                "-80": "-65rem",
            },
            colors: {
                ...themeColors,
            },
            zIndex: {
                5: "5",
                6: "6",
                75: "75",
                100: "100",
                999: "999",
            },
        },
    },
    variants: {
        extend: {
            backgroundColor: ["disabled"],
            cursor: ["disabled"],
            opacity: ["disabled"],
            borderWidth: ["odd", "even"],
        },
    },

    // variants: {
    //     extend: {
    //         opacity: ['responsive', 'hover', 'focus', 'disabled'],
    //         ringColor: ['hover'],
    //         ringOffsetColor: ['hover'],
    //         ringOffsetWidth: ['hover'],
    //         ringOpacity: ['hover'],
    //         ringWidth: ['hover'],
    //     }
    // },

    plugins: [
        require("@tailwindcss/aspect-ratio"),
        require("@tailwindcss/forms"),
        // require('@tailwindcss/line-clamp'),
        require("@tailwindcss/typography"),
    ],
};
