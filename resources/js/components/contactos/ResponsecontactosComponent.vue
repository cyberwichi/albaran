<template>
  <tr>
    <td>
      <p>{{ contacto.Id}}</p>
    </td>
    <td>

      <p v-if="!flageditar">{{contacto.Nombre}}</p>
      <input v-else type="text" class="form-control"  v-model="contacto.Nombre"/>
    </td>
    <td class="">
      <p v-if="!flageditar">{{ contacto.Direccion}}</p>
       <input v-else type="text" class="form-control"  v-model="contacto.Direccion"/>
    </td>
    
    <td>
      <button type="button" class="btn btn-danger" v-on:click="borrarcontacto()">Borrar</button>
      <button
        v-if="!flageditar"
        type="button"
        class="btn btn-success"
        v-on:click="editarcontacto()"
      >editar</button>
      <button
        v-else
        type="button"
        class="btn btn-primary"
        v-on:click="guardarcontacto() "
      >Guardar</button>
    </td>
  </tr>
</template>

<script>
export default {
  props:['contacto'],
  data() {
    return {
      flageditar:false,
    
    };
  },
  mounted() {},
  methods: {
    borrarcontacto() {
      this.$emit('delete' )
    },
    editarcontacto(){
      this.flageditar=true,
      this.$emit('editar')
    },
   guardarcontacto(){
      this.flageditar=false,
      this.$emit('guardar', this.contacto)
    }
  },
  computed: {},
  watch: {},

  filters: {}
};
</script>
