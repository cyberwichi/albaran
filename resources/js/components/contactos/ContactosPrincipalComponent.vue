<template>
    <div>
        <div class="col-12 text-center h2 mb-3">
            <strong>CLIENTES</strong>
        </div>
        <div class="row d-flex align-items-end">
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('listado')"
                    :class="{ disabled: campo == 'listado' }"
                >
                    Listado Editar Borrar Clientes
                    <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
                </button>
            </div>
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('nuevo')"
                    :class="{ disabled: campo == 'nuevo' }"
                >
                    Nuevo Contacto
                    <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
                </button>
            </div>
        </div>

        <contactos-component
            v-if="campo == 'listado'"
            class="mt-5 mb-3"
        ></contactos-component>

        <nuevocontacto-component
            v-if="campo == 'nuevo'"
            class="mt-5 card bg-light mb-3"
            @new="guardarcontacto"
        ></nuevocontacto-component>
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
