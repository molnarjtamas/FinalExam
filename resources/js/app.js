require('./bootstrap');

// Import modules...
import Vue from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';
import 'vue-event-calendar/dist/style.css'
import vueEventCalendar from 'vue-event-calendar'



Vue.mixin({ methods: { route } });

Vue.use(vueEventCalendar, {locale: 'en'})
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
