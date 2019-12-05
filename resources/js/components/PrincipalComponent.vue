<template>
    <div id="principal">
        <header class="card">
                     
            <div class="card-footer row d-flex align-items-center">
                 <a class=""  href="/">                    
                    <img  src="/img/logo.jpeg"  width="150px" height="150px" alt="">
                </a>  
                <div class="col text-center">
                    <button
                        class="btn btn-primary"
                        :class="{ disabled: campo == 'pedidos' }"
                        v-on:click="vermasmethod('pedidos')"
                    >
                        Avisos
                    </button>
                </div>
                <div class="col text-center">
                    <button
                        class="btn btn-primary"
                        :class="{ disabled: campo == 'albaranes' }"
                        v-on:click="vermasmethod('albaranes')"
                    >
                        Albaran
                    </button>
                </div>
                <div class="col text-center">
                    <button
                        class="btn btn-primary"
                        :class="{ disabled: campo == 'articulos' }"
                        v-on:click="vermasmethod('articulos')"
                    >
                        Articulos
                    </button>
                </div>
                <div class="col text-center">
                    <button
                        class="btn btn-primary"
                        :class="{ disabled: campo == 'clientes' }"
                        v-on:click="vermasmethod('clientes')"
                    >
                        Clientes
                    </button>
                </div>

                <div class="col text-center">
                    <button
                        class="btn btn-primary"
                        :class="{ disabled: campo == 'empleados' }"
                        v-on:click="vermasmethod('empleados')"
                    >
                        Empleados
                    </button>
                </div>
                <div class="col text-center">
                    <button
                        class="btn btn-primary"
                        :class="{ disabled: campo == 'maquinas' }"
                        v-on:click="vermasmethod('maquinas')"
                    >
                        Maquinas
                    </button>
                </div>
            </div>
            <albaranprincipal-component
            v-if="campo == 'albaranes'"
            class=""
        ></albaranprincipal-component>

        <articuloprincipal-component
            v-if="campo == 'articulos'"
            class=""
        ></articuloprincipal-component>

        <contactoprincipal-component
            v-if="campo == 'clientes'"
            class=""
        ></contactoprincipal-component>

        <pedidoprincipal-component
            v-if="campo == 'pedidos'"
            class=""
        ></pedidoprincipal-component>

        <empleadoprincipal-component
            v-if="campo == 'empleados'"
            class=""
        ></empleadoprincipal-component> 
         <maquinasprincipal-component
            v-if="campo == 'maquinas'"
            class=""
        ></maquinasprincipal-component> 
        </header>
        
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
<style scoped>
.cabecera {
    width: 100%;
    height: 200px;
    
    margin-bottom:20px;
}
</style>
