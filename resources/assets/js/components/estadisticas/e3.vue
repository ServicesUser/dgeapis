<template>
    <div v-if="ofertasCargando">
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
            <tr v-for="item in listaOfertas.lista">
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
        name: "e3",
        data:()=>({
            listaOfertas:[],
            ofertasCargando:false,
            ofertasGrafico:null,
        }),
        methods:{
            ofertasInicio:function(){
                this.ofertasGrafico=Highcharts.chart('ofertas', {
                    title: {
                        text: 'Ofertas laborales publicadas'
                    },
                    subtitle:{
                        text: window.moment.format('MMMM Do YYYY, h:mm:ss a')+'<br><b>'+this.listaOfertas.lista.length+' Ofertas</b>'
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
                        name:'Ofertas laborales hasta la fecha',
                        allowPointSelect: true,
                        data: this.listaOfertas.tipo,
                        showInLegend: true
                    }]
                });
            },

            cargarOfertas:function(){
                this.ofertasCargando=false;
                axios.get('./api/estadisticas/ofertas')
                    .then(response=>{
                        this.listaOfertas=response.data;
                        this.ofertasCargando=true;
                        this.ofertasInicio();
                    });
            },
        },
        computed:{
            sumaSueldos:function(){
                return this.listaOfertas.lista.reduce(function (total, value) {
                    return total + value.estipendio;
                }, 0);
            }
        },
        mounted(){
            this.cargarOfertas();
        },
    }
</script>