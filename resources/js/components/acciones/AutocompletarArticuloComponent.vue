<template>
    <div class="card-body sombra">
        <div class="autocomplete form-group">
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
                v-on:keydown="keyDown"
                placeholder
                autocomplete="off"
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
                            articulo.Nombre.substr(0, autocomplete.lenght)
                        }}</strong>
                        <span class="badge badge-warning"
                            >Stock : {{ articulo.tb_stock_art.Stock }}</span
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
            <label for="cantidad">cantidad</label>
            <input
                type="text"
                class="form-control col-12"
                name="cantidad"
                v-model="cantidadForm"
                autocomplete="off"
            />
        </div>
        <button type="button" class=" mt-3" v-on:click="añadirLinea()">
            <img class="mr-4" src="img/add.png" width="50px" alt="" /> Añadir
            articulo
        </button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            articuloIndex: "",
            querySearch: "",
            articulos: [],
            currentFocus: 2,
            autocomplete: "",
            onBlur: true,
            onFocus: false,
            upcForm: "0.00",
            cantidadForm: "1",
            linea: {
                articuloId: "",
                articuloNombre: "",
                articuloCantidad: "",
                articuloPrecio: ""
            }
        };
    },
    mounted() {
        var vm = this;
        document.addEventListener("click", function(e) {
            vm.onBlur ? (vm.onFocus = false) : false;
        });
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
        keyDown(e) {
            var vm = this;

            if (e.keycode == 40) {
                vm.currentFocus++;
                vm.addActive();
            } else if (e.keyCode == 38) {
                vm.currentFocus--;
                vm.addActive();
            }
        },
        añadirLinea() {
            this.linea = {
                articuloId: this.articuloIndex,
                articuloNombre: this.querySearch,
                articuloCantidad: this.cantidadForm,
                articuloPrecio: this.upcForm
            };
            this.articuloIndex = "";
            this.querySearch = "";
            this.cantidadForm = "1";
            this.upcForm = "";
            this.articulos = [];

            this.$emit("nuevaLinea", this.linea);
        }
    }
};
</script>
