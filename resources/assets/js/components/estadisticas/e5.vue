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
                    <li class="waves-effect waves-light"><a href="#!" v-on:click="seleccionado='total'">Total</a></li>
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
                        text: window.moment.format('MMMM Do YYYY, h:mm:ss a'),
                    },
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'bar'
                    },
                    xAxis: {
                        type: 'category',
                        labels: {
                            rotation: 0,
                            style: {
                                fontSize: '8px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        }
                    },
                    yAxis: {
                        title: {
                            enabled:false
                        }
                    },
                    plotOptions: {
                        series: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '{point.y}',
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
                        pointFormat: '{point}',
                    },
                    series: [{
                        type: 'bar',
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
            actualizar:function(){
                let vm= this;
                setInterval(function(){
                    axios.get('./api/estadisticas/aplicaciones')
                        .then(response=>{
                            vm.listaAplicaciones=response.data;
                        });
                }, 5000);
            }
        },
        watch:{
          seleccionado:function(valor){
              this.aplicacionesGrafico.update({
                  title: {
                      text: 'Aplicantes ' + valor.toUpperCase()
                  },
                  subtitle:{
                      text: window.moment.format('MMMM Do YYYY, h:mm:ss a'),
                  },
                  chart: {
                      plotBackgroundColor: null,
                      plotBorderWidth: null,
                      plotShadow: false,
                      type: 'bar'
                  },
                  xAxis: {
                      type: 'category',
                      labels: {
                          rotation: 0,
                          style: {
                              fontSize: '8px',
                              fontFamily: 'Verdana, sans-serif'
                          }
                      }
                  },
                  yAxis: {
                      title: {
                          enabled:false
                      }
                  },
                  plotOptions: {
                      series: {
                          allowPointSelect: true,
                          cursor: 'pointer',
                          dataLabels: {
                              enabled: true,
                              format: '{point.y}',
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
                      pointFormat: '{point}',
                  },
                  series: [{
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
            this.actualizar();
        },
    }
</script>

<style scoped>

</style>