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
      <div class="m-5 float-right"><strong>Total :</strong> {{total}} €</div>

      <div class="m-5 float-right"><strong> 21% Iva :</strong>{{iva}} €</div>
      <div class="m-5 float-right"><strong>Subtotal :</strong> {{subtotal}} €</div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      nombreformulariopedido: "",
      articuloformulariopedido: "",
      cantidadformulariopedido: "",
      precioformulariopedido: "",
      vermas: false,
      pedido: [],
      linea: {},
      subtotal: 0,
      iva: 0,
      total: 0.0
    };
  },
  computed: {
    /* total: function() {
      subtotal = 0;
      pedido.forEach(element => {
        subtotal +=
          element.precioformulariopedido * element.cantidadformulariopedido;
      });
      return subtotal;
    } */
  },

  methods: {
    nuevoPedido() {
      this.$emit("new", this.pedido);
    },

    añadirArticulo(linea) {
      this.pedido.push(linea);
      this.iva = 0;

      this.subtotal = 0;
      this.total = 0;
      this.pedido.forEach(element => {
        this.subtotal += element.articuloPrecio * element.articuloCantidad;
        this.iva += element.articuloPrecio * 0.21;
      });
      this.subtotal = Number(this.subtotal.toFixed(2));
      this.iva = Number(this.iva.toFixed(2));
      this.total =this.subtotal+this.iva;
      this.total = Number(this.total.toFixed(2));
    }
  }
};
</script>
