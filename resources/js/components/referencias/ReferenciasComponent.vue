<template>
    <div class>
      <b-alert
                :show="dismissCountDown"
                dismissible
                variant="success"
                @dismissed="dismissCountDown = 0"
            >
                {{mensaje}}
            </b-alert>
        <div class="card">
            <div class="card-body">
                <nav aria-label="Page navigation example" class>
                    <ul class="pagination">
                        <li class="page-item" :pages="pages">
                            <button
                                type="button"
                                class="page-link"
                                v-if="page != 1"
                                @click="page = 1"
                            >
                                <img
                                    class="mr-4"
                                    src="/img/inicio.ico"
                                    width="25px"
                                    height="25px"
                                />
                            </button>
                        </li>
                        <li class="page-item">
                            <button
                                type="button"
                                class="page-link"
                                v-if="page != 1"
                                @click="page--"
                            >
                                <img
                                    class="mr-4"
                                    src="/img/anterior.ico"
                                    width="25px"
                                    height="25px"
                                />
                            </button>
                        </li>
                        <li class="page-item">
                            <button
                                type="button"
                                class="page-link"
                                v-for="(pageNumber, index) in pages.slice(
                                    page - 1,
                                    page + 5
                                )"
                                @click="page = pageNumber"
                                :key="index"
                            >
                                {{ pageNumber }}
                            </button>
                        </li>
                        <li class="page-item">
                            <button
                                type="button"
                                @click="page++"
                                v-if="page < pages.length"
                                class="page-link"
                            >
                                <img
                                    class="mr-4"
                                    src="/img/siguiente.ico"
                                    width="25px"
                                    height="25px"
                                />
                            </button>
                        </li>
                        <li class="page-item ">
                            <button
                                type="button"
                                class="page-link"
                                v-if="page != pages.length"
                                @click="page = pages.length"
                            >
                                <img
                                    class="mr-4"
                                    src="/img/final.ico"
                                    width="25px"
                                    height="25px"
                                />
                            </button>
                        </li>
                    </ul>
                </nav>
                <div class="card table-responsive">
                    <table class="table">
                        <thead class="card-header">
                            <th>Referencia</th>
                            <th>Articulo</th>
                            <th class="d-flex justify-content-around">
                                <div>Borrar</div>
                                <div>Editar</div>
                            </th>
                        </thead>
                        <tbody class="card-footer">
                            <responsereferencias-component
                                v-for="(contacto, index) in contactosMostrados"
                                :key="index"
                                :contacto="contacto"
                                @delete="borrarcontacto(contacto)"
                                @guardar="actualizarcontacto(contacto)"                                
                            ></responsereferencias-component>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            editionFlag: true,
            contactos: [],
            page: 1,
            perPage: 9,
            pages: [],
            contacto: [],
            dismissSecs: 5,
            dismissCountDown: 0,
            mensaje:''
        };
    },
    mounted() {
        this.getContactos();
    },
    methods: {
        borrarcontacto(contacto) {
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/delreferencia/" + contacto.id)
                .then(response => {
                    function buscarregistro(objeto) {
                        return contacto.id == objeto.id;
                    }
                    var found = this.contactos.findIndex(buscarregistro);
                    this.contactos.splice(found, 1);
                    this.paginate(this.contactos);
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
        },

        getContactos() {
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/referencias")
                .then(response => {
                    this.contactos = response.data;
                    console.log(this.contactos);
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
        },
        setPages() {
            let numberOfPages = Math.ceil(this.contactos.length / this.perPage);
            this.pages = [];
            for (let index = 1; index <= numberOfPages; index++) {
                this.pages.push(index);
            }
        },
        paginate(contactos) {
            this.setPages();
            let page = this.page;
            let perPage = this.perPage;
            let from = page * perPage - perPage;
            let to = page * perPage;

            return contactos.slice(from, to);
        },

        editarcontacto(index) {
            this.editionFlag = false;
        },
        guardarcontacto(contacto) {
            this.contactos.push(contacto);
        },

        actualizarcontacto(contacto) {
            document.getElementById("app").style.cursor = "progress";
            axios
                .put("/api/referencias/" + contacto.id, contacto)
                .then(response => {
                  if (response.data[0]=="1"){
                    this.contactos[contacto.id] = response.data[1];
                  } else {
                    this.mensaje="No se ha podido modificar la referencia ya existe para este articulo una igual";
                    this.showAlert();
                    this.contactos[contacto.id] = response.data[1];
                  }       
                    this.getContactos();             
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
        },
        showAlert() {
            this.dismissCountDown = this.dismissSecs;
        },

    },
    computed: {
        contactosMostrados() {
            return this.paginate(this.contactos);
        }
    },
    watch: {
        contactos() {
            this.setPages();
        }
    },

    filters: {
        trimWords(value) {
            return (
                value
                    .split(" ")
                    .splice(0, 20)
                    .join(" ") + "..."
            );
        }
    }
};
</script>
<style scoped>
button.page-link {
    display: inline-block;
    width: 60px;
    height: 60px;
}
button.page-link {
    font-size: 11px;
    color: #2f3031;
    font-weight: 300;
}
.offset {
    width: 500px !important;
    margin: 20px auto;
}
tr {
    padding: 15px;
}
td {
    padding: 5px;
}
</style>
