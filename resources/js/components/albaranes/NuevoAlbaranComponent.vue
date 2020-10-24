<template>
  <div>
    <div class="card-header">
      <form class="sombra mb-3" v-on:submit.prevent="buscaaviso(numeroaviso)">
        <div class="form-group p-3">
          <label for="numeroaviso">Numero de Aviso:</label>
          <input
            class="form-control col-12"
            type="text"
            name="numeroaviso"
            v-model="numeroaviso"
            autocomplete="off"
            v-on:change="buscaaviso(numeroaviso)"
          />
          <button class="btn btn-flat" type="submit">
            <img class src="/img/acceder.png" width="45px" alt />
            Acceder
          </button>
        </div>
      </form>
    </div>
    <b-alert
      :show="dismissCountDown"
      dismissible
      variant="success"
      @dismissed="dismissCountDown = 0"
      @dismiss-count-down="countDownChanged"
    >
      {{ mensaje }}
    </b-alert>
    <div id="imprimible">
      <div>
        <img
          class="cabecera image-responsive"
          src="/img/cabecera.jpeg"
          alt=""
        />
      </div>

      <h4>Parte de Trabajo</h4>
      <!-- cliente -->

      <h5 class="card col-12 display-5">
        <div>Aviso: {{ numeroaviso }}</div>
        <div>Cliente: {{ cliente.Nombre }}</div>
        <div>Direccion: {{ cliente.Direccion }}</div>
        <div>Telefono: {{ cliente.Telefono }}</div>
        <div>Nif: {{ cliente.Nif }}</div>
        <div>Email: {{ cliente.Email }}</div>
      </h5>

      <!-- maquinas -->
      <div class="card sombra mt-1">
        <div class="card-header">
          <h4>Maquina</h4>
        </div>

        <div class="form-group p-3 quitar">
          <h5>
            <strong>Tipo de Maquina</strong>
          </h5>
          <autocompletarmaquina-component
            @newmaquina="anadirmaquina($event)"
            v-model="maquina"
          ></autocompletarmaquina-component>
        </div>
        <table class="table table-responsive">
          <thead class="text-center thead">
            <tr>
              <th scope="col">Maquina</th>
              <th scope="col">Numero Serie</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(maq, index) in maquinas" :key="index">
              <th scope="row">{{ maq.nombre }}</th>
              <td>
                {{ maq.referencia }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- detalle -->
      <div class="card sombra mt-1 quitar">
        <div class="card-header">
          <h5 class>Detalle de Pedido</h5>
        </div>
        <table class="table table-responsive">
          <thead class="text-center thead">
            <tr>
              <th scope="col" class="">Referencia</th>
              <th scope="col">Articulo</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Precio</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(linea, index) in detalles" :key="index">
              <th scope="row" class="">
                {{ linea.referencia }}
              </th>
              <td>{{ linea.articulo_nombre }}</td>
              <td>{{ linea.cantidad }}</td>
              <td>{{ linea.precio }}</td>
            </tr>
          </tbody>
        </table>

        <div class="card sombra m-4">
          <div>Comentarios:</div>
          <strong>{{ comenta }}</strong>
        </div>
      </div>

      <!-- articulos entregados -->
      <div class="card sombra mt-1">
        <div class="card-header">
          <h5 class>Articulos Entregados</h5>
          <b-button
            class="botoncillo btn btn-success"
            v-b-modal.modal-prevent-closing
            >Articulo No Registrado</b-button
          >
        </div>
        <table class="table table-responsive w-100">
          <thead class="text-center mx-auto thead">
            <tr>
              <th scope="col" class="">Referencia</th>
              <th scope="col">Articulo</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Precio</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-on:change="calcularTotal"
              v-for="(linea2, index) in detallealbaran"
              :key="index"
            >
              <th scope="row" class="">
                {{ linea2.referencia }}
              </th>
              <td class="w-50 text-center">{{ linea2.articulo_nombre }}</td>
              <td>
                <input
                  type="text"
                  :placeholder="linea2.cantidad"
                  v-model="linea2.cantidad"
                  class="peq"
                />
              </td>
              <td>
                <input
                  type="text"
                  :placeholder="linea2.precio"
                  v-model="linea2.precio"
                  class="peq"
                />
              </td>
              <td @click="eliminarArticulo(index)">X</td>
            </tr>
          </tbody>
        </table>
        <autocompletararticulo-component
          @nuevaLinea="añadirArticulo($event)"
          v-model="linea3"
          class="card bg-light mb-3 quitar"
          name="articulo"
        ></autocompletararticulo-component>

        <table class="table table-secondary table-responsive p-1">
          <tr class="d-flex justify-content-end bd-highlight">
            <td class="col-4 text-right sombra">
              <strong>Subtotal: {{ subtotal }}€</strong>
            </td>

            <td td class="col-4 text-right sombra">
              <strong>21%Iva: {{ iva }}€</strong>
            </td>

            <td td class="col-4 sombra text-right">
              <strong>Total: {{ total }}€</strong>
            </td>
          </tr>
        </table>
      </div>
      <b-modal
        id="modal-prevent-closing"
        ref="modal"
        title="Articulo No Registrado"
        size="xl"
        @ok="handleOk"
      >
        <form ref="form" @submit.stop.prevent="añadirArticulo(modalarticulo)">
          <b-form-group
            :state="nameState"
            label="Nombre"
            label-for="name-input"
            invalid-feedback="Introcuce el nombre del articulo"
          >
            <b-form-input
              id="name-input"
              v-model="modalarticulo.articuloNombre"
              :state="nameState"
              required
            ></b-form-input>
          </b-form-group>
          <b-form-group
            :state="upcState"
            label="Precio"
            label-for="upc-input"
            invalid-feedback="Introcuce el precio del articulo"
          >
            <b-form-input
              id="upc-input"
              v-model="modalarticulo.articuloPrecio"
              :state="upcState"
              required
            ></b-form-input>
          </b-form-group>
        </form>
      </b-modal>

      <!-- observaciones -->
      <div class="card sombra mt-1">
        <div class="card-header">
          <h4>Trabajo Finalizado</h4>
          <input
            class="form-control quitar"
            type="checkbox"
            name="terminado"
            value="Trabajo Finalizado"
            v-model="terminado"
            placeholder="terminado"
          />
          <label class="poner" v-if="terminado" for="terminado">SI</label>
          <label class="poner" v-else for="terminado">NO</label>
        </div>

        <div class="form-group p-3">
          <h5>
            <strong>Observaciones / Material Pendiente</strong>
          </h5>
          <textarea
            v-model="observaciones"
            class="form-control sombra"
            name="observaciones"
            cols="85"
            rows="3"
            :placeholder="observaciones"
          ></textarea>
        </div>
        <div class="form-group p-3">
          <h5>
            <strong>Trabajos Realizados</strong>
          </h5>
          <textarea
            v-model="trabajos"
            class="form-control sombra"
            name="trabajos"
            cols="85"
            rows="3"
          ></textarea>
        </div>
      </div>

      <!-- firmas -->
      <div class="card mt-1">
        <div class="card-header">
          <h4>Firmas</h4>
        </div>
        <div class="firmas">
          <div class="text-center col-5 col-xl-4 sombra p-2 quitar">
            Firma Cliente
            <div id="cliente" class>
              <div>
                <img
                  id="save"
                  src="/img/firma.png"
                  width="45px"
                  v-on:click="ponerImagen(0)"
                />
              </div>
              <canvas
                id="signature-pad2"
                class="signature-pad"
                width="150"
                height="150"
              ></canvas>
            </div>
            <img
              id="clear"
              src="/img/Delete.png"
              width="45px"
              alt
              v-on:click="quitarImagen(0)"
            />
          </div>
          <h5 class="poner">Firma Cliente</h5>
          <img class id="firmacli" alt />
          <div class="text-center col-5 col-xl-4 sombra quitar p-2">
            Firma Empleado
            <div id="firmacliflag">
              <div>
                <img
                  id="save2"
                  src="/img/firma.png"
                  width="45px"
                  v-on:click="ponerImagen(1)"
                />
              </div>
              <canvas
                id="signature-pad"
                class="signature-pad"
                width="150"
                height="150"
              ></canvas>
            </div>
            <img
              id="clear2"
              src="/img/Delete.png"
              width="45px"
              alt
              v-on:click="quitarImagen(1)"
            />
          </div>
          <h5 class="poner">Firma Empleado</h5>
          <img id="firmaemp" alt />
        </div>
      </div>

      <div class="faldon">
        <small>
          C.I.F. B-72177827 - Telefono 956 59 125 -Pol. Ind. Puente Hierro,
          Crta. de la Carraca 74 - 11100 San Fernando (Cádiz) -
          gestion.aif@gmail.com - Movil: 685 696 156
        </small>
      </div>
    </div>
    <!-- botones guardar imprimir -->
    <div class="d-flex flex-row-reverse bd-highlight mr-5">
      <button
        class="btn btn-flat"
        v-on:click="guardaAlbaran"
        v-scroll-to="'#listado'"
      >
        <img src="/img/Save.png" width="40px" />
        <img src="/img/print.png" width="40px" />
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["numeroaviso"],
  data: function () {
    return {
      aviso: {},
      detalles: [],
      detallealbaran: [],
      cliente: {},
      iva: 0,
      subtotal: 0,
      total: 0,
      observaciones: "",
      vermas: true,
      firmacli: "",
      firmaemp: "",
      numeroAlbaran: "",
      comenta: "",
      trabajos: "",
      signaturePad2: "",
      signaturePad: "",
      terminado: false,
      maquinas: [],
      maquina: {},
      linea3: "",
      dismissSecs: 5,
      dismissCountDown: 0,
      mensaje: "",
      name: "",
      upc: "",
      nameState: null,
      upcState: null,
      ref: "",
      articulo: {},
      modalarticulo: {
        articuloNombre: "",
        articuloPrecio: "",
        articuloCantidad: "",
      },
    };
  },
  watch: {},
  mounted() {
    this.firmaCliente(), this.firmaEmpleado();
    this.buscaaviso(this.numeroaviso);
  },

  methods: {
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.articulo = {
        articuloId: "0",
        articuloNombre: this.modalarticulo.articuloNombre,
        articuloPrecio: this.modalarticulo.articuloPrecio,
        articuloCantidad: "1",
        referencia: this.ref,
      };
      this.añadirArticulo(this.articulo);
      this.$nextTick(() => {
        this.$bvModal.hide("modal-prevent-closing");
        this.articulo = {};
      });
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.nameState = valid;
      this.upcState = valid;
      return valid;
    },
    añadirArticulo(datos) {
      console.log(datos);
      datos.articuloCantidad = datos.articuloCantidad.replace(",", ".");
      datos.articuloPrecio = datos.articuloPrecio.replace(",", ".");
      var detallealb = {
        avisoid: this.numeroaviso,
        articulo_id: datos.articuloId,
        articulo_nombre: datos.articuloNombre,
        cantidad: datos.articuloCantidad,
        precio: datos.articuloPrecio,
        referencia: datos.referencia,
      };
      this.detallealbaran.push(detallealb);
      this.calcularTotal();
    },
    eliminarArticulo(index) {
      this.detallealbaran.splice(index, 1);
      this.calcularTotal();
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    anadirmaquina(maq) {
      let maquina = {
        id: maq.id,
        referencia: maq.referencia,
        nombre: maq.nombre,
      };
      this.maquinas.push(maquina);
    },
    poneraCero() {
      this.aviso = {};
      this.detalles = [];
      this.detallealbaran = [];
      this.cliente = {};
      this.iva = 0;
      this.subtotal = 0;
      this.total = 0;
      this.observaciones = "";
      this.vermas = true;
      this.firmacli = "";
      this.firmaemp = "";
      this.numeroAlbaran = "";
      this.comenta = "";
      this.terminado = false;
      this.quitarImagen(1);
      this.quitarImagen(0);
      this.numeroaviso = "";
      this.maquinas = [];
      this.maquina = {};
      this.trabajos = "";
    },
    buscaaviso(numeroaviso) {
      this.aviso = "";
      this.detalles = "";
      this.cliente = "";
      this.comenta = "";
      document.getElementById("app").style.cursor = "progress";
      axios
        .get("/api/avisos/" + numeroaviso)
        .then((response) => {
          this.aviso = response.data;
          this.buscaDetalles(numeroaviso);
          this.buscaCliente(this.aviso[0].contacto_id);
          this.comenta = this.aviso[0].comentario;
          document.getElementById("app").style.cursor = "auto";
        })
        .catch((e) => {
          console.log(e);
          document.getElementById("app").style.cursor = "auto";
        });
    },
    buscaDetalles(id) {
      document.getElementById("app").style.cursor = "progress";
      this.detallealbaran = [];
      this.detalles = [];
      axios.get("/api/detalles/" + id).then((response) => {
        let detalles2 = response.data;

        detalles2.forEach((element, index) => {
          axios
            .get("/api/referenciaid/" + element.articulo_id)
            .then((response) => {
              var detallealb = {
                avisoid: id,
                articulo_id: element.articulo_id,
                articulo_nombre: element.articulo_nombre,
                cantidad: element.cantidad,
                precio: element.precio,
                referencia: response.data.referencia,
              };

              this.detallealbaran[index] = detallealb;
              this.detalles[index] = detallealb;

              document.getElementById("app").style.cursor = "auto";
              this.calcularTotal();
            });
        });
      });
    },
    calcularTotal() {
      this.iva = 0;
      this.subtotal = 0;
      this.total = 0;
      this.detallealbaran.forEach((element) => {
        element.precio = element.precio.replace(",", ".");
        element.cantidad = element.cantidad.replace(",", ".");
        this.subtotal += element.precio * element.cantidad;
      });
      this.subtotal = Number(this.subtotal.toFixed(2));
      this.iva = this.subtotal * 0.21;
      this.iva = Number(this.iva.toFixed(2));
      this.total = this.subtotal + this.iva;
      this.total = Number(this.total.toFixed(2));
    },
    buscaCliente(id) {
      document.getElementById("app").style.cursor = "progress";
      axios.get("/api/contactos/" + id).then((response) => {
        this.cliente = response.data;
        document.getElementById("app").style.cursor = "auto";
      });
    },
    firmaEmpleado() {
      this.signaturePad2 = new SignaturePad(
        document.getElementById("signature-pad"),
        {
          backgroundColor: "rgba(122, 122, 122, .2)",
          penColor: "rgb(0, 0, 0)",
        }
      );
    },
    firmaCliente() {
      this.signaturePad = new SignaturePad(
        document.getElementById("signature-pad2"),
        {
          backgroundColor: "rgba(122, 122, 122, .2)",
          penColor: "rgb(0, 0, 0)",
        }
      );
    },
    ponerImagen(id) {
      if (!id) {
        var imgfirmacli = document.getElementById("firmacli");
        var nover = document.getElementById("cliente");
        this.firmacli = this.signaturePad.toDataURL("image/png");
        imgfirmacli.src = this.firmacli;
        nover.classList.toggle("hidden");
      } else {
        var imgfirmaemp = document.getElementById("firmaemp");
        var nover = document.getElementById("firmacliflag");
        this.firmaemp = this.signaturePad2.toDataURL("image/png");
        imgfirmaemp.src = this.signaturePad2.toDataURL("image/png");
        nover.classList.toggle("hidden");
      }
    },
    quitarImagen(id) {
      if (!id) {
        this.signaturePad.clear();
        var imgfirmacli = document.getElementById("firmacli");
        var nover = document.getElementById("cliente");
        imgfirmacli.src = "";
        if (nover.classList == "hidden") {
          nover.classList.toggle("hidden");
        }
      } else {
        this.signaturePad2.clear();
        var imgfirmaemp = document.getElementById("firmaemp");
        var nover = document.getElementById("firmacliflag");
        imgfirmaemp.src = "";
        if (nover.classList == "hidden") {
          nover.classList.toggle("hidden");
        }
      }
    },

    guardaAlbaran() {
      document.getElementById("app").style.cursor = "progress";
      var registroAlbaran = {
        aviso_id: this.numeroaviso,
        observaciones: this.observaciones,
        firma_cliente: this.firmacli,
        firma_empleado: this.firmaemp,
        listaarticulos: this.detallealbaran,
        listamaquinas: this.maquinas,
        trabajos: this.trabajos,
      };

      var numero = 0;
      if (this.terminado) {
        axios.get("/api/finaliza/" + this.numeroaviso).then(() => {
          axios.post("/api/albaran", registroAlbaran).then((response) => {
            numero = response.data;
            document.getElementById("app").style.cursor = "auto";
            this.numeroAlbaran = numero;
            window.open(
              "albaranes/parte" + numero + ".pdf",
              "_blank",
              "width=800,height=600"
            );
            this.poneraCero();
            this.$emit("salir", "Parte guardado correctamente");
          });
        });
      } else {
        axios.post("/api/albaran", registroAlbaran).then((response) => {
          numero = response.data;
          document.getElementById("app").style.cursor = "auto";
          this.numeroAlbaran = numero;

          window.open(
            "albaranes/parte" + numero + ".pdf",
            "_blank",
            "width=800,height=600"
          );
          this.poneraCero();
          this.$emit("salir", "Parte guardado correctamente");
        });
      }
    },

    imprimirElemento() {
      var elemento = document.querySelector("#imprimible");
      var ventana = window.open("", "PRINT", "height=1000,width=1400");
      ventana.document.write(
        "<html><head><title>" + document.title + "</title>"
      );
      ventana.document.write('<link rel="stylesheet" href="/css/imprime.css">');
      ventana.document.write('<link rel="stylesheet" href="/css/app.css">');
      ventana.document.write("</head><body >");
      ventana.document.write(elemento.innerHTML);
      ventana.document.write("</body></html>");
      ventana.document.close();
      ventana.focus();

      ventana.onload = function () {
        ventana.print();
        ventana.close();
      };
      return true;
    },
  },
};
</script>
<style>
.hidden {
  display: none;
}
.cabecera {
  width: 100%;
  height: 200px;
  margin-bottom: 20px;
}
.faldon {
  width: 100%;
  text-align: center;
}
.firmas {
  display: flex;
  width: 90%;
  justify-content: space-around;
  flex-wrap: wrap;
  margin: auto;
}
.poner {
  display: none;
}
@media (max-width: 950px) {
  .peq {
    width: 50px;
  }
  .med {
    width: 100px;
  }
  .ocul {
    display: none;
  }
}
</style>
