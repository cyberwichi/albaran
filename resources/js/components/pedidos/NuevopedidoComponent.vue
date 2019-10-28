<template>
  <div class="card">
    <div class="card-header">
      <h4>Nuevo Pedido</h4>
    </div>

    <div class="card-body">
      <form action v-on:submit.prevent="nuevoPedido()">
        <autocompletcontacto-component @newcontacto="añadircontacto" class="card bg-light mb-3"></autocompletcontacto-component>
        <autocompletararticulo-component
          @nuevaLinea="añadirArticulo($event)"
          v-model="linea"
          class="card bg-light mb-3"
          name="articulo"
        ></autocompletararticulo-component>
        <div class="text-center">
          <button type="submit" class="btn btn-primary mt-3">Guardar</button>
          <button type="button" class="btn btn-success mt-3">Crear albaran</button>
        </div>
      </form>
    </div>
    <div class="card-footer">
      <table class="table table-responsive">
        <thead class="text-center thead">
          <h5 class="text-center">Pedido</h5>
          <tr>
            <th scope="col">Id Articulo</th>
            <th scope="col">Articulo</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(linea,index) in pedido" :key="index">
            <th scope="row">{{linea.articuloId}}</th>
            <td>{{linea.articuloNombre}}</td>
            <td>{{linea.articuloCantidad}}</td>
            <td>{{linea.articuloPrecio}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: ["contactos", "articulos"],
  data: function() {
    return {
      nombreformulariopedido: "",
      articuloformulariopedido: "",
      cantidadformulariopedido: "",
      precioformulariopedido: "",
      vermas: false,
      pedido: [],
      linea: {}
    };
  },

  methods: {
    nuevoPedido() {
      /* let contacto={
        Id:'',
        Nombre:this.nombreformulario,
        Direccion:this.direccionformulario,
        
      }
      axios.post('/api/contactos', contacto).then(response=>contacto.Id=response.data.Id); */

      this.$emit("new", this.pedido);
    },
    vermasmethod() {
      this.vermas = !this.vermas;
    },
    añadirArticulo(linea) {
      this.pedido.push(linea);
      console.log(this.pedido);
    }
  }
};
</script>
