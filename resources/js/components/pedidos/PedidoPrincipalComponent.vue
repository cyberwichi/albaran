<template>
    <div class="">
        <div class="col-12 text-center h1 mb-3">
            <strong>AVISOS</strong>
        </div>
        <div class="row d-flex align-items-end align-text-bottom"> 
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    :class="{ disabled: campo == 'nuevo' }"
                    v-on:click="vermasmethod('nuevo')"
                    v-scroll-to="'#nuevo'"
                >
                    Nuevo Aviso
                </button>
                <div id="vistapedido"></div>
            </div>           
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    :class="{ disabled: campo == 'noterminados' }"
                    v-on:click="vermasmethod('noterminados')"
                    v-scroll-to="'#noterminados'"
                >
                   Avisos Pendientes
                </button>
            </div>
<!--             <div class="col text-center mb-0 form-group">
                <input
                    type="text"
                    v-model="idavisoedita"
                    id=""
                    placeholder="Numero:"
                    class=" form-control "
                />
                <button
                    class="btn btn-primary"
                    v-on:click="
                        idaviso = idavisoedita;
                        vermasmethod('edita');
                    "
                    :class="{ disabled: campo == 'edita'}"
                    v-scroll-to="'#edita'"
                >
                    Modificar
                </button> -->
            <!-- </div> -->
<!--             <div class="col text-cente form-group mb-0">
                <input
                    type="text"
                    v-model="numero"
                    id=""
                    placeholder="Numero:"
                    class=" form-control "
                />
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('pedido')"
                    :class="{ disabled: campo == 'pedido' }"
                    v-scroll-to="'#pedido'"
                >
                    Ver
                </button>
            </div> -->
            
             <div class="col text-cente form-group mb-0">
 
                <button
                    class="btn btn-primary"
                    :class="{ disabled: campo == 'fechas' }"
                    v-on:click="fecha=true;vermasmethod('fechas')"
                    v-scroll-to="'#listado'"                   
                >
                    Ver por Fechas
                </button>
            </div>
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    :class="{ disabled: campo == 'porcliente' }"
                    v-on:click="vermasmethod('porcliente')"
                    v-scroll-to="'#porcliente'"
                >
                    Avisos por Cliente
                </button>
            </div>            
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    :class="{ disabled: campo == 'listado' }"
                    v-on:click="vermasmethod('listado')"
                    v-scroll-to="'#listado'"
                >
                    Listado Avisos
                </button>
            </div>
            <div id="vistapedido"></div>
            <div id="listado"></div>
            <div id="noterminados"></div>
            <div id="porcliente"></div>
            <div id="nuevo"></div>
            <div id="edita"></div>
        </div>
        <pedidos-component
            :key="reload"
            @salir="ireditarAviso($event)"
            v-if="campo == 'listado'"
            class="mt-5 mb-3"
            

        ></pedidos-component>
        <pedidosporfechas-component
            :key="reload"
            @salir="ireditarAviso($event)"
            v-if="campo == 'fechas'"
            class="mt-5 mb-3"
            

        ></pedidosporfechas-component>


        <pedidosporcliente-component
            @salir="ireditarAviso($event)"
            :key="reload"
            v-if="campo == 'porcliente'"
            class="mt-5 mb-3"
        ></pedidosporcliente-component>

        <pedidosnoterminados-component
            @salir="ireditarAviso($event)"
            :key="reload"
            v-if="campo == 'noterminados'"
            class="mt-5 mb-3"
        ></pedidosnoterminados-component>

        <nuevopedido-component
            v-if="campo == 'nuevo'"
            class="mt-5 card bg-light mb-3"
            @new="guardarpedido"
            @salir="campo = 'listado'"
        ></nuevopedido-component>

        <editapedido-component
            :key="reload"
            v-if="campo == 'edita'"
            class="mt-5 card bg-light mb-3"
            @new="guardarpedido"
            :idaviso="idaviso"
            @salir="campo = 'listado'"
        ></editapedido-component>

        <vistapedido-component
            :key="reload"
            v-if="campo == 'pedido'"
            class="mt-5 mb-3"
            :numero="numero"
            @albaran="campo = 'veralbaran'"
            @salir="campo = 'listado'"
            @editar="
                idaviso = $event;
                campo = 'edita';
            "
        ></vistapedido-component>
        <div id="veralbaran"></div>
        <nuevoalbaran-component
            :key="reload"
            v-if="campo == 'veralbaran'"
            :numeroaviso="numero"
            class="mt-5 card bg-light mb-3"
            @salir="campo = 'listado'"
        ></nuevoalbaran-component>

        <div
            class="col-12 col-xl-12 ml-auto mr-auto mt-3 p-5 card-body text-center"
        >
            <h4>Avisos No Finalizados</h4>

            <vue-cal
                :time="false"
                default-view="month"
                events-count-on-year-view
                events-on-month-view="true"
                class=""
                v-if="event"
                :locale="es"
                style="min-height: 600px; height:100%"
                :events="events"
                :on-event-click="onEventClick"
            >
                <template v-slot:event-renderer="{ event, view }">
                    <div style="cursor:pointer" v-scroll-to="'#vistapedido'">
                        Numero de aviso:
                        <div class="vuecal__event-title" v-html="event.title" />
                        <div
                            class="vuecal__event-content"
                            v-html="event.content"
                        ></div>
                        <small class="vuecal__event-time">
                            <strong>Hora concertada:</strong>
                            <span>{{ event.start.substr(11) }}</span
                            ><br />
                        </small>
                    </div>
                </template>
            </vue-cal>

            <button class="card-footer" v-on:click="veravisos">
                Actualizar
            </button>
        </div>
    </div>

