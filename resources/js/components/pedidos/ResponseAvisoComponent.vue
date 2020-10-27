<template>
    <tr class="linea">
        <td class="text-center">
            <p>{{ aviso.id }}</p>
            <input type="hidden" name="_token" :value="csrf" />
        </td>
        <td class="text-center">
            <p v-if="!flageditar">{{ aviso.tb_contacto.Nombre }}</p>
        </td>
        <td class="text-center">
            <p v-if="!flageditar">{{ nombreEmpl }}</p>
<!-- 
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
                <div class="dropdown-menu " aria-labelledby="dropdownMenu2">
                    <button
                        class="dropdown-item w-100 text-white bg-danger text-center m-0 mb-3"
                        v-on:click="asignarEmpleado(null)"
                    >
                        No Asignar
                    </button>
                    <button
                        v-for="(empleado, index) in empleados"
                        v-bind:key="index"
                        class="dropdown-item text-center m-0 mb-3 "
                        type="button"
                        v-on:click="asignarEmpleado(empleado)"
                    >
                        {{ empleado.name }}
                    </button>
                </div>
            </div> -->
        </td>
        <td class="text-center">
            <p v-if="!flageditar">
                {{ aviso.created_at | moment("DD/MM/YYYY") }}
            </p>
            
        </td>
        <td class="text-center">
            <p v-if="!flageditar">
                {{ aviso.fechaPrevista | moment("DD/MM/YYYY, h:mm a") }}
            </p>
      <!--       <input
                v-else
                type="datetime-local"
                class="form-control"
                v-model="aviso.fechaPrevista"
            /> -->
        </td>
        <td class="text-center">
            <p v-if="!flageditar">{{ aviso.comentario }}</p>
    <!--         <input
                v-else
                type="text"
                class="form-control"
                v-model="aviso.comentario"
            /> -->
        </td>

        <td class="text-center">
            <div
                class="btn"
                v-bind:class="[aviso.terminada ? terminado : noterminado]"
            ></div>
        </td>
        <td>
            <div class="botonesaccion d-flex justify-content-around">
                <img
                    v-if="!flageditar"
                    class="m-3"
                    src="/img/Delete.png"
                    width="30px"
                    height="30px"
                    alt
                    v-on:click="borrararticulo()"
                />
                <img
                    class="m-3"
                    src="/img/Edit.png"
                    width="30px"
                    height="30px"
                    alt
                    v-if="!flageditar"
                    v-scroll-to="'#empleado'"
                    v-on:click="editararticulo()"
                />
                <img
                    class="m-3"
                    src="/img/albaran.png"
                    width="30px"
                    height="30px"
                    v-scroll-to="'#albaran'"
                    v-on:click="iralbaran()"
                />
                <img
                    class="m-3"
                    src="/img/detalle.png"
                    width="30px"
                    height="30px"
                    alt
                    v-if="!flageditar"
                    @click="showModal = true"
                />
 <!--                <p v-if="flageditar">
                    <img
                        class="m-3"
                        src="/img/Save.png"
                        width="20px"
                        height="20px"
                        alt
                        v-on:click="guardararticulo()"
                    />
                    Guardar
                </p> -->
               <!--  <p v-if="flageditar">
                    <img
                        class="m-3"
                        src="/img/Delete.png"
                        width="20px"
                        height="20px"
                        alt
                        v-on:click="flageditar = false"
                    />
                    Cancelar
                </p> -->
            </div>
        </td>

        <modal-component
            :key="showModal"
            v-if="showModal"
            @close="showModal = false"
            :avis="aviso"
            :nombre="nombre"
        ></modal-component>
    </tr>
</template>

<script>
var moment = require("moment");
export default {
    props: ["aviso", "empleados"],
    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            flageditar: false,
            showModal: false,
            nombre: "",
            noterminado: "bg-danger",
            terminado: "bg-success",
            nombreEmpl: ""
        };
    },
    mounted() {
        this.nombre = this.aviso.tb_contacto.Nombre;
        this.nombreEmpleado();
    },
    methods: {
        borrararticulo() {
            this.$emit("delete");
        },
        editararticulo() {
            this.$emit("editar", this.aviso);
            this.$emit("cierraListado");
        },
        guardararticulo() {
            this.flageditar = false;
            this.$emit("guardar", this.aviso);
            this.$emit("cierraListado");
        },
        nombreEmpleado() {
            this.nombreEmpl = "";
            var vm = this;
            if (this.aviso.empleado_id == null) {
                vm.nombreEmpl = "Sin Asignar";
            } else {
                /* axios
                    .get("/api/empleados/" + this.aviso.empleado_id)
                    .then(response => {
                        vm.nombreEmpl = response.data.name;
                    })
                    .catch(e => console.log(e)); */
                    this.nombreEmpl = this.aviso.empleado.name;
            }
        },

        asignarEmpleado(empleado) {
            if (empleado !== null) {
                this.nombreEmpl = empleado.name;
                this.aviso.empleado_id = empleado.id;
            } else {
                this.aviso.empleado_id = null;
                this.nombreEmpl = null;
            }
        },
        iralbaran() {
            this.$emit("albaran");
        }
    },
    computed: {},
    watch: {},

    filters: {}
};
</script>
<style>
.botonesaccion {
    display: inline;
}
.botonesaccion img {
    cursor: pointer;
}
.terminado {
    background-color: green;
}
.noterminado {
    background-color: red;
}
td {
    padding: 5px!important;
}
td p {
    margin-bottom: 0;
   
}
.linea td div img{

    vertical-align: middle;
}
</style>
