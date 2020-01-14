<template>
    <div>
       <div class="col-12 text-center h1 mb-3">
            <strong>PARTES DE TRABAJO</strong>
        </div>
        <div class="row d-flex align-items-end">
             <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('nuevo')"
                    :class="{ disabled: campo == 'nuevo' }"
                >
                    Nuevo Parte de Trabajo
                </button>
            </div>
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    :class="{ disabled: campo == 'listado' }"
                    v-on:click="vermasmethod('listado')"
                >
                    Listado Partes <br />
                    <small>Ver Borrar</small>
                </button>
            </div>
            <div class="col text-cente form-group mb-0">
                <input
                    type="text"
                    v-model="numero"
                    id=""
                    placeholder="Numero:"
                    class=" form-control "
                />
                <button
                    class="btn btn-primary"
                    v-on:click="verparte"
                    v-scroll-to="'#pedido'"
                >
                    Ver Parte
                </button>
            </div>
            <div class="col text-center">
                <button
                    class="btn btn-primary"
                    v-on:click="vermasmethod('porcliente')"
                    :class="{ disabled: campo == 'porcliente' }"
                >
                    Partes por cliente
                </button>
            </div>
           
        </div>
                <b-alert
                :show="dismissCountDown"
                dismissible
                variant="success"
                @dismissed="dismissCountDown = 0"
                @dismiss-count-down="countDownChanged"
            >
                {{textmensaje}}
            </b-alert>
        <albaran-component
            v-if="campo == 'listado'"
            class="mt-5 mb-3"
        ></albaran-component>

        <nuevoalbaran-component
            v-if="campo == 'nuevo'"
            class="mt-5 card bg-light mb-3"
            @salir="mensaje($event)"
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
            campo: "",
            dismissSecs: 5,
            dismissCountDown: 0,
            textmensaje:'',
            numero:''
        };
    },
    mounted() {},
    methods: {
        vermasmethod(campo) {
            this.campo = campo;
        },        
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown;
        },
        showAlert() {
            this.dismissCountDown = this.dismissSecs;
        },
        mensaje(texto){
            this.textmensaje=texto;
            this.campo='';
            this.showAlert();
        },
        verparte(){

            window.open('albaranes/parte'+this.numero+'.pdf', '_blank','witdh=800,height=600' )
        }
    }
};
</script>
<style scoped></style>
