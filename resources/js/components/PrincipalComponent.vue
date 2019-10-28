<template>
  <div class>
    <header class="card">
      <div class="card-header text-center">
        <i class="fas fa-frog icon"></i>
        <h2>Menu Principal </h2>
         
      </div>
      <div class="card-body row">
        <div class="col text-center">
          <button
            class="btn btn-primary"
            :class="{disabled: campo=='articulos'}"
            v-on:click="vermasmethod('articulos')"
          >
            Articulos
            <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
          </button>
        </div>
        <div class="col text-center">
          <button class="btn btn-primary" :class="{disabled: campo=='clientes'}" v-on:click="vermasmethod('clientes')">
            Clientes
            <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
          </button>
        </div>
        <div class="col text-center">
          <button class="btn btn-primary" :class="{disabled: campo=='pedidos'}" v-on:click="vermasmethod('pedidos')">
            Pedidos
            <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
          </button>
        </div>
      </div>
    </header>
    <articuloprincipal-component v-if="campo=='articulos'" class="mt-5"></articuloprincipal-component>
    <br />
    <contactoprincipal-component v-if="campo=='clientes'" class="mt-5"></contactoprincipal-component>
    <br />
    <pedidoprincipal-component v-if="campo=='pedidos'" class="mt-5"></pedidoprincipal-component>
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
</style>
