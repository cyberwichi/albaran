<template>
  <div class>
    <div class="card-header">
      <h4>Albaran de Cliente</h4>
    </div>
    <div class="card-body">
      <form action>
        <nuevopedido-component class="mt-5 bg-light mb-3" @new="guardarpedido"></nuevopedido-component>

        <div class="form-group">
          <label for="observaciones">Trabajos Realizados</label>
          <textarea class="form-control" name="observaciones" id cols="90" rows="10"></textarea>
        </div>
      </form>
    </div>

    <div class="card-footer row">
      <div class="text-center col-10 col-xl-6">
        firma del cliente
        <div class>
          <canvas id="signature-pad" class="signature-pad" width="200" height="200"></canvas>
        </div>
        <button id="save">Firmar</button>
        <button id="clear">Borrar</button>
      </div>
      <div class="text-center col-10 col-xl-6">
        firma del empleado
        <div class>
          <canvas id="signature-pad2" class="signature-pad" width="200" height="200"></canvas>
        </div>
        <button id="save2">Firmar</button>
        <button id="clear2">Borrar</button>
      </div>
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
      linea: {}
    };
  },
  mounted() {
    this.firmaCliente(), this.firmaEmpleado();
  },

  methods: {
    firmaEmpleado() {
      var signaturePad2 = new SignaturePad(
        document.getElementById("signature-pad2"),
        {
          backgroundColor: "rgba(122, 122, 122, .2)",
          penColor: "rgb(0, 0, 0)"
        }
      );
      var saveButton = document.getElementById("save2");
      var cancelButton = document.getElementById("clear2");

      saveButton.addEventListener("click", function(event) {
        var data = signaturePad.toDataURL("image/png");

        // Send data to server instead...
        window.open(data);
      });

      cancelButton.addEventListener("click", function(event) {
        signaturePad2.clear();
      });
    },
    firmaCliente() {
      var signaturePad = new SignaturePad(
        document.getElementById("signature-pad"),
        {
          backgroundColor: "rgba(122, 122, 122, .2)",
          penColor: "rgb(0, 0, 0)"
        }
      );
      var saveButton = document.getElementById("save");
      var cancelButton = document.getElementById("clear");

      saveButton.addEventListener("click", function(event) {
        var data = signaturePad.toDataURL("image/png");

        // Send data to server instead...
        window.open(data);
      });

      cancelButton.addEventListener("click", function(event) {
        signaturePad.clear();
      });
    },

    añadirArticulo(linea) {
      this.pedido.push(linea);
      console.log(this.pedido);
    }
  }
};
</script>
<style >
.signature-pad {
  width: 200px;
  height: 200px;
}
</style>
