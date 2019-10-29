<template>
  <tr>
    <td>
      <p>{{ contacto.Id}}</p>
    </td>
    <td>
      <p v-if="!flageditar">{{contacto.Nombre}}</p>
      <input v-else type="text" class="form-control" v-model="contacto.Nombre" />
    </td>
    <td class>
      <p v-if="!flageditar">{{ contacto.Direccion}}</p>
      <input v-else type="text" class="form-control" v-model="contacto.Direccion" />
    </td>

    <td>
      <div class="botonesaccion">
        <img src="/img/Delete.png" width="25px" height="25px" alt v-on:click="borrarcontacto()" />
        <img
          src="/img/Edit.png"
          width="25px"
          height="25px"
          alt
          v-if="!flageditar"
          v-on:click="editarcontacto()"
        />
        <img
          v-else
          src="/img/Save.png"
          width="20px"
          height="20px"
          alt
          v-on:click="guardarcontacto() "
        />
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
