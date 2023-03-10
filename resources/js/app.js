import './bootstrap';
import '../css/app.css';

import { createApp, h, defineAsyncComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import StarRating from "vue-star-rating";

import VueVideoPlayer from '@videojs-player/vue'
import 'video.js/dist/video-js.css'


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(VueVideoPlayer)
            .component("star-rating", StarRating)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
