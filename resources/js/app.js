

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
import VueCal from 'vue-cal';
import 'vue-cal/dist/i18n/es';
import 'vue-cal/dist/vuecal.css';

Vue.use(VueRouter);
Vue.use(require('vue-moment'));
var VueScrollTo = require('vue-scrollto');

Vue.use(VueScrollTo)

// You can also pass in the default options
Vue.use(VueScrollTo, {
    container: "#app",
    duration: 500,
    easing: "ease",
    offset: 0,
    force: true,
    cancelable: true,
    onStart: false,
    onDone: false,
    onCancel: false,
    x: false,
    y: true
})


Vue.component('contactoprincipal-component', require('./components/contactos/ContactosPrincipalComponent.vue').default);
Vue.component('contactos-component', require('./components/contactos/ContactosComponent.vue').default);
Vue.component('responsecontacto-component', require('./components/contactos/ResponsecontactosComponent.vue').default);
Vue.component('nuevocontacto-component', require('./components/contactos/NuevocontactoComponent.vue').default);


Vue.component('autocompletararticulo-component', require('./components/acciones/AutocompletarArticuloComponent.vue').default);
Vue.component('autocompletarmaquina-component', require('./components/acciones/AutocompletarMaquinaComponent.vue').default);
Vue.component('autocompletcontacto-component', require('./components/acciones/AutocompletarContactoComponent.vue').default);
Vue.component('principal-component', require('./components/PrincipalComponent.vue').default);


Vue.component('response-component', require('./components/articulos/ResponseComponent.vue').default);
Vue.component('articulos-component', require('./components/articulos/ArticulosComponent.vue').default);
Vue.component('nuevoarticulo-component', require('./components/articulos/NuevoArticuloComponent.vue').default);
Vue.component('articuloprincipal-component', require('./components/articulos/ArticuloPrincipalComponent.vue').default);
Vue.component('recibearticulo-component', require('./components/articulos/RecibeArticuloComponent.vue').default);


Vue.component('stock-component', require('./components/articulos/StockComponent.vue').default);
Vue.component('responsestock-component', require('./components/articulos/ResponseStockComponent.vue').default);

Vue.component('nuevoalbaran-component', require('./components/albaranes/NuevoAlbaranComponent.vue').default);
Vue.component('albaranprincipal-component', require('./components/albaranes/AlbaranPrincipalComponent.vue').default);
Vue.component('albaran-component', require('./components/albaranes/AlbaranComponent.vue').default);
Vue.component('responsealbaran-component', require('./components/albaranes/ResponseAlbaranComponent.vue').default);
Vue.component('vistaalbaran-component', require('./components/albaranes/VistaAlbaranComponent.vue').default);
Vue.component('albarancliente-component', require('./components/albaranes/AlbaranPorClienteComponent.vue').default);


Vue.component('pedidoprincipal-component', require('./components/pedidos/PedidoPrincipalComponent.vue').default);
Vue.component('responseaviso-component', require('./components/pedidos/ResponseAvisoComponent.vue').default);
Vue.component('modal-component', require('./components/pedidos/ModalComponent.vue').default);
Vue.component('pedidos-component', require('./components/pedidos/PedidosComponent.vue').default);
Vue.component('nuevopedido-component', require('./components/pedidos/NuevopedidoComponent.vue').default);
Vue.component('pedidosporcliente-component', require('./components/pedidos/PedidosPorClienteComponent.vue').default);
Vue.component('pedidosnoterminados-component', require('./components/pedidos/PedidosNoTerminadosComponent.vue').default);
Vue.component('vistapedido-component', require('./components/pedidos/VistaPedidoComponent.vue').default);
Vue.component('editapedido-component', require('./components/pedidos/EditapedidoComponent.vue').default);


Vue.component('empleadoprincipal-component', require('./components/empleados/EmpleadosPrincipalComponent.vue').default);
Vue.component('empleados-component', require('./components/empleados/EmpleadosComponent.vue').default);
Vue.component('responseempleado-component', require('./components/empleados/ResponseempleadosComponent.vue').default);
Vue.component('nuevoempleado-component', require('./components/empleados/NuevoempleadoComponent.vue').default);
Vue.component('administradores-component', require('./components/empleados/AdministradoresComponent.vue').default);
Vue.component('responseadministradores-component', require('./components/empleados/ResponseadministradoresComponent.vue').default);


Vue.component('responsemaquinas-component', require('./components/maquinas/ResponseComponent.vue').default);
Vue.component('maquinas-component', require('./components/maquinas/MaquinasComponent.vue').default);
Vue.component('nuevomaquina-component', require('./components/maquinas/NuevoMaquinaComponent.vue').default);
Vue.component('maquinasprincipal-component', require('./components/maquinas/MaquinasPrincipalComponent.vue').default);
Vue.component('maquinashistorial-component', require('./components/maquinas/MaquinasHistorialComponent.vue').default);



const app = new Vue({
    el: '#app'
    
    
});
