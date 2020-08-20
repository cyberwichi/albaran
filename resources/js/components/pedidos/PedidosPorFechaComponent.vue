<template>
    <div class>
        <div class="card bg-light mb-3">
            <div class="card-body  text-center">
                <div class="row">
                    <div class="col-3 m-auto">
                        <h4>
                            Desde:
                        </h4>
                        <datepicker
                            :inline="true"
                            v-model="datefrom"
                            name="dateFormfrom"
                            @input="searchAvisos"
                            :bootstrap-styling="true"
                        ></datepicker>
                    </div>
                    <div class="col-3 m-auto ">
                        <h4>
                            Tipo de Fecha:
                        </h4>
                        <v-select
                            placeholder="Selecciona un tipo de fecha a buscar"
                            :options="['Fecha de Creacion', 'Fecha Prevista']"
                            v-model="tipoFecha"
                            @input="searchAvisos"
                        ></v-select>
                    </div>

                    <div class="col-3 m-auto">
                        <h4>
                            Hasta:
                        </h4>
                        <datepicker
                            :inline="true"
                            v-model="dateto"
                            name="dateFormto"
                            @input="searchAvisos"
                        ></datepicker>
                    </div>
                </div>

                <nav aria-label="Page navigation example" class>
                    <ul class="pagination">
                        <li class="page-item">
                            <button
                                type="button"
                                class="page-link"
                                v-if="page != 1"
                                @click="page = 1"
                            >
                                <img
                                    class="mr-4"
                                    src="/img/inicio.ico"
                                    width="25px"
                                    height="25px"
                                />
                            </button>
                        </li>
                        <li class="page-item">
                            <button
                                type="button"
                                class="page-link"
                                v-if="page != 1"
                                @click="page--"
                            >
                                <img
                                    class="mr-4"
                                    src="/img/anterior.ico"
                                    width="25px"
                                    height="25px"
                                />
                            </button>
                        </li>
                        <li class="page-item">
                            <button
                                type="button"
                                class="page-link"
                                v-for="(pageNumber, index) in pages.slice(
                                    page - 1,
                                    page + 5
                                )"
                                @click="page = pageNumber"
                                :key="index"
                            >
                                {{ pageNumber }}
                            </button>
                        </li>
                        <li class="page-item">
                            <button
                                type="button"
                                @click="page++"
                                v-if="page < pages.length"
                                class="page-link"
                            >
                                <img
                                    class="mr-4"
                                    src="/img/siguiente.ico"
                                    width="25px"
                                    height="25px"
                                />
                            </button>
                        </li>
                        <li class="page-item ">
                            <button
                                type="button"
                                class="page-link"
                                v-if="page != pages.length"
                                @click="page = pages.length"
                            >
                                <img
                                    class="mr-4"
                                    src="/img/final.ico"
                                    width="25px"
                                    height="25px"
                                />
                            </button>
                        </li>
                    </ul>
                </nav>

                <div class="card table-responsive">
                    <table class="table">
                        <thead class="table-header card-header text-center">
                            <th>Id</th>
                            <th>Cliente</th>
                            <th class="">Empleado asignado</th>
                            <th class="">Fecha Creacion</th>
                            <th class="">Fecha Prevista</th>
                            <th class="">Comentario</th>
                            <th class="">Terminada</th>
                            <th class="d-flex justify-content-around">
                                <div>Borrar</div>
                                <div>Editar</div>
                                <div>Crear Parte</div>
                                <div>Detalle</div>
                            </th>
                        </thead>
                        <tbody class="card-footer sombra">
                            <responseaviso-component
                                v-for="(aviso, index) in articulosMostrados"
                                :key="aviso.id"
                                :aviso="aviso"
                                :empleados="empleados"
                                @delete="borrararticulo(aviso)"
                                @guardar="actualizararticulo(index, aviso)"
                                @albaran="veralbaran(aviso)"
                                @editar="editarAviso(aviso)"
                            ></responseaviso-component>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="modalBorrar"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Alerta de seguridad. Necesitamos su confirmacion
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body alert alert-danger">
                        Tenga en cuenta que si elimina un aviso eliminara los
                        albaranes emitidos a raiz de este aviso.
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Salir
                        </button>
                        <button
                            type="button"
                            class="btn btn-danger"
                            v-on:click="borraraviso"
                        >
                            Si soy consciente de ello Borrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="albaran"></div>
        <div class="card mt-3">
            <nuevoalbaran-component
                :key="reload"
                v-if="veralb"
                :numeroaviso="idaviso"
                class="mt-5 card bg-light mb-3"
                @salir="salir"
            ></nuevoalbaran-component>
        </div>
    </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";

var moment = require("moment");

