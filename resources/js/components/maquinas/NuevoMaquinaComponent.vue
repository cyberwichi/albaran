<template>
    <div>
        <div class="card">
            <div class="card-body">
                <form action v-on:submit.prevent="nuevoMaquina()" class="card">
                    <div class="card-body sombra">
                        <div class="form-group">
                            <label for="nombre">Nombre Maquina</label>
                            <input
                                type="text"
                                class="form-control"
                                name="nombre"
                                v-model="nombre"
                            />
                        </div>
                       
                            Comentarios Observaciones Descripcion etc...
                            <textarea
                                name="message"
                                v-model="comentarios"
                            ></textarea>                       
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn  mt-3 center">
                            <img src="/img/Save.png" width="45px" alt />
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
          maquina:{
            nombre: "",
            comentarios:""
          },
          nombre:"",
          comentarios:""           
        };
    },
    methods: {
        nuevoMaquina() {
            document.getElementById("app").style.cursor = "progress";
            this.maquina.nombre=this.nombre;
            this.maquina.comentarios=this.comentarios;
            
            axios.post("/api/maquinas", this.maquina).then(response => {              
                document.getElementById("app").style.cursor = "auto";
               
            });
            this.nombre="";
            this.comentarios="";
        }
    }
};
</script>
