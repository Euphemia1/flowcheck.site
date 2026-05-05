import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;

Alpine.start();

// Global axios setup
document.addEventListener('alpine:init', () => {
    // Add global Alpine components
});
