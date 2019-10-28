<template>
  <div >
    <header class="card">
      <div class="card-header text-center">
        <h4>Menu Articulos</h4>
      </div>
      <div class="card-footer row">
        <div class="col text-center">
          <button class="btn btn-primary" :class="{disabled: campo=='listado'}" v-on:click="vermasmethod('listado')">
            Listado Editar Borrar Articulos
            <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
          </button>
        </div>
        <div class="col text-center">
          <button class="btn btn-primary" v-on:click="vermasmethod('nuevo')" :class="{disabled: campo=='nuevo'}">
            Nuevo Articulo
            <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
          </button>
        </div>
        <div class="col text-center">
          <button class="btn btn-primary" v-on:click="vermasmethod('stockAdd')" :class="{disabled: campo=='stockAdd'}">
            Recepcion Articulos
            <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
          </button>
        </div>
        <div class="col text-center">
          <button class="btn btn-primary" v-on:click="vermasmethod('stockLess')" :class="{disabled: campo=='stockLess'}">
            Venta Articulo
            <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
          </button>
        </div>
        <div class="col text-center">
          <button class="btn btn-primary" v-on:click="vermasmethod('stockListado')" :class="{disabled: campo=='stockListado'}">
            Listado Stock
            <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
          </button>
        </div>
      </div>
    </header>
    <articulos-component v-if="campo=='listado'" class="mt-5"></articulos-component>
    <br />
    <nuevoarticulo-component
      v-if="campo=='nuevo'"
      class="mt-5 card bg-light mb-3"
      @new="guardararticulo"
    ></nuevoarticulo-component>
    <stock-component  v-if="campo=='stockListado'"
      class="mt-5 card bg-light mb-3"></stock-component>
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
    guardararticulo() {}
  }
};
</script>
<style scoped>
</style>
