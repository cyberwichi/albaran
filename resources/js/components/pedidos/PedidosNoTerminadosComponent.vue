<template>
    <div class>
        <div class="card bg-light mb-3">
            <div class="card-body">
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
                                @editar="editarAviso(aviso)"
                                @albaran="veralbaran(aviso)"
                            ></responseaviso-component>
                        </tbody>
                    </table>
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
export default {
    props: ["avisosempleado"],
    data() {
        return {
            page: 1,
            perPage: 5,
            pages: [],
            avisos: [],
            empleados: [],
            reload: 1,
            veralb: false,
            idaviso: ''
        };
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
    methods: {
         salir(){
            this.veralb=false
        },
        borrararticulo(aviso) {
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/delaviso/" + aviso.id)
                .then(response => {
                    function buscarregistro(objeto) {
                        return aviso.id == objeto.id;
                    }
                    var found = this.avisos.findIndex(buscarregistro);
                    this.avisos.splice(found, 1);
                    this.paginate(this.avisos);
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
        },
        veralbaran(dato) {
            this.reload = !this.reload;
            this.veralb = false;
            this.idaviso = dato.id;
            this.veralb = true;
        },

        getArticulos() {
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/avisosnoterminados")
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
            let numberOfPages = Math.ceil(this.avisos.length / this.perPage);
            for (let index = 1; index <= numberOfPages; index++) {
                this.pages.push(index);
            }
        }, 
        paginate(articulos) {
            let page = this.page;
            let perPage = this.perPage;
            let from = page * perPage - perPage;
            let to = page * perPage;

            return this.avisos.slice(from, to);
        },

        guardararticulo(articulo) {
            this.avisos.push(articulo);
        },

        actualizararticulo(index, articulo) {
            document.getElementById("app").style.cursor = "progress";
            axios
                .put("/api/avisos/" + articulo.id, articulo)
                .then(response => {
                    this.avisos[index] = response.data;
                    this.paginate(this.avisos);
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
        },
        editarAviso(aviso) {
            this.$emit("salir", aviso);
        }
    },
    computed: {
        articulosMostrados() {
            return this.paginate(this.avisos);
        }
    },
    watch: {
        avisos() {
            this.setPages();
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
