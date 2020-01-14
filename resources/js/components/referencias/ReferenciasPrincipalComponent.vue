<template>
    <div>
        <div class="col-12 text-center h1 mb-3">
            <strong>REFERENCIAS</strong>
        </div>
        <div class="row d-flex align-items-end">
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('nuevo')"
                    :class="{ disabled: campo == 'nuevo' }"
                >
                    Nueva Referencia
                    <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
                </button>
            </div>
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('listado')"
                    :class="{ disabled: campo == 'listado' }"
                >
                    Listado Editar Borrar Referencias
                    <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
                </button>
            </div>
            
            <div class="col text-center mb-0 form-group">
                <form
                    v-on:submit.prevent="
                        vermasmethod('porreferencia');
                    "
                >
                    <input
                        type="text"
                        v-model="referenciaedita"
                        id=""
                        placeholder="Referencia:"
                        class=" form-control "
                        name="referenciaedita"
                        required
                    />
                    <button
                        type="submit"
                        class="btn btn-primary"
                        v-on:click="campo=''"
                    >
                        Ver
                    </button>
                </form>
            </div>
        </div>

        <referencias-component
            v-if="campo == 'listado'"
            class="mt-5 mb-3"
        ></referencias-component>
        <porreferencias-component
            v-if="campo == 'porreferencia'"
            :referencia="referenciaedita"
            class="mt-5 mb-3"
        ></porreferencias-component>
        <nuevoreferencias-component
            v-if="campo == 'nuevo'"
            class="mt-5 card bg-light mb-3"
            @new="guardarcontacto"
        ></nuevoreferencias-component>
    </div>
</template>

<script>
export default {
    data() {
        return {
            campo: "",
            referenciaedita: null,
            referencia: ""
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
