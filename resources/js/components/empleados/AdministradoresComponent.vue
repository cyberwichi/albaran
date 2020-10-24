<template>
    <div class>
        <div class="card">
            <div class="card-body">
                <div class="card table-responsive">
                    <table class="table">
                        <thead class="card-header">
                            <td>Id</td>
                            <td>Nombre</td>
                            <td>Autorizado</td>
                            <td>Email</td>
                            <td class="d-flex justify-content-around">
                                <div class="mr-2">Borrar</div>
                                <div class="mr-2">Editar</div>
                            </td>
                        </thead>
                        <tbody class="card-footer sombra">
                            <responseadministradores-component
                                v-for="(empleado, index) in empleados"
                                :key="index"
                                :empleado="empleado"
                                @delete="borrarempleado(empleado)"
                                @guardar="actualizarempleado(empleado)"
                            ></responseadministradores-component>

                            <!-- <responseempleado-component
                                v-for="(empleado, index) in empleadosMostrados"
                                :key="index"
                                :empleado="empleado"
                                @delete="borrarempleado(empleado)"
                                @guardar="actualizarempleado(empleado)"
                                @asignado="verAsignados(empleado)"
                            ></responseempleado-component> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { now } from "moment";
export default {
    data() {
        return {
            empleados: [],
            empleado: {},
            flageditar: [],
            noterminado: "bg-danger",
            terminado: "bg-success",
            terminado2: "hidden",
            terminado3: "bg-primary"
        };
    },
    mounted() {
        this.getEmpleados();
    },
    methods: {
        borrarempleado(id) {
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/deladministradores/" + id.id)
                .then(response => {
                    function buscarregistro(objeto) {
                        return id.id == objeto.id;
                    }
                    var found = this.empleados.findIndex(buscarregistro);
                    this.empleados.splice(found, 1);                   
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
                .get("/api/administradores")
                .then(response => {
                    this.empleados = response.data;
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
        },
        actualizarempleado(empleado) {
            

            document.getElementById("app").style.cursor = "progress";
            if (empleado.email_verified_at) {
                empleado.email_verified_at = empleado.created_at;
            } else {
                empleado.email_verified_at = null;
            }
         
            axios
                .post("/api/administradores/" + empleado.id, empleado)
                .then(response => {
                    this.empleados = response.data;
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
        }
    },
    computed: {
        
    },
    watch: {
       
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
