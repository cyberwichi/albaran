<template>
  <div>
    <div class="card">
      <div class="card-header text-center">
        <h4>Aviso</h4>
        <h5>
          Id Aviso:
          <strong>{{ idaviso }}</strong>
        </h5>
      </div>

      <div class="card-body">
        <form>
          <label for="myChoice"
            >¿Valorar los partes creados por este aviso?</label
          >
          SI
          <input
            id="default_yes"
            name="myChoice"
            value="1"
            type="radio"
            v-model="valorar"
            required
            selected
          />
          NO
          <input
            id="default_no"
            name="myChoice"
            value="0"
            type="radio"
            v-model="valorar"
            required
          />
          <br />
          <label for="myChoice2">¿Cliente franquiciado?</label>
          SI
          <input
            id="default_yes"
            name="myChoice2"
            value="1"
            type="radio"
            v-model="franquiciado"
            required
          />
          NO
          <input
            id="default_no"
            name="myChoice2"
            value="0"
            type="radio"
            v-model="franquiciado"
            required
            selected
          />
          <div>
            <label for="correo">Correo Alternativo del Cliente</label>
            <input type="email" name="correo" v-model="correo" id="" />
          </div>

          <div>
            <h4 v-if="!flageditar" v-on:click="flageditar = !flageditar">
              Empleado asignado: {{ empleado.name }}
            </h4>
            <div v-else>
              <div class="dropdown">
                <label>Asignar empleado</label>
                <button
                  class="btn btn-secondary dropdown-toggle"
                  type="button"
                  id="dropdownMenu2"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  {{ empleado.name }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                  <button
                    class="dropdown-item w-100 text-white bg-danger text-center m-0 mb-3"
                    v-on:click.prevent="
                      asignarEmpleado(null);
                      flageditar = !flageditar;
                    "
                  >
                    No Asignar
                  </button>
                  <button
                    v-for="(empleado, index) in empleados"
                    v-bind:key="index"
                    class="dropdown-item text-center m-0 mb-3"
                    type="button"
                    v-on:click="
                      asignarEmpleado(empleado);
                      flageditar = !flageditar;
                    "
                  >
                    {{ empleado.name }}
                  </button>
                </div>
              </div>
            </div>
          </div>

          <autocompletcontacto-component
            :contactoexterno="contacto"
            @newcontacto="añadircontacto($event)"
            class="card bg-light mb-3"
          ></autocompletcontacto-component>
          <div class="card form-group sombra p-2">
            <label class="col-12" for="fechaPrevistaform"
              >Fecha y Hora Prevista Realizacion</label
            >
            <input
              class="form-control col-12"
              type="datetime-local"
              v-model="fechaprevista"
              name="fechaPrevistaform"
              id="fechaPrevistaform"
            />
          </div>
          <div class="card form-group sombra p-2">
            <label class="col-12" for="observaciones">Observaciones</label>
            <textarea
              class="form-control col-12"
              name="observaciones"
              v-model="observaciones"
              cols="80"
              rows="10"
            ></textarea>
          </div>

          <autocompletararticulo-component
            @nuevaLinea="añadirArticulo($event)"
            v-model="linea"
            class="card bg-light mb-3"
            name="articulo"
          ></autocompletararticulo-component>
          <div class="text-center">
            <button
              type="button"
              class="btn btn-flat m-3"
              v-on:click="nuevoPedido"
            >
              <img
                src="/img/Save.png"
                width="50px"
                data-toggle="tooltip"
                data-placement="top"
                title="Guardar Aviso"
              />
            </button>
          </div>
        </form>
      </div>
      <div class="card-footer">
        <div class="table-responsive card sombra">
          <table class="table">
            <thead class="text-center thead">
              <h5 class="text-center">Pedido</h5>
              <tr>
                <th scope="col">Ref. Articulo</th>
                <th scope="col">Articulo</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Precio</th>
                <th scope="col">Eliminar</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(linea, index) in pedido" :key="index">
                <th scope="row">{{ linea.referencia }}</th>
                <td>{{ linea.articuloNombre }}</td>
                <td>{{ linea.articuloCantidad }}</td>
                <td>{{ linea.articuloPrecio }}</td>
                <td>
                  <img
                    class="m-3 vertical-aling"
                    v-on:click="borrarArticulo(index)"
                    src="/img/Delete.png"
                    width="25px"
                    height="25px"
                    alt
                  />
                </td>
              </tr>
            </tbody>
          </table>
          <div class="float-right mr-2">
            <div class="text-right">
              <strong>Subtotal :</strong>
              {{ subtotal }} €
            </div>
            <div class="text-right">
              <strong>21% Iva :</strong>
              {{ iva }} €
            </div>
            <div class="mt-2 mb-5 text-right">
              <strong>Total :</strong>
              {{ total }} €
            </div>
          </div>
        </div>
      </div>
      <div class="card mt-3">
        <nuevoalbaran-component
          v-if="veralbaran"
          :numeroaviso="idaviso"
          class="mt-5 card bg-light mb-3"
        ></nuevoalbaran-component>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      valorar: "1",
      vermas: false,
      pedido: [],
      linea: {},
      contacto: {},
      subtotal: 0,
      iva: 0,
      total: 0.0,
      idavisoflag: true,
      fechaprevista: "",
      observaciones: "",
      veralbaran: false,
      idaviso: 0,
      flageditar: true,
      empleados: [],
      empleado: {
        empleado_id: "",
        name: "Sin Asignar",
      },
      franquiciado: 0,
      correo: "",
    };
  },
  created() {
    this.getEmpleadosActivos();
  },
  computed: {},

  methods: {
    buscaDatos() {
      //cargar los datos
      /* if (this.idaviso) {
        document.getElementById("app").style.cursor = "progress";
        axios
          .get("/api/avisos/" + this.idaviso)
          .then((response) => {
            this.aviso = response.data;

            this.buscaDetalles(this.idaviso);
           
            this.comenta = this.aviso[0].comentario;
            this.contacto = this.aviso[0].tb_contacto;
            this.fechaprevista = this.aviso[0].fechaPrevista;
            this.observaciones = "this.aviso[0].comentario";
            document.getElementById("app").style.cursor = "auto";
          })
          .catch((e) => {
            console.log(e);
            document.getElementById("app").style.cursor = "auto";
          });
      }
   */
    },
    asignarEmpleado(empleadoaux) {
      if (empleadoaux !== null) {
        this.empleado.name = empleadoaux.name;
        this.empleado.empleado_id = empleadoaux.id;
      } else {
        // this.empleado.empleado_id = null;
        // this.empleado.name = 'Sin Asignar';
        this.flageditar = false;
      }
    },
    getEmpleadosActivos() {
      document.getElementById("app").style.cursor = "progress";
      axios
        .get("/api/activos")
        .then((response) => {
          this.empleados = response.data;
          document.getElementById("app").style.cursor = "auto";
        })
        .catch((e) => {
          console.log(e);
          document.getElementById("app").style.cursor = "auto";
        });
    },
    nuevoPedidoyalbaran() {
      this.nuevoPedido();
      this.veralbaran = true;
    },
    nuevoPedido() {
      let data = {
        id: this.idaviso,
        clientid: this.contacto.Id,
        fechaPrevista: this.fechaprevista,
        listaarticulos: this.pedido,
        observaciones: this.observaciones,
        valorar: this.valorar,
        empleado: this.empleado.empleado_id,
        franquiciado: this.franquiciado,
        correo: this.correo
      };

      document.getElementById("app").style.cursor = "progress";
      axios.post("/api/aviso", data).then((response) => {
        this.idaviso = response.data;
        this.$emit("salir");
        document.getElementById("app").style.cursor = "auto";
      });
    },
    buscaDetalles(id) {
      document.getElementById("app").style.cursor = "progress";
      axios.get("/api/detalles/" + id).then((response) => {
        this.pedido = response.data;

        this.actualizaTotal();
      });
    },
    añadircontacto(contacto) {
      this.contacto = contacto;
    },
    actualizaTotal() {
      this.iva = 0;
      this.subtotal = 0;
      this.total = 0;
      this.pedido.forEach((element) => {
        this.subtotal += element.articuloPrecio * element.articuloCantidad;
      });
      this.subtotal = Number(this.subtotal.toFixed(2));
      this.iva = this.subtotal * 0.21;
      this.iva = Number(this.iva.toFixed(2));
      this.total = this.subtotal + this.iva;
      this.total = Number(this.total.toFixed(2));
    },

    añadirArticulo(linea) {
      this.pedido.push(linea);
      this.actualizaTotal();
    },
    borrarArticulo(index) {
      this.pedido.splice(index, 1);
      this.actualizaTotal();
    },
  },
};
</script>
