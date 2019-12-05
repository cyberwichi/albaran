<template>
  <tr>
    <td>
      <p>{{ articulo.Articulo}}</p>
    </td>
    <td>
      <p >{{articuloNombre}}</p>
     
    </td>
    <td class="text-right">
      <p >{{ articulo.Stock}}</p>
     
    </td>
    <td class="text-right">
      <p >{{ articulo.UdsPed}}</p>
     
    </td>
     <td class="text-right">
      <p >{{ articulo.UdsComp}}</p>
     
    </td>
    
  </tr>
</template>

<script>
export default {
  props: ["articulo"],
  data() {
    return {
      articuloNombre: ''
      
      
    
    };
  },
  mounted(){
    this.articNombre()
  },
  
  methods: {
    articNombre(){
      document.getElementById("app").style.cursor = "progress";
      axios
        .get("/api/articulos/"+this.articulo.Articulo)
        .then(response => {
          this.articuloNombre=response.data.Nombre;
          document.getElementById("app").style.cursor = "auto";
        })
        .catch(e =>{
           console.log(e);
           this.articuloNombre="Sin Nombre";
           document.getElementById("app").style.cursor = "auto";

           });
    },
       
   
  },
  computed: {},
  watch: {},

  filters: {}
};
</script>
<style>

</style>
