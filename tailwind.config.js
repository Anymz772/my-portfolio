/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.jsx",
        "./resources/**/*.vue",
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                paper: '#F3F0E8',
                ink: '#1A1A18',
                slate: '#6B6A62',
                line: '#DEDACD',
                signal: '#E8542A',
                night: '#15140F',
                'paper-dark': '#EDE9DD',
                'slate-dark': '#9A988C',
                'line-dark': '#2D2B22',
                'signal-dark': '#FF6B3D',
            },
            fontFamily: {
                mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
                sans: ['Inter', 'ui-sans-serif', 'sans-serif'],
            },  
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}