<template>
  <tr>
    <td>
      <p>{{ articulo.Id}}</p>
      <input type="hidden" name="_token" :value="csrf" />
    </td>
    <td>
      <p v-if="!flageditar">{{articulo.Nombre}}</p>
      <input v-else type="text" class="form-control" v-model="articulo.Nombre" />
    </td>
    <td class="text-right">
      <p v-if="!flageditar">{{ articulo.UPC}}</p>
      <input v-else type="text" class="form-control" v-model="articulo.UPC" />
    </td>
    <td class="text-right">
      <p v-if="!flageditar">{{ articulo.FechaAlta}}</p>
      <input v-else type="datetime-local" class="form-control" v-model="articulo.FechaAlta" />
    </td>
    <td>
      <div class="botonesaccion">
        <button type="button" class="btn btn-danger" v-on:click="borrararticulo()">X</button>
        <button
          v-if="!flageditar"
          type="button"
          class="btn btn-success"
          v-on:click="editararticulo()"
        >+</button>
        <button
          v-if="flageditar"
          type="button"
          class="btn btn-primary"
          v-on:click="guardararticulo() "
        >Guardar</button>
      </div>
    </td>
  </tr>
</template>

<script>
export default {
  props: ["articulo"],
  data() {
    return {
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      flageditar: false
    };
  },
  mounted() {},
  methods: {
    borrararticulo() {
      this.$emit("delete");
    },
    editararticulo() {
      (this.flageditar = true), this.$emit("editar");
    },
    guardararticulo() {
      (this.flageditar = false), this.$emit("guardar", this.articulo);
    }
  },
  computed: {},
  watch: {},

  filters: {}
};
</script>
<style>
.botonesaccion {
  display: flex;
  justify-content: space-between;
}
</style>
