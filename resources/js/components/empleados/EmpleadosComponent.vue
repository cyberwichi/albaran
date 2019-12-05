<template>
    <div class>
        <div class="card">
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
                        <thead class="card-header">
                            <td>Id</td>
                            <td>Nombre</td>
                            <td>Telefono</td>
                            <td>Activo</td>
                            <td>Email</td>
                            <td class="d-flex justify-content-around">
                                <div class="mr-2">Borrar</div>
                                <div class="mr-2">Editar</div>
                                <div class="mr-2">
                                    Tareas
                                    <br />Asignadas
                                </div>
                            </td>
                        </thead>
                        <tbody class="card-footer sombra">
                            <responseempleado-component
                                v-for="(empleado, index) in empleadosMostrados"
                                :key="index"
                                :empleado="empleado"
                                @delete="borrarempleado(empleado)"
                                @guardar="actualizarempleado(empleado)"
                                @asignado="verAsignados(empleado)"
                            ></responseempleado-component>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <pedidos-component
            @salir="ireditarAviso($event)"
            v-if="flagasignado"
            :avisosempleado="asignados"
            class="mt-5"
        >
        </pedidos-component>
        <div id="empleado"></div>
        <editapedido-component
        :key="reload"
            v-if="campo == 'edita'"
            class="mt-5 card bg-light mb-3"
            @new="guardarpedido"
            :idaviso="idaviso"
            @salir="campo = ''"
        ></editapedido-component>
        <div  class="mb-5">
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            editionFlag: true,
            empleados: [],
            page: 1,
            perPage: 9,
            pages: [],
            empleado: {},
            asignados: [],
            flagasignado: false,
            idaviso: "",
            campo: "",
            reload:false
        };
    },
    mounted() {
        this.getEmpleados();
    },
    methods: {
        ireditarAviso(aviso) {
            this.reload = !this.reload;
            this.idaviso = aviso.id;
            this.campo = "edita";
        },
        borrarempleado(id) {
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/delempleados/" + id.id)
                .then(response => {
                    function buscarregistro(objeto) {
                        return id.id == objeto.id;
                    }
                    var found = this.empleados.findIndex(buscarregistro);
                    this.empleados.splice(found, 1);
                    paginate(this.empleados);
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
        },

        getEmpleados() {
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/empleados")
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
            let numberOfPages = Math.ceil(this.empleados.length / this.perPage);
            for (let index = 1; index <= numberOfPages; index++) {
                this.pages.push(index);
            }
        },
        paginate(empleados) {
            let page = this.page;
            let perPage = this.perPage;
            let from = page * perPage - perPage;
            let to = page * perPage;

            return empleados.slice(from, to);
        },

        editarempleado(index) {
            this.editionFlag = false;
        },
        guardarempleado(empleado) {
            this.empleados.push(empleado);
        },

        actualizarempleado(empleado) {
            document.getElementById("app").style.cursor = "progress";
            axios
                .put("/api/empleados/" + empleado.id, empleado)
                .then(response => {
                    this.empleados = response.data;
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
        },
        verAsignados(empleado) {
            this.flagasignado = false;
            document.getElementById("app").style.cursor = "progress";
            axios.get("/api/avisos/empleado/" + empleado.id).then(response => {
                this.asignados = response.data;
                this.flagasignado = true;
                document.getElementById("app").style.cursor = "auto";
            });
        }
    },
    computed: {
        empleadosMostrados() {
            return this.paginate(this.empleados);
        }
    },
    watch: {
        empleados() {
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
tr {
    padding: 15px;
}
td {
    padding: 5px;
}
</style>
