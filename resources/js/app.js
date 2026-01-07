import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

import PrimeVue from 'primevue/config'
import Aura from '@primeuix/themes/aura';

import Select from 'primevue/select';
import Button from 'primevue/button';
import InputGroup from 'primevue/inputgroup';
import InputText from 'primevue/inputtext';

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    const vueApp = createApp({ 
      render: () => h(App, props) 
    })
    vueApp.use(plugin)
    vueApp.use(PrimeVue,{
        theme: {
            preset: Aura
        }
    })
    vueApp.component('Select', Select)
    vueApp.component('Button', Button)
    vueApp.component('InputGroup', InputGroup)
    vueApp.component('InputText', InputText)
    vueApp.mount(el)
  },
})
