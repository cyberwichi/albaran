<template>
  <tr>
    <td>
      <p>{{ albaran.id}}</p>
    </td>
    <td>
      <p >{{albaran.aviso_id}}</p>
     
    </td>
    <td class>
      <p >{{ albaran.created_at | moment("DD/MM/YYYY, h:mm a")}}</p>
      
    </td>
     <td class>
      <p >{{ albaran.observaciones}}</p>
     
    </td>
   

   
    <td>
      <div class="botonesaccion d-flex justify-content-around">
        <img
          class="mr-4"
          src="/img/Delete.png"
          width="40px"
          height="40px"
         
          v-on:click="borraralbaran()"
        />
        <img
          v-scroll-to="'#albaran'"
          class="mr-4"
          src="/img/eye2.png"
          width="40px"
          height="40px"
          alt
          
          v-on:click="editaralbaran()"
        />
        <a :href="'api/enviar/'+albaran.id">
          <img
          v-scroll-to="'#albaran'"
          class="mr-4"
          src="/img/sendmail.png"
          width="40px"
          height="40px"
        />
        </a>
      </div>
    </td>
  </tr>
</template>

<script>
export default {
  props: ["albaran"],
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
    borraralbaran() {
      this.$emit("delete", this.albaran);
    },
    editaralbaran() {
      console.log(this.albaran);
      (this.flageditar = true), this.$emit("ver", this.albaran);
    },
    guardaralbaran() {
      (this.flageditar = false), this.$emit("guardar", this.albaran);
    },
    
  },
  computed: {},
  watch: {},

  filters: {}
};
</script>
<style scoped>
</style>

