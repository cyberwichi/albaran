<template>
    <div class="">
        <div class="card">
            <b-alert
                :show="dismissCountDown"
                dismissible
                variant="success"
                @dismissed="dismissCountDown = 0"
                @dismiss-count-down="countDownChanged"
            >
                {{mensaje}}
            </b-alert>
            <div class="card-body">
                <form
                    action=""
                    v-on:submit.prevent="nuevaReferencia()"
                    class="card"
                >
                    <div class="card-body sombra">
                        <div class="d-flex justify-content-around">
                            <div class="autocomplete form-group align-left">
                                <label for="querySearch">Articulo</label>
                                <input
                                    @blur="onBlur = true"
                                    @focus="
                                        onFocus = true;
                                        onBlur = false;
                                    "
                                    class="form-control col-12"
                                    type="text"
                                    v-model="querySearch"
                                    name="querySearch"
                                    v-on:keyup="getResult()"
                                    autocomplete="off"
                                    required
                                />
                                <div class="autocomplete-items" v-if="onFocus">
                                    <div
                                        v-for="(articulo, index) in articulos"
                                        @click="
                                            articuloIndex = articulo.AutoId;
                                            querySearch = articulo.Nombre;
                                            upcForm = articulo.UPC;
                                            onFocus = false;
                                        "
                                        :key="index"
                                    >
                                        <div>
                                            <strong>{{
                                                articulo.Nombre.substr(
                                                    0,
                                                    autocomplete.lenght
                                                )
                                            }}</strong>
                                            <span class="badge badge-warning"
                                                >Stock :
                                                {{
                                                    articulo.tb_stock_art.Stock
                                                }}</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>                                                      
                            <div class="form-group">
                                <label for="upc">precio</label>
                                <input
                                    class="form-control col-12"
                                    type="text"
                                    v-model="upcForm"
                                    name="upc"
                                    autocomplete="off"
                                    readonly
                                />
                            </div>
                            <div class="form-group">
                                <label for="referencia">Referencia</label>
                                <input
                                    class="form-control col-12"
                                    type="text"
                                    v-model="referenciaForm"
                                    name="referencia"
                                    autocomplete="off"
                                    required
                                />
                            </div>
                             <button type="button" @click="limpiar()" class="btn  mb-0">
                                <img src="/img/Delete.png" width="30px" alt />
                            </button>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn  mt-3 center">
                            <img src="/img/Save.png" width="50px" alt />
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            articuloIndex: "",
            querySearch: "",
            articulos: [],
            currentFocus: 2,
            autocomplete: "",
            onBlur: true,
            onFocus: false,
            upcForm: "0.00",
            referenciaForm: "",
            dismissSecs: 5,
            dismissCountDown: 0,
            mensaje:''
        };
    },
    methods: {
        addActive() {
            var vm = this;
            if (!vm.articulos) return false;
            if (vm.currentFocus >= vm.articulos.length) vm.currentFocus = 0;
            if (vm.currentFocus < 0) vm.currentFocus = vm.articulos.length - 1;
        },
        getResult() {
            this.articulos = [];
            if (this.querySearch.length > 2) {
                document.getElementById("app").style.cursor = "progress";
                axios
                    .get("/api/searcharticulo/" + this.querySearch)
                    .then(response => {
                        response.data.forEach(articulo => {
                            this.articulos.push(articulo);
                        });
                        this.articulos.sort(function(a, b) {
                            if (a.tb_stock_art.Stock > b.tb_stock_art.Stock) {
                                return -1;
                            }
                            if (a.tb_stock_art.Stock < b.tb_stock_art.Stock) {
                                return 1;
                            }
                            // a must be equal to b
                            return 0;
                        });
                        document.getElementById("app").style.cursor = "auto";
                    });
            }
        },
        nuevaReferencia() {
            let ref = {
                referencia: this.referenciaForm,
                articulo_id: this.articuloIndex
            };
            axios.post("api/referencia", ref).then(response => {
                this.mensaje= response.data;
                this.showAlert();
                this.limpiar();
            });
        },
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown;
        },
        showAlert() {
            this.dismissCountDown = this.dismissSecs;
        },
        limpiar() {
            this.referenciaForm = "";
            this.articuloIndex = "";
            this.upcForm = "";
            this.querySearch = "";
            this.articulos = [];
        }
    }
};
</script>
