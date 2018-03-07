<template>
        <div v-if="aplicacionesCargando">
            <table class="responsive-table highlight">
                <thead>
                <tr>
                    <th>Facultad</th>
                    <th>Aplicaciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <td><b>TOTAL</b></td>
                    <td><b>{{sumaApl}}</b></td>
                </tr>
                </tfoot>
                <tbody>
                <tr v-for="item in listaAplicaciones[seleccionado]">
                    <td>{{item.name}}</td>
                    <td>{{item.y}}</td>
                </tr>
                </tbody>
            </table>
            <div class="fixed-action-btn toolbar">
                <a class="btn-floating btn-large  light-blue darken-4">
                    <i class="large material-icons">add</i>
                </a>
                <ul>
                    <li class="waves-effect waves-light"><a href="#!" v-on:click="seleccionado='estudiantes'">Estudiantes</a></li>
                    <li class="waves-effect waves-light"><a href="#!" v-on:click="seleccionado='egresados'">Egresados</a></li>
                    <li class="waves-effect waves-light"><a href="#!" v-on:click="seleccionado='graduados'">Graduados</a></li>
                </ul>
            </div>
        </div>
        <div v-else class="center-align">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
                </div>
            </div>
        </div>

</template>

<script>
    import Highcharts from 'highcharts';
    require('highcharts/modules/exporting')(Highcharts);
    export default {
        name: "e5",
        data:()=>({
            listaAplicaciones:[],
            aplicacionesCargando:false,
            aplicacionesGrafico:null,

            seleccionado:'total',
        }),
        methods:{
            aplicacionesInicio:function(){
                this.aplicacionesGrafico=Highcharts.chart('aplicaciones', {
                    title: {
                        text: 'Aplicantes '
                    },
                    subtitle:{
                        text: window.moment.format('MMMM Do YYYY, h:mm:ss a') + this.seleccionado,
                    },
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '({point.y}) {point.percentage:.0f}%',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                },
                                connectorColor: 'silver'
                            }
                        }
                    },
                    credits: {
                        enabled: true,
                        href: "http://be.dgepuce.edu.ec",
                        text: "be.dgepuce.edu.ec",
                    },
                    exporting:{
                        filename: "Bolsa de Empleos y Pasantías PUCE ",
                        enabled:true,
                    },
                    tooltip: {
                        pointFormat: '{point.percentage:.2f}%'
                    },
                    series: [{
                        type: 'pie',
                        name:'Aplicaciones por facultad',
                        allowPointSelect: true,
                        data: this.listaAplicaciones[this.seleccionado],
                        showInLegend: true
                    }]
                });
            },

            cargarAplicaciones:function(){
                this.aplicacionesCargando=false;
                axios.get('./api/estadisticas/aplicaciones')
                    .then(response=>{
                        this.listaAplicaciones=response.data;
                        this.aplicacionesCargando=true;
                        this.aplicacionesInicio();
                    });
            },
        },
        watch:{
          seleccionado:function(valor){
              this.aplicacionesGrafico.update({
                  title: {
                      text: 'Aplicantes ' + valor
                  },
                  subtitle:{
                      text: window.moment.format('MMMM Do YYYY, h:mm:ss a')+'<br>'+valor
                  },
                  chart: {
                      plotBackgroundColor: null,
                      plotBorderWidth: null,
                      plotShadow: false,
                      type: 'pie'
                  },
                  plotOptions: {
                      pie: {
                          allowPointSelect: true,
                          cursor: 'pointer',
                          dataLabels: {
                              enabled: true,
                              format: '({point.y}) {point.percentage:.0f}%',
                              style: {
                                  color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                              },
                              connectorColor: 'silver'
                          }
                      }
                  },
                  credits: {
                      enabled: true,
                      href: "http://be.dgepuce.edu.ec",
                      text: "be.dgepuce.edu.ec",
                  },
                  exporting:{
                      filename: "Bolsa de Empleos y Pasantías PUCE ",
                      enabled:true,
                  },
                  tooltip: {
                      pointFormat: '{point.percentage:.2f}%'
                  },
                  series: [{
                      type: 'pie',
                      name:'Aplicaciones por facultad',
                      allowPointSelect: true,
                      data: this.listaAplicaciones[valor],
                      showInLegend: true
                  }]
              });
          }
        },
        computed:{
            sumaApl:function(){
                return this.listaAplicaciones[this.seleccionado].reduce(function (total, value) {
                    return total + value.y;
                }, 0);
            }
        },
        mounted(){
            this.cargarAplicaciones();
        },
    }
</script>

<style scoped>

</style>