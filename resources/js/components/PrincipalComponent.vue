<template>
  <div id="principal">
    <header class="">
      <div class="card-footer row d-flex align-items-stretch">
        <div class="col text-center">
          <button
            class="btn btn-primary"
            :class="{ disabled: campo == 'pedidos' }"
            v-on:click="vermasmethod('pedidos')"
          >
            Avisos
          </button>
        </div>
        <div class="col text-center">
          <button
            class="btn btn-primary"
            :class="{ disabled: campo == 'albaranes' }"
            v-on:click="vermasmethod('albaranes')"
          >
            Partes de Trabajo
          </button>
        </div>
        <!-- <div class="col text-center">
                    <button
                        class="btn btn-primary"
                        :class="{ disabled: campo == 'articulos' }"
                        v-on:click="vermasmethod('articulos')"
                    >
                        Articulos
                    </button>
                </div> -->
        <div class="col text-center">
          <button
            class="btn btn-primary"
            :class="{ disabled: campo == 'maquinas' }"
            v-on:click="vermasmethod('maquinas')"
          >
            Maquinas por serie
          </button>
        </div>
        <div class="col text-center">
          <button
            class="btn btn-primary"
            :class="{ disabled: campo == 'configuracion' }"
            v-on:click="vermasmethod('configuracion')"
          >
            Configuracion
          </button>
        </div>
      </div>
      <albaranprincipal-component
        v-if="campo == 'albaranes'"
        class=""
      ></albaranprincipal-component>

      <articuloprincipal-component
        v-if="campo == 'articulos'"
        class=""
      ></articuloprincipal-component>

      <contactoprincipal-component
        v-if="campo == 'clientes'"
        class=""
      ></contactoprincipal-component>

      <pedidoprincipal-component
        v-if="campo == 'pedidos'"
        class=""
      ></pedidoprincipal-component>

      <empleadoprincipal-component
        v-if="campo == 'empleados'"
        class=""
      ></empleadoprincipal-component>

      <referenciasprincipal-component
        v-if="campo == 'referencias'"
        class=""
      ></referenciasprincipal-component>
      <literales-component v-if="campo == 'literales'"></literales-component>
       <maquinasprincipal-component
                v-if="campo == 'maquinasmenu'"
                class=""
            ></maquinasprincipal-component>

      <maquinashistorial-component
        v-if="campo == 'maquinas'"
        class="mt-5 mb-3"
      ></maquinashistorial-component>
    </header>
    <div v-if="campo == 'configuracion'">
      <div class="col-12 text-center h1 mb-3">
        <strong>CONFIGURACION</strong>
      </div>
      <div class="d-flex">
        <div class="text-center border m-1 w-50">
          <form action="" class="inline">
<!--             <div class="form-group">
              <h5>Direccion y Password de correo saliente</h5>
              <label for="correo">Direccion de correo</label>
              <input type="text" name="correo" v-model="correo" />
              <br />
              <label for="password">Password</label>
              <input type="password" name="password" v-model="password" />
              <div class="btn">
                <small>
                  <a
                    href="https://myaccount.google.com/u/0/lesssecureapps?pli=1"
                  >
                    Debe activar en su servicio de correo la opcion de envio
                    desde aplicaciones poco seguras. Por ejemplo si usa Gmail
                    utilice este enlace
                  </a></small
                >
              </div>
            </div> -->
            <div class="form-group">
              <label for="correoadmin"
                >Direccion de correo de administracion</label
              >
              <input type="text" name="correoadmin" v-model="correoAdmin" />
            </div>
            <div class="form-group">
              <label for="correotecnicos"
                >Direccion de correo de tecnicos</label
              >
              <input
                type="text"
                name="correotecnicos"
                v-model="correoTecnicos"
              />
            </div>
            <button
              v-on:click="guardaCorreo()"
              class="btn btn-primary"
              type="button"
            >
              Guardar
            </button>
          </form>
        </div>
        <div class="border m-1 w-50 d-flex flex-wrap align-items-center">
          <div class="col text-center">
            <button
              class="btn btn-primary"
              :class="{ disabled: campo == 'clientes' }"
              v-on:click="vermasmethod('clientes')"
            >
              Clientes
            </button>
          </div>

          <div class="col text-center">
            <button
              class="btn btn-primary"
              :class="{ disabled: campo == 'empleados' }"
              v-on:click="vermasmethod('empleados')"
            >
              Empleados
            </button>
          </div>
            <div class="col text-center">
            <button
              class="btn btn-primary"
              :class="{ disabled: campo == 'clientes' }"
              v-on:click="vermasmethod('maquinasmenu')"
            >
             Maquinas
            </button>
          </div>
          <div class="col text-center">
            <button
              class="btn btn-primary"
              :class="{ disabled: campo == 'literales' }"
              v-on:click="vermasmethod('literales')"
            >
              Literales Correo
            </button>
          </div>
          <div class="col text-center">
            <button
              class="btn btn-primary"
              :class="{ disabled: campo == 'referencias' }"
              v-on:click="vermasmethod('referencias')"
            >
              Referencias de Articulos
            </button>
          </div>
        </div>
      </div>
      <div class="text-center">
        <h3>Sincronizar Articulos Clientes Stock</h3>
        <button
          v-on:click="sincroniza"
          class="bg-gradient-info w-100 mx-auto text-dark display-5"
          type=""
        >
          Pulse para sincronizar las bases de datos
          <br />
          <div
            class="form-item bg-warning mt-1"
            v-for="(msg, index) in msgactualizando"
            :key="index"
          >
            <span v-if="index">{{ index }} de 3.-</span>
            <strong>
              {{ msg }}
            </strong>
          </div>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      campo: "",
      correo: "Buscando... ",
      password: "",
      correoAdmin: "",
      correoTecnicos: "",
      msgactualizando: ["Ok"],
    };
  },
  mounted() {},
  methods: {
    sincroniza() {
      this.msgactualizando.push(
        "Actualizando tabla de articulos y referencias"
      );
      axios.get("/api/antonio/").then((response) => {
        if (response.data == "Ok") {
          this.msgactualizando[1] += "..." + response.data;
          this.msgactualizando.push("Actualizando tabla de clientes");
          axios.get("/api/sincrocontactos/").then((response) => {
            if (response.data == "Ok") {
              this.msgactualizando[2] += "..." + response.data;
              this.msgactualizando.push("Actualizando tabla de stock");
              axios.get("/api/sincrostock").then((response) => {
                this.msgactualizando[3] += "..." + response.data;
                this.msgactualizando = [response.data];
              });
            }
          });
        }
      });
    },
    vermasmethod(campo) {
      this.campo = campo;
      if (campo == "configuracion") {
        axios.get("/api/config/").then((response) => {
          this.correo = response.data.email;
          this.password = response.data.password;
          this.correoAdmin = response.data.correo_admin;
          this.correoTecnicos = response.data.correo_tecnicos;
        });
      }
    },
    guardaCorreo() {
      console.log('reg');
      var reg = {
        correo: this.correo,
        password: this.password,
        correoAdmin: this.correoAdmin,
        correoTecnicos: this.correoTecnicos,
      };
      
      axios.post("/api/config", reg).then(response => {
             console.log(response.data)
            }); 
    },
  },
};
</script>
<style scoped>
.cabecera {
  width: 100%;
  height: 200px;
  margin-bottom: 20px;
}
</style>
