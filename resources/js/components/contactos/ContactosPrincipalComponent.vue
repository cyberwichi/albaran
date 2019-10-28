<template>
  <div>
    <header class="card">
      <div class="card-header text-center">
        <h4>Componente Menu Contactos</h4>
      </div>
      <div class="card-body row">
        <div class="col text-center">
          <button class="btn btn-primary" v-on:click="vermasmethod('listado')" :class="{disabled: campo=='listado'}">
            Listado Editar Borrar Contactos
            <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
          </button>
        </div>
        <div class="col text-center">
          <button class="btn btn-primary" v-on:click="vermasmethod('nuevo')" :class="{disabled: campo=='nuevo'}">
            Nuevo Contacto
            <!-- <img src="/img/chevron-bottom.svg" width="15px" alt="" aria-hidden="true"> -->
          </button>
        </div>
      </div>
    </header>
    <contactos-component v-if="campo=='listado'" class="mt-5"></contactos-component>
    <br />
    <nuevocontacto-component v-if="campo=='nuevo'" class="mt-5 card bg-light mb-3" @new="guardarcontacto"></nuevocontacto-component>
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
    guardarcontacto(){

    },

  }
};
</script>
<style scoped>
</style>
