<template>
    <transition class="modal" name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <button
                        class="modal-default-button"
                        @click="$emit('close')"
                    >
                        X
                    </button>
                    <div class="modal-header d-flex flex-wrap border border-secondary mb-2">
                        <h2 class="">Detalle Aviso Id: {{ avis.id }}</h2>
                        

                        <div class="d-flex flex-wrap p-2 text-center justify-content-around border border-secondary">
                            <h4 class="col-12">
                            Albaranes de este pedido
                        </h4>
                            <button
                                class=""
                                v-for="linea in albaranes"
                                :key="linea.id"
                                v-on:click="
                                    veralbaran = true;
                                    numeroalbaran = linea;
                                "
                            >
                                {{ linea.id }}
                            </button>
                            <p v-if="albaranes==''">
                                Sin albaranes
                            </p>
                        </div>

                      
                    </div>
                     <button class="text-center" v-show="veralbaran" v-on:click="veralbaran=false">Cerrar Albaran</button>
                      <vistaalbaran-component
                            class="albaran m-auto"
                            :albaran="numeroalbaran"
                            v-show="veralbaran"
                        ></vistaalbaran-component>
                       

                    <div class="modal-body">
                        <slot name="body">
                            <p>Cliente: {{ avis.tb_contacto.Nombre }}</p>
                            <p>Direccion: {{ avis.tb_contacto.Direccion }}</p>
                            <p>Telefono: {{ avis.tb_contacto.Telefono }}</p>

                            <table class="table table-responsive">
                                <thead class="text-center thead">
                                    <tr>
                                        <th scope="col">Id Articulo</th>
                                        <th scope="col">Articulo</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(linea, index) in detalles"
                                        :key="index"
                                    >
                                        <th scope="row">
                                            {{ linea.articulo_id }}
                                        </th>
                                        <td>{{ linea.articulo_nombre }}</td>
                                        <td>{{ linea.cantidad }}</td>
                                        <td>{{ linea.precio }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                            <div class="float-right mr-2">
                                <div class="text-right">
                                    <strong>Subtotal :</strong>
                                    {{ subtotal }} €
                                </div>
                                <div class="text-right">
                                    <strong>21% Iva :</strong>
                                    {{ iva }} €
                                </div>
                                <div class="mt-2 mb-5 text-right">
                                    <strong>Total :</strong>
                                    {{ total }} €
                                </div>
                            </div>
                        </slot>
                    </div>

                    <div>Comentario : {{ avis.comentario }}</div>
                    <div v-if="avis.terminada">Terminada : Si</div>

                    <div v-if="!avis.terminada">Terminada : No</div>

                    <button
                        class="modal-default-button"
                        @click="$emit('close')"
                    >
                        X
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: ["avis", "nombre"],
    data() {
        return {
            detalles: [],
            linea: "",
            subtotal: 0,
            iva: 0,
            total: 0.0,
            albaranes: [],
            veralbaran: false,
            numeroalbaran: {}
        };
    },
    mounted() {
        this.calcularTotal();
        this.buscaAlbaranes();
    },
    beforeMount() {
        this.buscaDetalles(this.avis.id);
    },
    methods: {
        buscaDetalles(id) {
            document.getElementById("app").style.cursor = "progress";
            axios.get("/api/detalles/" + id).then(response => {
                this.detalles = response.data;
                this.calcularTotal();
                document.getElementById("app").style.cursor = "auto";
            });
        },
        buscaAlbaranes() {
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/albaranesporaviso/" + this.avis.id)
                .then(response => {
                    this.albaranes = response.data;
                    document.getElementById("app").style.cursor = "auto";
                });
        },
        calcularTotal() {
            this.iva = 0;
            this.subtotal = 0;
            this.total = 0;
            this.detalles.forEach(element => {
                this.subtotal += element.precio * element.cantidad;
            });
            this.subtotal = Number(this.subtotal.toFixed(2));
            this.iva = this.subtotal * 0.21;
            this.iva = Number(this.iva.toFixed(2));
            this.total = this.subtotal + this.iva;
            this.total = Number(this.total.toFixed(2));
        }
    },
    computed: {}
};
</script>
<style>
.albaran {
    max-width: 700px;
    height: 300px;
    overflow: scroll;
}
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;

    background-color: rgba(0, 0, 0, 0.6);
    overflow: scroll;
    display: table;
    transition: opacity 0.3s ease-in-out;
    max-height: 600px;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
    max-width: 90%;
    max-height: 600px;
}

.modal-container {
    overflow: scroll;
    padding: 10px 10px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
    transition: all 0.3s ease;
}
.modal-container table {
    font-size: 16px;
}

@media (max-width: 1000px) {
    .modal-container {
        max-width: 380px;
        max-height: 400px;

    }
    .modal-container table {
        font-size: 12px;
    }
}

.modal-header h3 {
    margin-top: 0;
    color: #42b983;
}

.modal-body {
    margin: 10px 0;
}

.modal-default-button {
    float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
    opacity: 0;
}

.modal-leave-active {
    opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}
</style>
