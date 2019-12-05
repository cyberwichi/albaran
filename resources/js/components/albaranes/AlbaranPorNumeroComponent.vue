<template>
  <form v-on:submit.prevent="buscaAlbaran(querySearch)" >
    <div class="form-group">
      <label for="input">Numero de Albaran</label>
      <input class="form-control col-12" type="text" v-model="querySearch" name="input" />
    </div>
    <button type="submit">
      <img class="mr-4" src="/img/eye2.png" width="25px" height="25px" />
    </button>
    <vistaalbaran-component v-if="flagver" :albaran="albaran[0]" ></vistaalbaran-component>
  </form>
</template>

<script>
export default {
  data() {
    return {
      querySearch: "",
      albaran: {},
      page: 1,
      perPage: 9,
      pages: [],
      flagver: false
    };
  },
  mounted() {},
  watch:{
   
  },
  methods: {
    buscaAlbaran(querySearch) {
      
     let vm=this;
      vm.albaran = {};
      vm.flagver = false;
      document.getElementById("app").style.cursor = "progress";
      axios.get("/api/albaranes/" + querySearch).then(response => {
        vm.albaran = response.data;
        document.getElementById("app").style.cursor = "auto";
        vm.flagver = true;
      });
    }
  }
};
</script>
<style scoped>
</style>
