<template>
    <div class="mt-2">
        <div id="imprimible">
            <div>
                <img
                    class="cabecera image-responsive"
                    src="/img/cabecera.jpeg"
                    alt=""
                />
            </div>
            <h4 v-on:change="buscaaviso(albaran.aviso_id)" class="text-center">
                <strong>Parte de Trabajo Numero: </strong> {{ albaran.id }}
                <strong>
                    Fecha :
                </strong>
                {{ albaran.created_at | moment("DD/MM/YYYY, h:mm a") }}
                <strong>
                    Numero de aviso :
                </strong>
                {{ albaran.aviso_id }}
                <strong>
                    Empleado:
                </strong>
                {{ aviso[0].empleado.name }}
            </h4>

            <div class="card-body">
                <!-- cliente -->

                <div class="card">
                    <div class="firmas h4">
                        <div class="">
                            <div>Cliente: {{ cliente.Nombre }}</div>
                            <div>Direccion: {{ cliente.Direccion }}</div>
                            <div>Telefono: {{ cliente.Telefono }}</div>
                        </div>
                        <div class="">
                            <div>Nif: {{ cliente.Nif }}</div>
                            <div>Email: {{ cliente.Email }}</div>
                        </div>
                    </div>
                </div>

                <!-- maquinas -->
                <div class="card sombra mt-2">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-center thead">
                                <tr>
                                    <th scope="col">Maquina</th>
                                    <th scope="col">Serie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(maq, index) in maquinas"
                                    :key="index"
                                >
                                    <th scope="row">{{ maq.nombre }}</th>
                                    <td>
                                        {{ maq.referencia }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- detalle -->
                <!--                 <div class="card sombra">
                    <div class="card-header">
                        <h5 class>Detalle de Pedido</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table ">
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
                                    <th scope="row">{{ linea.articulo_id }}</th>
                                    <td>{{ linea.articulo_nombre }}</td>
                                    <td>{{ linea.cantidad }}</td>
                                    <td>{{ linea.precio }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card sombra m-2">
                        <div>Comentarios:</div>
                        <strong>{{ comenta }}</strong>
                    </div>
                </div> -->

                <!-- articulos entregados -->
                <div class="card sombra mt-2">
                    <div class="card-header">
                        <h5 class>Articulos Entregados</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead class="text-center thead">
                                <tr>
                                    <th scope="col">Referencia</th>
                                    <th scope="col">Articulo</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-on:change="calcularTotal"
                                    v-for="(linea2, index) in detallealbaran"
                                    :key="index"
                                >
                                    <th scope="row">
                                        {{ linea2.referencia }}
                                    </th>
                                    <td>{{ linea2.articulo_nombre }}</td>
                                    <td>{{ linea2.cantidad }}</td>
                                    <td>{{ linea2.precio }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-secondary p-1">
                            <tr class="d-flex justify-content-end bd-highlight">
                                <td class="col-4 text-right sombra">
                                    <strong>Subtotal: {{ subtotal }}€</strong>
                                </td>

                                <td td class="col-4 text-right sombra">
                                    <strong>21%Iva: {{ iva }}€</strong>
                                </td>

                                <td td class="col-4 sombra text-right">
                                    <strong>Total: {{ total }}€</strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- observaciones -->
                <div class="card sombra mt-2">
                    <div class="card-header">
                        <h4>
                            Trabajo Finalizado :<strong
                                v-if="aviso[0].terminada"
                                >Si</strong
                            >
                            <strong v-else>No</strong>
                        </h4>
                    </div>

                    <div class="form-group p-3">
                        <h5>
                            <strong>Observaciones / Material Pendiente</strong>
                        </h5>
                        <p>{{ albaran.observaciones }}</p>
                    </div>
                </div>

                <!-- firmas -->
                <div class="card mt-2">
                    <div class="card-header">
                        <h4>Firmas</h4>
                    </div>
                    <div class=" card.body firmas sombra p-2">
                        <h5>Firma Cliente</h5>
                        <img
                            id="firmacli"
                            width="150"
                            height="150"
                            v-show="albaran.firma_cliente"
                            :src="albaran.firma_cliente"
                        />
                        <h5>Firma Empleado</h5>
                        <img
                            id="firmaemp"
                            width="150"
                            height="150"
                            v-show="albaran.firma_empleado"
                            :src="albaran.firma_empleado"
                        />
                    </div>
                </div>
                <div class="faldon">
                    <small>
                        C.I.F. B-72177827 - Telefono 956 59 125 -Pol. Ind.
                        Puente Hierro, Crta. de la Carraca 74 - 11100 San
                        Fernando (Cádiz) - gestion.aif@gmail.com - Movil: 685
                        696 156
                    </small>
                </div>
            </div>
        </div>

        <!-- botones guardar imprimir -->
        <div class="d-flex flex-row-reverse bd-highlight mr-5">
            <button class="btn btn-success">
                <img
                    src="img/print.png"
                    v-on:click="imprimirElemento"
                    width="40px"
                />
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ["albaran"],
    data: function() {
        return {
            aviso: {},
            detalles: [],
            detallealbaran: [],
            cliente: {},
            iva: 0,
            subtotal: 0,
            total: 0,
            observaciones: "",
            vermas: true,
            firmacli: "",
            firmaemp: "",
            numeroAlbaran: "",
            comenta: "",
            signaturePad2: "",
            signaturePad: "",
            terminado: false,
            maquinas: []
        };
    },
    watch: {
        albaran: function(val) {
            if (val) {
                this.poneraCero();

                this.buscaaviso(val.aviso_id);
            }
        }
    },
    created() {
        this.buscaaviso(this.albaran.aviso_id);
    },

    methods: {
        poneraCero() {
            this.aviso = {};
            this.detalles = [];
            this.detallealbaran = [];
            this.cliente = {};
            this.iva = 0;
            this.subtotal = 0;
            this.total = 0;
            this.observaciones = "";
            this.vermas = true;
            this.firmacli = "";
            this.firmaemp = "";
            this.numeroAlbaran = "";
            this.comenta = "";
            this.terminado = false;
            this.numeroaviso = "";
            this.maquinas = [];
        },
        buscaaviso(numeroaviso) {
            this.aviso = "";
            this.detalles = "";
            this.cliente = "";
            this.comenta = "";
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/avisos/" + numeroaviso)
                .then(response => {
                    this.aviso = response.data;
                    this.buscaDetalles(numeroaviso);
                    this.buscaCliente(this.aviso[0].contacto_id);

                    this.comenta = this.aviso[0].comentario;
                    if (this.aviso[0].empleado == null) {
                        this.aviso[0].empleado = {
                            id: 0,
                            name: "Sin Asignar",
                            telefono: ""
                        };
                    }
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
        },
        buscaDetalles(id) {
            document.getElementById("app").style.cursor = "progress";
            axios.get("/api/detalles/" + id).then(response => {
                this.detalles = response.data;
            });
            axios
                .get("/api/detallesalbaran/" + this.albaran.id)
                .then(response => {
                    response.data.forEach(element => {
                        axios
                            .get("/api/referenciaid/" + element.articulo_id)
                            .then(response => {
                                var aux = {
                                    id: element.id,
                                    albaran_id: element.albaran_id,
                                    articulo_id: element.articulo_id,
                                    articulo_nombre: element.articulo_nombre,
                                    cantidad: element.cantidad,
                                    precio: element.precio,
                                    referencia: response.data.referencia
                                };
                                this.detallealbaran.push(aux);
                                this.calcularTotal();
                                document.getElementById("app").style.cursor =
                                    "auto";
                            });
                    });
                });
            this.albaran.albaranmaquina.forEach((element, index) => {
                axios
                    .get("/api/maquinas/" + element.maquina_id)
                    .then(response => {
                        let maquina = {
                            nombre: response.data.nombre,
                            referencia: element.referencia
                        };
                        this.maquinas.push(maquina);
                    });
            });
        },
        calcularTotal() {
            this.iva = 0;
            this.subtotal = 0;
            this.total = 0;
            this.detallealbaran.forEach(element => {
                this.subtotal += element.precio * element.cantidad;
            });
            this.subtotal = Number(this.subtotal.toFixed(2));
            this.iva = this.subtotal * 0.21;
            this.iva = Number(this.iva.toFixed(2));
            this.total = this.subtotal + this.iva;
            this.total = Number(this.total.toFixed(2));
        },
        buscaCliente(id) {
            document.getElementById("app").style.cursor = "progress";
            axios.get("/api/contactos/" + id).then(response => {
                this.cliente = response.data;
                document.getElementById("app").style.cursor = "auto";
            });
        },

        guardaAlbaran() {
            var registroAlbaran = {
                aviso_id: this.numeroaviso,
                observaciones: this.observaciones,
                firma_cliente: this.firmacli,
                firma_empleado: this.firmaemp,
                listaarticulos: this.detallealbaran
            };
            var numero = 0;
            document.getElementById("app").style.cursor = "progress";
            axios
                .post("/api/albaran", registroAlbaran)
                .then(function(response) {
                    numero = response.data;
                    document.getElementById("app").style.cursor = "auto";
                });
            this.numeroAlbaran = numero;
            if (this.terminado) {
                axios.get("/api/finaliza/" + this.numeroaviso);
            }

            this.poneraCero();
        },

        imprimirElemento() {
            var elemento = document.querySelector("#imprimible");
            var ventana = window.open("", "PRINT", "height=1000,width=1400");
            ventana.document.write(
                "<html><head><title>" + document.title + "</title>"
            );
            ventana.document.write(
                '<link rel="stylesheet" href="/css/imprime.css">'
            );
            ventana.document.write(
                '<link rel="stylesheet" href="/css/app.css">'
            );
            ventana.document.write("</head><body >");
            ventana.document.write(elemento.innerHTML);
            ventana.document.write("</body></html>");
            ventana.document.close();
            ventana.focus();

            ventana.onload = function() {
                ventana.print();
                ventana.close();
            };
            return true;
        }
    }
};
</script>
<style>
.hidden {
    display: none;
}
.cabecera {
    width: 100%;
    height: 200px;
    margin-bottom: 20px;
}
.faldon {
    width: 100%;
    text-align: center;
}
.firmas {
    display: inline-flex;
    justify-content: space-around;
    flex-wrap: nowrap;
}
.firmas :first-child {
    align-self: start;
}
.poner {
    display: none;
}

@media (max-width: 750px) {
    .firmas {
        flex-wrap: wrap;
    }
}
</style>
