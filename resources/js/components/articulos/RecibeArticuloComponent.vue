<template>
    <div>
        <div class="card">
            <div class="card-body">
                
                    <autocompletararticulo-component
                        @nuevaLinea="actualizaArticulo($event)"
                        v-model="linea"
                        class="card bg-light mb-3"
                        name="articulo"
                    ></autocompletararticulo-component>
              
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
        linea:{},
        };
    },
    methods: {
       
        actualizaArticulo(articulo) {
          
           document.getElementById("app").style.cursor = "progress";
            axios
                .put("/api/articulossumastock/" + articulo.articuloId, articulo)
                .then(response => {
                    document.getElementById("app").style.cursor = "auto";
                })
                .catch(e => {
                    console.log(e);
                    document.getElementById("app").style.cursor = "auto";
                });
        }
    }
};
</script>
