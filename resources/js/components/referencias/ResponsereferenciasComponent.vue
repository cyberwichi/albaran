<template>
  <tr>
    <td>
      <p v-if="!flageditar">{{contacto.referencia}}</p>
      <input v-else type="text" class="form-control" v-model="contacto.referencia" />
    </td>
    <td class>
      <p >{{ contacto.tb_articulo.Nombre}}</p>
      
    </td>
    
    <td>
      <div class="botonesaccion  d-flex justify-content-around">
        <img v-if="!flageditar" src="/img/Delete.png" width="40px" height="40px" alt v-on:click="borrarcontacto()" />
        <img
          src="/img/Edit.png"
          width="40px"
          height="40px"
          alt
          v-if="!flageditar"
          v-on:click="editarcontacto()"
        />
        <p v-if="flageditar">
          <img
            
            src="/img/Delete.png"
            width="40px"
            height="40px"
            alt
            v-on:click="flageditar=false"
          />
          Cancelar
        </p>
        <p v-if="flageditar">
          <img
            
            src="/img/Save.png"
            width="40px"
            height="40px"
            alt
            v-on:click="guardarcontacto() "
          />
          Guardar
        </p>
        
      </div>
    </td>
  </tr>
</template>

<script>
export default {
  props: ["contacto"],
  data() {
    return {
      flageditar: false
    };
  },
  mounted() {},
  methods: {
    borrarcontacto() {
      this.$emit("delete");
    },
    editarcontacto() {
      (this.flageditar = true), this.$emit("editar");
    },
    guardarcontacto() {
      (this.flageditar = false), this.$emit("guardar", this.contacto);
    }
  },
  computed: {},
  watch: {},

  filters: {}
};
</script>
