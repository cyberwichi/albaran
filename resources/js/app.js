/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('response-component', require('./components/articulos/ResponseComponent.vue').default);
Vue.component('articulos-component', require('./components/articulos/ArticulosComponent.vue').default);
Vue.component('nuevoarticulo-component', require('./components/articulos/NuevoArticuloComponent.vue').default);
Vue.component('contactos-component', require('./components/contactos/ContactosComponent.vue').default);
Vue.component('responsecontacto-component', require('./components/contactos/ResponsecontactosComponent.vue').default);
Vue.component('nuevocontacto-component', require('./components/contactos/NuevocontactoComponent.vue').default);
Vue.component('pedidos-component', require('./components/pedidos/PedidosComponent.vue').default);
Vue.component('nuevopedido-component', require('./components/pedidos/NuevopedidoComponent.vue').default);
Vue.component('autocompletararticulo-component', require('./components/acciones/AutocompletarArticuloComponent.vue').default);
Vue.component('autocompletcontacto-component', require('./components/acciones/AutocompletarContactoComponent.vue').default);
Vue.component('principal-component', require('./components/PrincipalComponent.vue').default);
Vue.component('articuloprincipal-component', require('./components/articulos/ArticuloPrincipalComponent.vue').default);
Vue.component('contactoprincipal-component', require('./components/contactos/ContactosPrincipalComponent.vue').default);
Vue.component('pedidoprincipal-component', require('./components/pedidos/PedidoPrincipalComponent.vue').default);
Vue.component('stock-component', require('./components/articulos/StockComponent.vue').default);
Vue.component('responsestock-component', require('./components/articulos/ResponseStockComponent.vue').default);
Vue.component('albaran-component', require('./components/pedidos/AlbaranComponent.vue').default);







/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    
});
