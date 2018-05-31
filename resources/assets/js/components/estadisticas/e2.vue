<template>
    <div v-if="cvsCargando">
        <table class="responsive-table highlight">
            <thead>
            <tr>
                <th>Carrera</th>
                <th>Hojas de Vida</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td><b>TOTAL</b></td>
                <td><b>{{sumaCvs}}</b></td>
            </tr>
            </tfoot>
            <tbody>
            <tr v-for="item in listaCvs.lista">
                <td>{{item.name}}</td>
                <td>{{item.y}}</td>
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
        name: "e2",
        data:()=>({
            listaCvs:[],
            cvsCargando:false,
            cvsGrafico:null,
        }),
        methods:{
            cvsInicio:function(){
                this.cvsGrafico=Highcharts.chart('cvschart', {
                    title: {
                        text: 'Hojas de Vida por Carrera'
                    },
                    subtitle:{
                        text: window.moment.format('MMMM Do YYYY, h:mm:ss a')+'<br><b>'+this.listaCvs.total.numero+' Hojas de Vida</b>'
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
                                format: '<b>{point.name}</b> ({point.y}) {point.percentage:.1f} %',
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
                        name:'CVS',
                        allowPointSelect: true,
                        data: this.listaCvs.lista,
                        showInLegend: true
                    }]
                });
            },

            cargarCvs:function(){
                this.cvsCargando=false;
                axios.get('./api/estadisticas/cvs')
                    .then(response=>{
                        this.listaCvs=response.data;
                        this.cvsCargando=true;
                        this.cvsInicio();
                    });
            },
        },
        computed:{
            sumaCvs:function(){
                return this.listaCvs.lista.reduce(function (total, value) {
                    return total + value.y;
                }, 0);
            }
        },
        mounted(){
            this.cargarCvs();
        },
    }
</script>