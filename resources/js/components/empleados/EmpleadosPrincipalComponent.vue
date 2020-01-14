<template>
    <div>
        <div class="col-12 text-center h1 mb-3">
            <strong>EMPLEADOS</strong>
        </div>
        <div class="row d-flex align-items-end">
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('nuevo')"
                    :class="{ disabled: campo == 'nuevo' }"
                >
                    Nuevo Empleado
                </button>
            </div>
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('listado')"
                    :class="{ disabled: campo == 'listado' }"
                >
                    Listado Editar Borrar Empleados
                </button>
            </div>
             <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('administradores')"
                    :class="{ disabled: campo == 'administradores' }"
                >
                    Administradores
                </button>
            </div>
            
        </div>
        <administradores-component
            v-if="campo == 'administradores'"
            class="mt-5 mb-3"
        ></administradores-component>


        <empleados-component
            v-if="campo == 'listado'"
            class="mt-5 mb-3"
        ></empleados-component>

        <nuevoempleado-component
            v-if="campo == 'nuevo'"
            class="mt-5 card bg-light mb-3"
            @new="guardarcontacto"
        ></nuevoempleado-component>
    </div>
</template>

<script>
export default {
    data() {
        return {
            campo: ""
        };
    },
    mounted() {},
    methods: {
        vermasmethod(campo) {
            this.campo = campo;
        },
        guardarcontacto() {}
    }
};
</script>
<style scoped></style>
