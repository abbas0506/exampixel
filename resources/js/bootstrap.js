import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import AOS from "aos";
import "aos/dist/aos.css";

// AOS.init();
AOS.init({
    duration: 500,
    easing: "ease-in-out",
    once: true,
    mirror: false,
});