<template>
    <div class="card-body">        
        <form v-on:submit.prevent="subir" class="container m-2 text-center">
            <div class="col-12 text-center h1 mb-3">
                <strong>TEXTOS PARA LOS CORREOS</strong>
            </div>
            <label for="proteccion">Texto de proteccion de datos</label>
            <br>
            <textarea name="proteccion" v-model="proteccion" class="w-100" rows="5"/>
            <br>
            <label for="asunto">Texto de asunto</label>
            <br>
            <textarea name="asunto" v-model="asunto" class="w-100" rows="5"/>

            <button class="btn btn-primary" type="submit">Guardar</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            proteccion:'',
            asunto:''
        };
    },
    mounted() {
        axios.get('/api/config').then(response=>{
            this.proteccion=response.data.proteccion;
            this.asunto=response.data.asunto;
        })
        
    },
    methods: {
        subir(){
            var aux={
                proteccion: this.proteccion,
                asunto: this.asunto
            }
            axios.post('/api/literales/', aux).then(response=>{
                if (response.data == 'Ok') {
                    alert('Literales guardados correctamente');
                }
            })
        }
    }
};
</script>
