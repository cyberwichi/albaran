<template>
  <tr>
    <td>
      <p>{{ empleado.id}}</p>
    </td>
    <td>
      <p v-if="!flageditar">{{empleado.name}}</p>
      <input v-else type="text" class="form-control" v-model="empleado.name" />
    </td>
    <td class>
      <p v-if="!flageditar">{{ empleado.telefono}}</p>
      <input v-else type="text" class="form-control" v-model="empleado.telefono" />
    </td>
    <td class>
      <div class="btn" v-bind:class="[ empleado.activo ? terminado : noterminado]">
        <input v-show="flageditar" type="checkbox" v-model="empleado.activo" />
      </div>
    </td>
    <td class>
      <p v-if="!flageditar">{{ empleado.email}}</p>
      <input v-else type="email" class="form-control" v-model="empleado.email" />
    </td>
    <td>
      <div class="botonesaccion d-flex justify-content-around">
        <img
          class="mr-4"
          src="/img/Delete.png"
          width="40px"
          height="40px"
          v-if="!flageditar"
          v-on:click="borrarempleado()"
        />
        <img
          class="mr-4"
          src="/img/Edit.png"
          width="40px"
          height="40px"
          alt
          v-if="!flageditar"
          v-on:click="editarempleado()"
        />
        <p v-if="flageditar" v-on:click="flageditar=false">
          <img class="mr-4" src="/img/Delete.png" width="40px" height="40px" />
          Cancelar
        </p>

        <p v-if="flageditar" v-on:click="guardarempleado() ">
          <img class="mr-4" src="/img/Save.png" width="40px" height="40px" alt />
          Guardar
        </p>

        <img
          v-if="!flageditar"
          class="mr-4"
          src="/img/tareas.png"
          width="50px"
          height="50px"
          alt
          v-on:click="asignados(empleado.Id)"
          v-scroll-to="'#empleado'"
        />
      </div>
    </td>
  </tr>
</template>

<script>
export default {
  props: ["empleado"],
  data() {
    return {
      flageditar: false,
      noterminado: "bg-danger",
      terminado: "bg-success",
      terminado2: "hidden",
      terminado3: "bg-primary"
    };
  },
  mounted() {},
  methods: {
    borrarempleado() {
      this.$emit("delete", this.empleado);
    },
    editarempleado() {
      (this.flageditar = true), this.$emit("editar", this.empleado);
    },
    guardarempleado() {
      (this.flageditar = false), this.$emit("guardar", this.empleado);
    },
    asignados(id) {
      this.$emit("asignado", id);
    }
  },
  computed: {},
  watch: {},

  filters: {}
};
</script>
<style scoped>
</style>

