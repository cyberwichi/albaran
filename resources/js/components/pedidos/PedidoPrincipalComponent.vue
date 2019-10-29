<template>
  <div>
    <header class="card">
      <div class="card-header text-center">
        <h4>Componente Menu Pedidos</h4>
      </div>
      <div class="card-body row">
        <div class="col text-center">
          <button
            class="btn btn-primary"
            :class="{disabled: campo=='listado'}"
            v-on:click="vermasmethod('listado')"
          >Listado Editar Borrar Pedidos</button>
        </div>
        <div class="col text-center">
          <button
            class="btn btn-primary"
            :class="{disabled: campo=='nuevo'}"
            v-on:click="vermasmethod('nuevo')"
          >Nuevo Pedido</button>
        </div>
        <div class="col text-center">
          <button
            class="btn btn-primary"
            :class="{disabled: campo=='albaran'}"
            v-on:click="vermasmethod('albaran')"
          >Albaran</button>
        </div>
        <div class="col text-center">
          <button
            class="btn btn-primary"
            :class="{disabled: campo=='seguimiento'}"
            v-on:click="vermasmethod('seguimiento')"
          >Seguimiento Pedido</button>
        </div>
      </div>
    </header>
    <articulos-component v-if="campo=='listado'" class="mt-5"></articulos-component>
    <br />
    <nuevopedido-component
      v-if="campo=='nuevo'"
      class="mt-5 card bg-light mb-3"
      @new="guardarpedido"
    ></nuevopedido-component>
    <albaran-component v-if="campo=='albaran'" class="mt-5 card bg-light mb-3"></albaran-component>
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
    guardarpedido() {}
  }
};
</script>
<style scoped>
</style>