</template>

<script>
import "vue-cal/dist/i18n/zh-cn.js";
export default {
    components: { "vue-cal": vuecal },
    data() {
        return {
            vm: this,
            es: "es",
            campo: "",
            reload: 1,
            numero: "",
            events: [],
            event: 0,
            idaviso: 0,
            idavisoedita: "",
            fecha:false,

        };
    },
    created() {
        this.veravisos();
    },

    methods: {
        ireditarAviso(aviso) {
            this.idaviso = aviso.id;
            this.campo = "edita";
        },
        onEventClick(event, e) {
            this.salir();
            this.numero = event.title;
            this.campo = "pedido";
            // Prevent navigating to narrower view (default vue-cal behavior).
            e.stopPropagation();
        },
        veravisos() {
            this.events = [];
            this.event = false;
            axios.get("/api/avisosnoterminados").then(response => {
                var datos = response.data;
                datos.sort(function(a, b) {
                    if (a.fechaPrevista > b.fechaPrevista) {
                        return 1;
                    }
                    if (a.fechaPrevista < b.fechaPrevista) {
                        return -1;
                    }
                    // a must be equal to b
                    return 0;
                });

                datos.forEach(element => {
                    let data = {};
                    if (element.fechaPrevista) {
                        if (
                            element.empleado == null ||
                            element.empleado_id == null
                        ) {
                            if (
                                element.tb_contacto == null ||
                                element.contacto_id == null
                            ) {
                                data = {
                                };
                            } else {
                                data = {
                                    start: element.fechaPrevista,
                                    end: element.fechaPrevista,
                                    title: element.id,
                                    content:
                                        "<br><strong>Cliente: " +
                                        element.tb_contacto.Nombre +
                                        "</strong>" +
                                        "<br> Direccion Cliente: <strong> " +
                                        element.tb_contacto.Direccion +
                                        "</strong>" +
                                        "<br> <br>Empleado asignado: <strong> Sin Asignar </strong>",
                                    class: "btn btn-primary "
                                };
                                this.events.push(data);
                            }
                        } else {
                            if (
                                element.tb_contacto == null ||
                                element.contacto_id == null
                            ) {
                                data = {
                                    
                                };
                              
                            } else {
                                data = {
                                    start: element.fechaPrevista,
                                    end: element.fechaPrevista,
                                    title: element.id,
                                    content:
                                        "<br><strong>Cliente: " +
                                        element.tb_contacto.Nombre +
                                        "</strong>" +
                                        "<br> Direccion Cliente: <strong> " +
                                        element.tb_contacto.Direccion +
                                        "</strong>" +
                                        "<br> <br>Empleado asignado: <strong> " +
                                        element.empleado.name +
                                        " </strong>",
                                    class: "btn btn-primary "
                                };
                                this.events.push(data);
                                
                            }
                        }
                        this.event = true;
                    }
                });
            });
        },
        vermasmethod(campo) {
            this.campo = "null";
            this.campo = campo;
        },
        guardarpedido() {},
        salir() {
            this.reload = !this.reload;
        }
    }
};
</script>
<style scoped>
.fade-enter-active {
    transition: opacity 0.1s;
}
.fade-leave-active {
    transition: opacity 0.1s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>
