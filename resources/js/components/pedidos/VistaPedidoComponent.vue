<template>
    <div class="card">
        <div class="card-header text-center">
            <h4>Aviso</h4>
        </div>

        <div id="imprimible" class="card-body">
            <!-- cliente -->
            <div class="card-body">
                <div class="form-group">
                    <h5 class="card col-12 display-5">
                        <div>Numero de aviso : {{ aviso[0].id }}</div>
                        <div>
                            Fecha:
                            {{
                                aviso[0].fechaPrevista
                                    | moment("DD/MM/YYYY, h:mm a")
                            }}
                        </div>
                        <div>Cliente: {{ aviso[0].tb_contacto.Nombre }}</div>
                        <div>
                            Direccion: {{ aviso[0].tb_contacto.Direccion }}
                        </div>
                        <div>Telefono: {{ aviso[0].tb_contacto.Telefono }}</div>
                        <div>Nif: {{ aviso[0].tb_contacto.Nif }}</div>
                        <div>Email: {{ aviso[0].tb_contacto.Email }}</div>
                    </h5>
                </div>
                <div class="form-group">
                    <h5 class="card col-12 display-5">
                        <div>Empleado asignado: {{ empleado.nombre }}</div>

                        <div>Telefono Empleado: {{ empleado.telefono }}</div>
                    </h5>
                </div>
            </div>
            <!-- detalle -->
            <div class="card sombra">
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
                            <tr v-for="(linea, index) in detalles"  :key="index">
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
        <div class="d-flex flex-row-reverse bd-highlight mr-5">
            <button class="btn btm-flat">
                <img
                    src="img/print.png"
                    v-on:click="imprimirElemento"
                    width="40px"
                />
                <img
                    class="m-3"
                    src="/img/albaran.png"
                    width="40px"
                    height="40px"
                    v-on:click="iralbaran()"
                />
                <img
                    class="m-3"
                    src="/img/Edit.png"
                    width="40px"
                    height="40px"
                    v-on:click="editaraviso(aviso[0].id)"
                />
            </button>
        </div>
        
    </div>
</template>

<script>
export default {
    props: ["numero"],
    data: function() {
        return {
            aviso: [],
            detalles: "",
            comenta: "",
            subtotal: "",
            iva: "",
            total: "",
            empleado: {
                nombre: "",
                telefono: ""
            }
        };
    },
    computed: {},
    created() {
        this.buscaaviso();
    },
    methods: {
        editaraviso(aviso) {            
            this.$emit("editar", aviso);
        },
        iralbaran() {
            this.$emit("albaran");
        },
        buscaaviso() {
            this.aviso = [];
            this.detalles = "";
            this.comenta = "";
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/avisos/" + this.numero)
                .then(response => {
                    this.aviso = response.data;
                    this.buscaDetalles(this.numero);
                    this.comenta = this.aviso[0].comentario;
                    if (this.aviso[0].empleado_id == null) {
                        this.empleado.nombre = "SIN ASIGNAR";
                    } else {
                        this.empleado.nombre = this.aviso[0].empleado.name;
                        this.empleado.telefono = this.aviso[0].empleado.telefono;
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
                this.calcularTotal();
                console.log(this.detalles);
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
