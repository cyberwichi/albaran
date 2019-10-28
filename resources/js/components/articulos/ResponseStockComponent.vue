<template>
  <tr>
    <td>
      <p>{{ articuloNombre.AutoId}}</p>
    </td>
    <td>
      <p >{{articuloNombre.Nombre}}</p>
     
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
  props: ["articulo", "articuloNombre"],
  data() {
    return {
      
      
    
    };
  },
  
  methods: {
       
   
  },
  computed: {},
  watch: {},

  filters: {}
};
</script>
<style>

</style>
