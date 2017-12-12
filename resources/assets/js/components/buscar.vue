<template>
        <div class="input-group">
            <span class="input-group-addon">DNI/CI</span>
            <input type="text" class="form-control" v-model="dni" v-on:keyup.13="buscar"/>
            <span class="input-group-btn"><button class="btn btn-info" v-on:click="buscar">Buscar</button></span>
        </div>
</template>

<script>
    export default {
        props: ['url'],
        data:()=>({
            dni:'',
        }),
        methods:{
          buscar:function(){
              window.location.replace(this.url+'/'+this.dni);
          }
        },
        mounted(){

        }
    }
</script>
