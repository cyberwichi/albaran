<template>
    <div>
        <div class="col-12 text-center h2 mb-3">
            <strong>ARTICULOS</strong>
        </div>
        <div class="row d-flex align-items-end">
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    :class="{ disabled: campo == 'listado' }"
                    v-on:click="vermasmethod('listado')"
                >
                    Listado Editar Borrar Articulos
                    <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
                </button>
            </div>
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('nuevo')"
                    :class="{ disabled: campo == 'nuevo' }"
                >
                    Nuevo Articulo
                    <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
                </button>
            </div>
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('stockAdd')"
                    :class="{ disabled: campo == 'stockAdd' }"
                >
                    Recepcion Articulos
                    <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
                </button>
            </div>

            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('stockListado')"
                    :class="{ disabled: campo == 'stockListado' }"
                >
                    Listado Stock
                </button>
            </div>
        </div>

        <articulos-component
            v-if="campo == 'listado'"
            class="mt-5 mb-3"
        ></articulos-component>

        <nuevoarticulo-component
            v-if="campo == 'nuevo'"
            class="mt-5 card bg-light mb-3"
        ></nuevoarticulo-component>
        <stock-component
            v-if="campo == 'stockListado'"
            class="mt-5 card bg-light mb-3"
        ></stock-component>
        <recibearticulo-component
            v-if="campo == 'stockAdd'"
            class="mt-5 card bg-light mb-3"
        ></recibearticulo-component>
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
