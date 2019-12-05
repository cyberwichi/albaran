<template>
    <div class>
      <div  v-if="alert" class="alert alert-danger" role="alert">
                        Sin albaranes para mostrar
                    </div>
        <autocompletcontacto-component
            @newcontacto="buscaAlbaranes($event)"
        ></autocompletcontacto-component>

        <div class="card">
            <div class="card-body">
                 <nav aria-label="Page navigation example" class>
                    <ul class="pagination">
                        <li class="page-item">
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
                            <td>Numero Albaran</td>
                            <td>Numero Aviso</td>
                            <td>Fecha</td>
                            <td>Observaciones</td>

                            <td class="d-flex justify-content-around">
                                <div class="mr-2">Borrar</div>
                                <div class="mr-4">Ver</div>
                            </td>
                        </thead>
                        <tbody class="card-footer sombra">
                            <responsealbaran-component
                                v-for="(albaran, index) in albaranesMostrados"
                                :key="index"
                                :albaran="albaran"
                                @delete="borraralbaran(albaran)"
                                @ver="veralbaran(albaran)"
                            ></responsealbaran-component>
                        </tbody>
                    </table>
                    
                </div>
            </div>
               <div id="albaran"></div>
        </div>
        <vistaalbaran-component
            :albaran="albaran"
            v-if="flagver"
        ></vistaalbaran-component>
    </div>
</template>

<script>
export default {
    data() {
        return {
            albaranes: [],
            page: 1,
            perPage: 9,
            pages: [],
            flagver: false,
            alert:false
        };
    },
    mounted() {},
    methods: {
        buscaAlbaranes(contacto) {
            this.albaranes = [];
            this.pages = [];
            this.flagver = false;
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/albaranesporcliente/" + contacto.Id)
                .then(response => {
                    var alba = response.data;
                    alba.forEach(element => {
                        if (element.length) {
                            element.forEach(x => {
                                this.albaranes.push(x);
                            });
                        }
                    });
                    if (this.albaranes.length == 0) {
                      this.alert=true;
                    } else{ this.alert=false}
                    document.getElementById("app").style.cursor = "auto";
                });
        },

        getAlbaranes() {
            document.getElementById("app").style.cursor = "progress";
            axios
                .get("/api/albaranes")
                .then(response => {
                    this.albaranes = response.data;
                    document.getElementById("app").style.cursor = "auto";
                    
                })
                .catch(e => {console.log(e);
                document.getElementById("app").style.cursor = "auto";});
        },
        setPages() {
            let numberOfPages = Math.ceil(this.albaranes.length / this.perPage);
            for (let index = 1; index <= numberOfPages; index++) {
                this.pages.push(index);
            }
        },
        paginate(albaranes) {
            let page = this.page;
            let perPage = this.perPage;
            let from = page * perPage - perPage;
            let to = page * perPage;

            return albaranes.slice(from, to);
        },
        veralbaran(albaran) {
            this.flagver = false;
            this.albaran = albaran;
            this.flagver = true;
        }
    },
    computed: {
        albaranesMostrados() {
            return this.paginate(this.albaranes);
        }
    },
    watch: {
        albaranes() {
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
