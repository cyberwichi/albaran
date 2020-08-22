<template>
    <div>
        <div class="card">
            <div class="card-header text-center">
                <h4>Aviso</h4>
                <h5>
                    Id Aviso:
                    <strong>{{ idaviso }}</strong>
                </h5>
                <h5>
                    <label><input type="checkbox" id="cbox1" value="first_checkbox" v-model="terminada" />
                Aviso Terminado</label
            >
                </h5>

                <label for="myChoice">¿Valorar los partes creados por este aviso?</label>
                    SI
                    <input
                        id="default_yes"
                        name="myChoice"
                        value="1"
                        type="radio"
                        v-model="valorar"
                        required
                        selected
                    />
                    NO
                    <input
                        id="default_no"
                        name="myChoice"
                        value="0"
                        type="radio"
                        v-model="valorar"
                        required
                    />
            </div>

            <div class="card">
                <form>
                    <div class="card">
                        <div class="form-group">
                            <h5 class="col-12 display-5">
                                <h4
                                    v-if="!flageditar"
                                    v-on:click="flageditar = !flageditar"
                                >
                                    Empleado asignado: {{ nombreEmpl }}
                                </h4>

                                <div v-else class="dropdown">
                                    <button
                                        class="btn btn-secondary dropdown-toggle"
                                        type="button"
                                        id="dropdownMenu2"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        {{ nombreEmpl }}
                                    </button>
                                    <div
                                        class="dropdown-menu "
                                        aria-labelledby="dropdownMenu2"
                                    >
                                        <button
                                            class="dropdown-item w-100 text-white bg-danger text-center m-0 mb-3"
                                            v-on:click="
                                                asignarEmpleado(null);
                                                flageditar = !flageditar;
                                            "
                                        >
                                            No Asignar
                                        </button>
                                        <button
                                            v-for="(empleado,
                                            index) in empleados"
                                            v-bind:key="index"
                                            class="dropdown-item text-center m-0 mb-3 "
                                            type="button"
                                            v-on:click="
                                                asignarEmpleado(empleado);
                                                flageditar = !flageditar;
                                            "
                                        >
                                            {{ empleado.name }}
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    Cliente: {{ aviso[0].tb_contacto.Nombre }}
                                </div>
                                <div>
                                    Direccion:
                                    {{ aviso[0].tb_contacto.Direccion }}
                                </div>
                                <div>
                                    Telefono:
                                    {{ aviso[0].tb_contacto.Telefono }}
                                </div>
                                <div>Nif: {{ aviso[0].tb_contacto.Nif }}</div>
                                <div>
                                    Email: {{ aviso[0].tb_contacto.Email }}
                                </div>
                            </h5>
                        </div>
                    </div>

                    <div
                        v-on:click="flageditarfecha = true"
                        class="card form-group"
                    >
                        <label class="col-12" for="fechaPrevistaform"
                            >Fecha y Hora Prevista Realizacion</label
                        >
                        <p v-on:click="flageditarfecha = true">
                            {{
                                aviso[0].fechaPrevista
                                    | moment("DD/MM/YYYY, h:mm a")
                            }}
                        </p>
                        <input
                            v-if="flageditarfecha"
                            type="datetime-local"
                            class="form-control"
                            v-model="aviso[0].fechaPrevista"
                        />
                    </div>

                    <div class="card form-group sombra p-2">
                        <label class="col-12" for="observaciones"
                            >Observaciones</label
                        >
                        <input
                            class="form-control col-12"
                            name="observaciones"
                            v-model="aviso[0].comentario"
                        />
                    </div>

                    <div class="card-body ">
                        <div class="table-responsive card  sombra">
                            <table class="table">
                                <thead class="text-center thead">
                                    <h5 class="text-center">Pedido</h5>
                                    <tr>
                                        <th scope="col">Ref. Articulo</th>
                                        <th scope="col">Articulo</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(linea, index) in pedido"
                                        :key="index"
                                    >
                                        <th
                                            v-if="'articulo' in linea"
                                            scope="row"
                                        >
                                            {{ linea.articulo.Referencia }}
                                        </th>
                                        <th v-else scope="row">
                                            {{ linea.referencia }}
                                        </th>
                                        <td>{{ linea.articulo_nombre }}</td>
                                        <td>{{ linea.cantidad }}</td>
                                        <td>{{ linea.precio }}</td>

                                        <td>
                                            <img
                                                class="m-3 vertical-aling"
                                                v-on:click="
                                                    borrarArticulo(index)
                                                "
                                                src="/img/Delete.png"
                                                width="25px"
                                                height="25px"
                                                alt
                                            />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
                        </div>
                    </div>

                    <autocompletararticulo-component
                        @nuevaLinea="añadirArticulo($event)"
                        class="card bg-light mb-3"
                        name="articulo"
                        v-model="linea"
                    ></autocompletararticulo-component>
                    <div class="text-center">
                        <button
                            type="button"
                            class="btn btn-flat m-3"
                            v-on:click="nuevoPedido"
                        >
                            <img
                                src="/img/Save.png"
                                width="50px"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Guardar Aviso"
                            />
                        </button>
                    </div>
                </form>
            </div>

            <div class="card mt-3">
                <nuevoalbaran-component
                    v-if="veralbaran"
                    :numeroaviso="idaviso"
                    class="mt-5 card bg-light mb-3"
                    @salir="salir"
                ></nuevoalbaran-component>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["idaviso"],
    data: function() {
        return {
            aviso: {},
            vermas: false,
            pedido: {},
            contacto: {},
            subtotal: 0,
            iva: 0,
            total: 0.0,
            idavisoflag: true,
            fechaprevista: "",
            observaciones: "",
            veralbaran: false,
            miFechaPrevista: "",
            flageditar: false,
            flageditarfecha: false,
            empleados: [],
            nombreEmpl: "",
            linea: {},
            terminada: false,
            valorar:true,
        };
    },
    created() {
        this.buscaDatos();
    },
    watch: {
        fechaprevista: function(val) {
            this.aviso[0].fechaPrevista = this.fechaprevista;
        }
    },
    methods: {
        salir() {
            this.$emit("salir");
        },
        nombreEmpleado() {
            this.nombreEmpl = "";
            var vm = this;
            if (this.aviso[0].empleado_id == null) {
                vm.nombreEmpl = "Sin Asignar";
            } else {
                axios
                    .get("/api/empleados/" + this.aviso[0].empleado_id)
                    .then(response => {
                        vm.nombreEmpl = response.data.name;
                    })
                    .catch(e => console.log(e));
            }
        },
        getEmpleadosActivos() {
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/activos")
                .then(response => {
                    this.empleados = response.data;
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
        },
        buscaDatos() {
            //cargar los datos
            if (this.idaviso) {
                document.getElementById("app").style.cursor = "progress";
                axios
                    .get("/api/avisos/" + this.idaviso)
                    .then(response => {
                        this.aviso = response.data;
                        this.buscaDetalles(this.idaviso);
                        this.getEmpleadosActivos();
                        this.nombreEmpleado();
                        this.comenta = this.aviso[0].comentario;
                        this.contacto = this.aviso[0].tb_contacto;
                        this.fechaprevista = this.aviso[0].fechaPrevista;
                        this.observaciones = this.aviso[0].comentario;
                        this.terminada= this.aviso[0].terminada;
                        this.valorar= this.aviso[0].valorar;
                        document.getElementById("app").style.cursor = "auto";
                    })
                    .catch(e => {
                        console.log(e);
                        document.getElementById("app").style.cursor = "auto";
                    });
            }
        },
        añadircontacto(contacto) {
            this.aviso[0].tb_contacto.Telefono = contacto.Telefono;
            this.aviso[0].tb_contacto.Nombre = contacto.Nombre;
            this.aviso[0].tb_contacto.Direccion = contacto.Direccion;
        },
        añadirArticulo(linea) {
            var aux = {
                cantidad: linea.articuloCantidad,
                articulo_id: linea.articuloId,
                articulo_nombre: linea.articuloNombre,
                precio: linea.articuloPrecio,
                referencia: linea.referencia
            };
            this.pedido.push(aux);
            this.actualizaTotal();
        },
        borrarArticulo(index) {
            this.pedido.splice(index, 1);
            this.actualizaTotal();
        },
        actualizaTotal() {
            this.iva = 0;
            this.subtotal = 0;
            this.total = 0;
            this.pedido.forEach(element => {
                this.subtotal += element.precio * element.cantidad;
            });
            this.subtotal = Number(this.subtotal.toFixed(2));
            this.iva = this.subtotal * 0.21;
            this.iva = Number(this.iva.toFixed(2));
            this.total = this.subtotal + this.iva;
            this.total = Number(this.total.toFixed(2));
        },
        asignarEmpleado(empleado) {
            if (empleado !== null) {
                this.nombreEmpl = empleado.name;
                this.aviso[0].empleado_id = empleado.id;
            } else {
                this.aviso[0].empleado_id = null;
                this.nombreEmpl = null;
            }
        },

        nuevoPedidoyalbaran() {
            var data = {
                id: this.idaviso,
                clientid: this.aviso[0].contacto_id,
                fechaPrevista: this.aviso[0].fechaPrevista,
                listaarticulos: this.pedido,
                observaciones: this.aviso[0].comentario,
                empleado: this.aviso[0].empleado_id,
               
            };
            document.getElementById("app").style.cursor = "progress";
            axios.post("/api/aviso", data).then(response => {
                this.idaviso = response.data;
                document.getElementById("app").style.cursor = "auto";
            });
            this.veralbaran = true;
        },
        nuevoPedido() {
            var data = {
                id: this.idaviso,
                clientid: this.aviso[0].contacto_id,
                fechaPrevista: this.aviso[0].fechaPrevista,
                listaarticulos: this.pedido,
                observaciones: this.aviso[0].comentario,
                empleado: this.aviso[0].empleado_id,
                terminada: this.terminada,
                valorar: this.valorar
            };
            console.log(data);
            document.getElementById("app").style.cursor = "progress";
            axios.post("/api/aviso", data).then(response => {
                this.idaviso = response.data;
                this.$emit("salir");
                document.getElementById("app").style.cursor = "auto";
            });
        },

        buscaDetalles(id) {
            document.getElementById("app").style.cursor = "progress";
            axios.get("/api/detalles/" + id).then(response => {
                this.pedido = response.data;

                this.actualizaTotal();
            });
        }
    }
};
</script>
