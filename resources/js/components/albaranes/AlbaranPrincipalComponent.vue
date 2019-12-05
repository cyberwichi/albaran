<template>
    <div>
       <div class="col-12 text-center h2 mb-3">
            <strong>ALBARANES</strong>
        </div>
        <div class="row d-flex align-items-end">
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    :class="{ disabled: campo == 'listado' }"
                    v-on:click="vermasmethod('listado')"
                >
                    Listado Albaranes <br />
                    <small>Ver Borrar</small>
                </button>
            </div>
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('porcliente')"
                    :class="{ disabled: campo == 'porcliente' }"
                >
                    Albaranes por cliente
                </button>
            </div>
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('nuevo')"
                    :class="{ disabled: campo == 'nuevo' }"
                >
                    Nuevo Albaran
                </button>
            </div>
        </div>
        <albaran-component
            v-if="campo == 'listado'"
            class="mt-5 mb-3"
        ></albaran-component>

        <nuevoalbaran-component
            v-if="campo == 'nuevo'"
            class="mt-5 card bg-light mb-3"
        ></nuevoalbaran-component>
        <albarancliente-component
            v-if="campo == 'porcliente'"
            class="mt-5 mb-3"
        ></albarancliente-component>
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
