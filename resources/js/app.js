import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import { createVuetify } from 'vuetify'
import Layout from './Layouts/Layout.vue'
import router from './router'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]
    page.default.layout = page.default.layout || Layout
    return page
  },
  setup({ el, App, props, plugin }) {
    const vuetify = createVuetify({ components, directives });
    const vueApp = createApp({ render: () => h(App, props) })
    
    vueApp.use(plugin)
    vueApp.use(vuetify)
    vueApp.use(router)
    vueApp.mount(el)
  },
})
