<template>
    <div v-if="ofertasVCargando">
        <table class="responsive-table highlight">
            <thead>
            <tr>
                <th>Organización</th>
                <th>Requerimiento</th>
                <th>Tipo</th>
                <th>Salario</th>
                <th>Fecha</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="3"><b>TOTAL</b></td>
                <td><b>{{sumaSueldos}}</b></td>
            </tr>
            </tfoot>
            <tbody>
            <tr v-for="item in listaOfertasV.lista">
                <td>{{item.empresa}}</td>
                <td>{{item.titulo}}</td>
                <td>{{item.tipo}}</td>
                <td>{{item.estipendio}}</td>
                <td>{{item.fecha_publicacion}}</td>
            </tr>
            </tbody>
        </table>
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
        name: "e4",
        data:()=>({
            listaOfertasV:[],
            ofertasVCargando:false,
            ofertasVGrafico:null,
        }),
        methods:{
            ofertasVInicio:function(){
                this.ofertasVGrafico=Highcharts.chart('ofertasVigentes', {
                    title: {
                        text: 'Ofertas laborales vigentes'
                    },
                    subtitle:{
                        text: window.moment.format('MMMM Do YYYY, h:mm:ss a')+'<br><b>'+this.listaOfertasV.lista.length+' Ofertas</b>'
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
                        name:'Ofertas laborales vigentes hasta la fecha',
                        allowPointSelect: true,
                        data: this.listaOfertasV.tipo,
                        showInLegend: true
                    }]
                });
            },

            cargarOfertasV:function(){
                this.ofertasVCargando=false;
                axios.get('./api/estadisticas/vigentes')
                    .then(response=>{
                        this.listaOfertasV=response.data;
                        this.ofertasVCargando=true;
                        this.ofertasVInicio();
                    });
            },
        },
        computed:{
            sumaSueldos:function(){
                return this.listaOfertasV.lista.reduce(function (total, value) {
                    return total + value.estipendio;
                }, 0);
            }
        },
        mounted(){
            this.cargarOfertasV();
        },
    }
</script>