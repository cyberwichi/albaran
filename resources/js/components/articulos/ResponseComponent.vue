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
      <p v-if="!flageditar">{{ articulo.tb_stock_art.Stock}}</p>
      <input v-else type="text" class="form-control" v-model="articulo.tb_stock_art.Stock" />
    </td>
    <td class="text-right">
      <p v-if="!flageditar">{{ articulo.FechaAlta | moment("DD/MM/YYYY, h:mm a")}}</p>
      <input v-else type="datetime-local" class="form-control" v-model="articulo.FechaAlta" />
    </td>
    <td>
      <div class="botonesaccion d-flex justify-content-around">

        <img src="/img/Delete.png" width="25px" height="25px" alt="" v-if="!flageditar" v-on:click="borrararticulo()">
        <img src="/img/Edit.png" width="25px" height="25px" alt="" v-if="!flageditar" v-on:click="editararticulo()">
        <p v-if="flageditar">
          <img src="/img/Delete.png" width="25px" height="25px" alt=""  v-on:click="flageditar=false">
          Cancelar

        </p>
        <p v-if="flageditar">
<img src="/img/Save.png" width="20px" height="20px" alt="" v-on:click="guardararticulo() ">
Guardar

        </p>
        
        
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
      this.flageditar = true;
      
    },
    guardararticulo() {
      this.flageditar = false;
      this.$emit("guardar", this.articulo);
    }
  },
  computed: {},
  watch: {},

  filters: {}
};
</script>
<style>
.botonesaccion {
 display: inline;
}
</style>