export default {
    props: ["avisosempleado", "fecha"],
    data() {
        return {
            vm: this,
            page: 1,
            perPage: 5,
            pages: [],
            avisos: [],
            avisosbuscados: [],
            empleados: [],
            aviso: {},
            idaviso: 0,
            veralb: false,
            editaraviso: false,
            reload: true,
            datefrom: Date.now(),
            dateto: Date.now(),
            tipoFecha: ""
        };
    },
    components: {
        Datepicker
    },
    mounted() {
        if (this.avisosempleado != null) {
            this.avisosempleado.forEach(element => {
                this.avisos.push(element);
            });
        } else {
            this.getArticulos();
        }
        this.getEmpleadosActivos();
    },
    computed: {
        articulosMostrados() {
            return this.paginate(this.avisos);
        }
    },
    methods: {
        searchAvisos() {
            if (this.tipoFecha) {
                if (this.tipoFecha == "Fecha Prevista") {
                    this.avisosbuscados = this.avisos.filter(ax => {
                    return (
                        moment(Date.parse(ax.fechaPrevista)).format(
                            "yyyyMMDD"
                        ) >=
                            moment(Date.parse(this.datefrom)).format(
                                "yyyyMMDD"
                            ) &&
                        moment(Date.parse(ax.fechaPrevista)).format(
                            "yyyyMMDD"
                        ) <=
                            moment(Date.parse(this.dateto)).format(
                                "yyyyMMDD"
                            ) &&
                        ax.fechaPrevista
                    );
                });
                } else{
                    this.avisosbuscados = this.avisos.filter(ax => {
                    return (
                        moment(Date.parse(ax.created_at)).format(
                            "yyyyMMDD"
                        ) >=
                            moment(Date.parse(this.datefrom)).format(
                                "yyyyMMDD"
                            ) &&
                        moment(Date.parse(ax.created_at)).format(
                            "yyyyMMDD"
                        ) <=
                            moment(Date.parse(this.dateto)).format(
                                "yyyyMMDD"
                            )
                    );

                })}

                this.setPages();
                this.paginate();
            } else {
                alert("Selecciona un tipo de fecha a buscar, por favor.");
            }
        },

        salir() {
            this.veralb = false;
        },
        editarAviso(aviso) {
            this.editaraviso = true;
            this.idaviso = aviso.id;
            this.reload = !this.reload;
            this.$emit("salir", aviso);
            this.editaraviso = true;
        },
        borrararticulo(aviso) {
            this.aviso = aviso;
            $("#modalBorrar").modal("show");
        },
        veralbaran(dato) {
            this.reload = !this.reload;
            this.veralb = false;
            this.idaviso = dato.id;
            this.veralb = true;
        },
        borraraviso() {
            var vm = this;
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/albaranesporaviso/" + this.aviso.id)
                .then(response => {
                    var albaranesParaBorrar = response.data;
                    albaranesParaBorrar.forEach(element => {
                        axios.get("/api/delalbaran/" + element.id).then();
                    });
                })
                .catch(e => {
                    console.log(e);
                });

            axios
                .get("/api/delaviso/" + this.aviso.id)
                .then(response => {
                    function buscarregistro(objeto) {
                        return this.aviso.id == objeto.id;
                    }
                    var found = this.avisos.findIndex(buscarregistro);
                    this.avisos.splice(found, 1);
                    this.paginate();

                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                })
                .finally(() => {
                    $("#modalBorrar").modal("hide");

                    vm.$emit("salir");
                });
        },

        getArticulos() {
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/avisos")
                .then(response => {
                    this.avisos = response.data;
                    
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
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
        setPages() {
            this.pages=[];
            let numberOfPages = Math.ceil(
                this.avisosbuscados.length / this.perPage
            );
            for (let index = 1; index <= numberOfPages; index++) {
                this.pages.push(index);
            }
        },
        paginate() {
            let page = this.page;
            let perPage = this.perPage;
            let from = page * perPage - perPage;
            let to = page * perPage;

            return this.avisosbuscados.slice(from, to);
        },

        guardararticulo(articulo) {
            this.avisos.push(articulo);
            this.$emit("salir");
        },

        actualizararticulo(index, articulo) {
            document.getElementById("app").style.cursor = "progress";
            axios
                .put("/api/avisos/" + articulo.id, articulo)
                .then(response => {
                    this.avisos[index] = response.data;
                    this.paginate(this.avisos);
                    document.getElementById("app").style.cursor = "auto";
                    this.$emit("salir");
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
        }
    },

    watch: {
        avisosbuscados() {
           
            this.setPages();
            this.reload = !this.reload;
        }
    },

    filters: {
        trimWords(value) {
            return (
                value
                    .split(" ")
                    .splice(0, 20)
                    .join(" ") + "..."
            );
        }
    }
};
</script>
<style scoped>
button.page-link {
    display: inline-block;
    width: 60px;
    height: 60px;
}
button.page-link {
    font-size: 11px;
    color: #2f3031;
    font-weight: 300;
}
.offset {
    width: 500px !important;
    margin: 20px auto;
}
</style>
