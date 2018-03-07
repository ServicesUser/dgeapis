<template>
    <div v-if="empresasCargando">
        <table class="responsive-table highlight">
            <thead>
            <tr>
                <th>Organización</th>
                <th>Sector</th>
                <th>Subsector</th>
                <th>Tipo</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="3"><b>TOTAL</b></td>
                <td><b>{{listaEmpresas.lista.length}}</b></td>
            </tr>
            </tfoot>
            <tbody>
            <tr v-for="item in listaEmpresas.lista">
                <td>{{item.empresa}}</td>
                <td>{{item.sector}}</td>
                <td>{{item.subsector}}</td>
                <td>{{item.tipo}}</td>
            </tr>
            </tbody>
        </table>
        <div class="fixed-action-btn toolbar">
            <a class="btn-floating btn-large  light-blue darken-4">
                <i class="large material-icons">add</i>
            </a>
            <ul>
                <li class="waves-effect waves-light"><a href="#!" v-on:click="empresasChart(1)">Sector</a></li>
                <li class="waves-effect waves-light"><a href="#!" v-on:click="empresasChart(2)">Subsector</a></li>
                <li class="waves-effect waves-light"><a href="#!" v-on:click="empresasChart(3)">Tipo</a></li>
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
        name: "e1",
        data:()=>({
            listaEmpresas: [],
            empresasCargando: false,
            empresasGrafico: null,
        }),
        methods:{
            cargarEmpresas:function(){
                this.empresasCargando=false;
                axios.get('./api/estadisticas/empresas')
                    .then(response=>{
                        this.listaEmpresas=response.data;
                        this.empresasCargando=true;
                        this.empresasInicio();
                    });
            },
            empresasInicio:function(){
                Highcharts.setOptions({
                    colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
                        return {
                            radialGradient: {
                                cx: 0.5,
                                cy: 0.3,
                                r: 0.7
                            },
                            stops: [
                                [0, color],
                                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                            ]
                        };
                    })
                });
                this.empresasGrafico=Highcharts.chart('empresas-chart', {
                    title: {
                        text: 'Organizaciones por Sector'
                    },
                    subtitle:{
                        text: window.moment.format('MMMM Do YYYY, h:mm:ss a')+'<br><b>'+this.listaEmpresas.lista.length+' Organizaciones</b>'
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
                        name:'Sector',
                        allowPointSelect: true,
                        data: this.listaEmpresas.sectores,
                        showInLegend: true
                    }]
                });
            },
            empresasChart:function(tipo){
                if(tipo===1){
                    this.empresasGrafico.update({
                        title: {
                            text: 'Organizaciones por Sector'
                        },
                        subtitle:{
                            text: window.moment.format('MMMM Do YYYY, h:mm:ss a')+'<br><b>'+this.listaEmpresas.lista.length+' Organizaciones</b>'
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
                            name:'Sector',
                            allowPointSelect: true,
                            data: this.listaEmpresas.sectores,
                            showInLegend: true
                        }]
                    });
                }
                if(tipo===2){
                    this.empresasGrafico.update({
                        title: {
                            text: 'Organizaciones por Sub-Sector'
                        },
                        subtitle:{
                            text: window.moment.format('MMMM Do YYYY, h:mm:ss a')+'<br><b>'+this.listaEmpresas.lista.length+' Organizaciones</b>'
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
                            name:'SubSector',
                            allowPointSelect: true,
                            data: this.listaEmpresas.subsectores,
                            showInLegend: true
                        }]
                    });
                }
                if(tipo===3){
                    this.empresasGrafico.update({
                        title: {
                            text: 'Organizaciones por Tipo'
                        },
                        subtitle:{
                            text: window.moment.format('MMMM Do YYYY, h:mm:ss a')+'<br><b>'+this.listaEmpresas.lista.length+' Organizaciones</b>'
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
                            name:'Tipos',
                            allowPointSelect: true,
                            data: this.listaEmpresas.tipos,
                            showInLegend: true
                        }]
                    });
                }
            },
        },
        mounted(){
            this.cargarEmpresas();
        },
    }
</script>