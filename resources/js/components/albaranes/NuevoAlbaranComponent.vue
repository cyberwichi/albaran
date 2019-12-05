<template>
    <div>
        <div class="card-header">
            <form
                class="sombra mb-3"
                v-on:submit.prevent="buscaaviso(numeroaviso)"
            >
                <div class="form-group p-3">
                    <label for="numeroaviso">Numero de aviso :</label>
                    <input
                        class="form-control col-12"
                        type="text"
                        name="numeroaviso"
                        v-model="numeroaviso"
                        autocomplete="off"
                        v-on:change="buscaaviso(numeroaviso)"
                    />
                    <button class="btn btn-flat" type="submit">
                        <img class src="/img/acceder.png" width="45px" alt />
                        Acceder
                    </button>
                </div>
            </form>
        </div>
        <div id="imprimible">
            <div>
                <img class="cabecera" src="/img/cabecera.jpeg" alt="" />
            </div>

            <h4>Albaran de Cliente</h4>
            <!-- cliente -->
            <div class="card-body">
                <div class="form-group">
                    <h5 class="card col-12 display-5">
                        <div>Aviso: {{ numeroaviso }}</div>
                        <div>Cliente: {{ cliente.Nombre }}</div>
                        <div>Direccion: {{ cliente.Direccion }}</div>
                        <div>Telefono: {{ cliente.Telefono }}</div>
                        <div>Nif: {{ cliente.Nif }}</div>
                        <div>Email: {{ cliente.Email }}</div>
                    </h5>
                </div>
            </div>

            <!-- detalle -->
            <div class="card sombra mt-4">
                <div class="card-header">
                    <h5 class>Detalle de Pedido</h5>
                </div>
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
                        <tr v-for="(linea, index) in detalles" :key="index">
                            <th scope="row">{{ linea.articulo_id }}</th>
                            <td>{{ linea.articulo_nombre }}</td>
                            <td>{{ linea.cantidad }}</td>
                            <td>{{ linea.precio }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="card sombra m-4">
                    <div>Comentarios:</div>
                    <strong>{{ comenta }}</strong>
                </div>
            </div>

            <!-- articulos entregados -->
            <div class="card sombra mt-4">
                <div class="card-header">
                    <h5 class>Articulos Entregados</h5>
                </div>
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
                            v-on:change="calcularTotal"
                            v-for="(linea2, index) in detallealbaran"
                            :key="index"
                        >
                            <th scope="row">{{ linea2.articulo_id }}</th>
                            <td>{{ linea2.articulonombre }}</td>
                            <td>
                                <input
                                    type="text"
                                    name
                                    id
                                    v-model="linea2.cantidad"
                                />
                            </td>
                            <td>{{ linea2.precio }}</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-secondary table-responsive p-1">
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

            <!-- observaciones -->
            <div class="card sombra mt-4">
                <div class="card-header">
                    <h4>Trabajo Finalizado</h4>
                    <input
                        class="form-control"
                        type="checkbox"
                        name="terminado"
                        value="Trabajo Finalizado"
                        v-model="terminado"
                    />
                </div>

                <div class="form-group p-3">
                    <h5>
                        <strong>Observaciones / Material Pendiente</strong>
                    </h5>
                    <textarea
                        v-model="observaciones"
                        class="form-control sombra"
                        name="observaciones"
                        cols="85"
                        rows="5"
                    ></textarea>
                </div>
            </div>

            <!-- maquinas -->
            <div class="card sombra mt-4">
                <div class="card-header">
                    <h4>Maquina</h4>
                </div>

                <div class="form-group p-3">
                    <h5>
                        <strong>Tipo de Maquina</strong>
                    </h5>
                    <autocompletarmaquina-component
                        @newmaquina="anadirmaquina($event)"
                        v-model="maquina"
                    ></autocompletarmaquina-component>
                </div>
                <table class="table table-responsive">
                    <thead class="text-center thead">
                        <tr>
                            <th scope="col">Maquina</th>
                            <th scope="col">Referencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(maq, index) in maquinas" :key="index">
                            <th scope="row">{{ maq.nombre }}</th>
                            <td>
                                {{ maq.referencia }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- firmas -->
            <div class="card mt-2">
                <div class="card-header">
                    <h4>Firmas</h4>
                </div>
                <div class="firmas">
                    <div class="text-center col-5 col-xl-4 sombra p-2 quitar">
                        Firma Cliente
                        <div id="cliente" class>
                            <div>
                                <img
                                    id="save"
                                    src="/img/firma.png"
                                    width="45px"
                                    v-on:click="ponerImagen(0)"
                                />
                            </div>
                            <canvas
                                id="signature-pad2"
                                class="signature-pad"
                                width="150"
                                height="150"
                            ></canvas>
                        </div>
                        <img
                            id="clear"
                            src="/img/Delete.png"
                            width="45px"
                            alt
                            v-on:click="quitarImagen(0)"
                        />
                    </div>
                    <h5 class="poner">Firma Cliente</h5>
                    <img class id="firmacli" alt />
                    <div class="text-center col-5 col-xl-4 sombra quitar p-2">
                        Firma Empleado
                        <div id="firmacliflag">
                            <div>
                                <img
                                    id="save2"
                                    src="/img/firma.png"
                                    width="45px"
                                    v-on:click="ponerImagen(1)"
                                />
                            </div>
                            <canvas
                                id="signature-pad"
                                class="signature-pad"
                                width="150"
                                height="150"
                            ></canvas>
                        </div>
                        <img
                            id="clear2"
                            src="/img/Delete.png"
                            width="45px"
                            alt
                            v-on:click="quitarImagen(1)"
                        />
                    </div>
                    <h5 class="poner">Firma Empleado</h5>
                    <img id="firmaemp" alt />
                </div>
            </div>
            <div class="faldon">
                <small>
                    C.I.F. B-72177827 - Telefono 956 59 125 -Pol. Ind. Puente
                    Hierro, Crta. de la Carraca 74 - 11100 San Fernando (Cádiz)
                    - gestion.aif@gmail.com - Movil: 685 696 156
                </small>
            </div>
        </div>
        <!-- botones guardar imprimir -->
        <div class="d-flex flex-row-reverse bd-highlight mr-5">
            <button
                class="btn btn-flat"
                v-on:click="guardaAlbaran"
                v-scroll-to="'#listado'"
            >
                <img src="img/Save.png" width="40px" alt />
            </button>
            <button class="btn btn-flat">
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
    props: ["numeroaviso"],
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
            maquinas: [],
            maquina:{}
        };
    },
    mounted() {
        this.firmaCliente(), this.firmaEmpleado();
        this.buscaaviso(this.numeroaviso);
    },

    methods: {
        anadirmaquina(maq) {
            let maquina={
                id: maq.id,
                referencia: maq.referencia,
                nombre: maq.nombre
            };           
            this.maquinas.push(maquina);
        },
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
            this.quitarImagen(1);
            this.quitarImagen(0);
            this.numeroaviso = "";
            this.maquinas=[];
            this.maquina={};
            this.$emit("salir");
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
                this.detallealbaran = [];
                this.detalles = response.data;
                this.detalles.forEach(element => {
                    var detallealb = {
                        avisoid: id,
                        articulo_id: element.articulo_id,
                        articulonombre: element.articulo_nombre,
                        cantidad: element.cantidad,
                        precio: element.precio
                    };
                    this.detallealbaran.push(detallealb);
                    document.getElementById("app").style.cursor = "auto";
                });
                this.calcularTotal();
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
        firmaEmpleado() {
            this.signaturePad2 = new SignaturePad(
                document.getElementById("signature-pad"),
                {
                    backgroundColor: "rgba(122, 122, 122, .2)",
                    penColor: "rgb(0, 0, 0)"
                }
            );
        },
        firmaCliente() {
            this.signaturePad = new SignaturePad(
                document.getElementById("signature-pad2"),
                {
                    backgroundColor: "rgba(122, 122, 122, .2)",
                    penColor: "rgb(0, 0, 0)"
                }
            );
        },
        ponerImagen(id) {
            if (!id) {
                var imgfirmacli = document.getElementById("firmacli");
                var nover = document.getElementById("cliente");
                this.firmacli = this.signaturePad.toDataURL("image/png");
                imgfirmacli.src = this.firmacli;
                nover.classList.toggle("hidden");
            } else {
                var imgfirmaemp = document.getElementById("firmaemp");
                var nover = document.getElementById("firmacliflag");
                this.firmaemp = this.signaturePad2.toDataURL("image/png");
                imgfirmaemp.src = this.signaturePad2.toDataURL("image/png");
                nover.classList.toggle("hidden");
            }
        },
        quitarImagen(id) {
            if (!id) {
                this.signaturePad.clear();
                var imgfirmacli = document.getElementById("firmacli");
                var nover = document.getElementById("cliente");
                imgfirmacli.src = "";
                if (nover.classList == "hidden") {
                    nover.classList.toggle("hidden");
                }
            } else {
                this.signaturePad2.clear();
                var imgfirmaemp = document.getElementById("firmaemp");
                var nover = document.getElementById("firmacliflag");
                imgfirmaemp.src = "";
                if (nover.classList == "hidden") {
                    nover.classList.toggle("hidden");
                }
            }
        },

        guardaAlbaran() {
            document.getElementById("app").style.cursor = "progress";
            var registroAlbaran = {
                aviso_id: this.numeroaviso,
                observaciones: this.observaciones,
                firma_cliente: this.firmacli,
                firma_empleado: this.firmaemp,
                listaarticulos: this.detallealbaran,
                listamaquinas: this.maquinas
            };
            console.log(registroAlbaran);
            var numero = 0;
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
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}
.poner {
    display: none;
}
</style>
