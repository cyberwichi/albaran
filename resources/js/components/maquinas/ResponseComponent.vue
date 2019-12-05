<template>
  <tr>
    <td>
      <p>{{ maquina.id}}</p>
      <input type="hidden" name="_token" :value="csrf" />
    </td>
    <td>
      <p v-if="!flageditar">{{maquina.nombre}}</p>
      <input v-else type="text" class="form-control" v-model="maquina.nombre" />
    </td>
    <td class="text-right">
      <p v-if="!flageditar">{{ maquina.comentarios}}</p>
      <textarea v-else class="form-control" v-model="maquina.comentarios" />
    </td>
    
    <td>
      <div class="botonesaccion d-flex justify-content-around">

        <img src="/img/Delete.png" width="25px" height="25px" alt="" v-if="!flageditar" v-on:click="borrarmaquina()">
        <img src="/img/Edit.png" width="25px" height="25px" alt="" v-if="!flageditar" v-on:click="editarmaquina()">
        <p v-if="flageditar">
          <img src="/img/Delete.png" width="25px" height="25px" alt=""  v-on:click="flageditar=false">
          Cancelar

        </p>
        <p v-if="flageditar">
<img src="/img/Save.png" width="20px" height="20px" alt="" v-on:click="guardarmaquina() ">
Guardar

        </p>
        
        
      </div>
    </td>
  </tr>
</template>

<script>
export default {
  props: ["maquina"],
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
    borrarmaquina() {
      this.$emit("delete");
    },
    editarmaquina() {
      this.flageditar = true;
      
    },
    guardarmaquina() {
      this.flageditar = false;
      this.$emit("guardar", this.maquina);
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
