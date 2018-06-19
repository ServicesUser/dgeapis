<template>
        <div v-if="contratadosCargando">
            <table class="responsive-table highlight">
                <thead>
                <tr>
                    <th>Facultad</th>
                    <th>Contrataciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <td><b>TOTAL</b></td>
                    <td><b>{{sumaCon}}</b></td>
                </tr>
                </tfoot>
                <tbody>
                <tr v-for="item in listaContratados">
                    <td>{{item.name}}</td>
                    <td>{{item.y}}</td>
                </tr>
                </tbody>
            </table>
        </div>
</template>
<script>
    import Highcharts from 'highcharts';
    require('highcharts/modules/exporting')(Highcharts);
    export default {
        name: "e6",
        data:()=>({
            listaContratados:[],
            contratadosCargando:false,
            contratadosGrafico:null,
        }),
        methods:{
            contratadosInicio:function(){
                this.contratadosGrafico=Highcharts.chart('contrataciones', {
                    title: {
                        text: 'Contratados'
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
                        name:'Contratados por facultad',
                        allowPointSelect: true,
                        data: this.listaContratados,
                        showInLegend: true
                    }]
                });
            },

            cargarContratados:function(){
                this.contratadosCargando=false;
                axios.get('./api/estadisticas/contratados')
                    .then(response=>{
                        this.listaContratados=response.data.lista;
                        this.contratadosCargando=true;
                        this.contratadosInicio();
                    });
            }
        },
        computed:{
            sumaCon:function(){
                return this.listaContratados.reduce(function (total, value) {
                    return total + value.y;
                }, 0);
            }
        },
        mounted(){
            this.cargarContratados();
        },
    }
</script>

<style scoped>

</style>