<template>
    <div>
        <div class="col-12 text-center h2 mb-3">
            <strong>MAQUINAS</strong>
        </div>
        <div class="row d-flex align-items-end">
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    :class="{ disabled: campo == 'listado' }"
                    v-on:click="vermasmethod('listado')"
                >
                    Listado Editar Borrar Maquinas
                   
                </button>
            </div>
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('nuevo')"
                    :class="{ disabled: campo == 'nuevo' }"
                >
                    Nueva Maquina
                    
                </button>
            </div>
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('historial')"
                    :class="{ disabled: campo == 'historial' }"
                >
                    Historial por Referencia
                    
                </button>
            </div>
        </div>

        <maquinas-component
            v-if="campo == 'listado'"
            class="mt-5 mb-3"
        ></maquinas-component>

        <nuevomaquina-component
            v-if="campo == 'nuevo'"
            class="mt-5 card bg-light mb-3"
        ></nuevomaquina-component>

        <maquinashistorial-component
            v-if="campo == 'historial'"
            class="mt-5 mb-3"
        ></maquinashistorial-component>
       
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
        }
    }
};
</script>
<style scoped></style>
