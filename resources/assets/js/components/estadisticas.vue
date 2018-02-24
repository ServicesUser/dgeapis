<template>
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link btn btn-primary" data-toggle="tab" href="#organizaciones" role="tab">Organizaciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-primary" data-toggle="tab" href="#hv" role="tab">Hojas de Vida</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="organizaciones" role="tabpanel" >
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link btn btn-info" data-toggle="tab" href="#DatosOrganizaciones" role="tab">Datos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-info" data-toggle="tab" href="#GraficoOrganizaciones" role="tab">Gráfico</a>
                    </li>
                </ul>
                <div class="tab-content" v-if="empresasCargando">
                    <div class="tab-pane active" id="DatosOrganizaciones" role="tabpanel" >
                        <table class="table table-hover table-dark">
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
                    </div>
                    <div class="tab-pane" id="GraficoOrganizaciones" role="tabpanel">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary" v-on:click="empresasChart(1)">Sector</button>
                            <button type="button" class="btn btn-secondary" v-on:click="empresasChart(2)">Subsector</button>
                            <button type="button" class="btn btn-secondary" v-on:click="empresasChart(3)">Tipo</button>
                        </div>

                    </div>
                </div>
            </div>
            <div id="empresas-chart"></div>
            <div class="tab-pane" id="hv" role="tabpanel" >
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link btn btn-info" data-toggle="tab" href="#DatosCvs" role="tab">Datos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-info" data-toggle="tab" href="#GraficoCv" role="tab">Gráfico</a>
                    </li>
                </ul>
                <div class="tab-content" v-if="cvsCargando">
                    <div class="tab-pane active" id="DatosCvs" role="tabpanel" >
                        <table class="table table-hover table-dark">
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
                    <div class="tab-pane" id="GraficoCv" role="tabpanel">

                    </div>

                </div>
            </div>
            <div id="cvschart"></div>
        </div>
    </div>
</template>
<script>
    import Highcharts from 'highcharts';
    require('highcharts/modules/exporting')(Highcharts);
    export default {
        name: "estadisticas",
        data:()=>({
            listaEmpresas:[],
            empresasCargando:false,
            empresasGrafico:null,

            listaCvs:[],
            cvsCargando:false,
            cvsGrafico:null,
        }),
        methods: {
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
                                enabled: false,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
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
                        pointFormat: '{point.percentage:.1f}%'
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
                                    enabled: false,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
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
                            pointFormat: '{point.percentage:.1f}%'
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
                                    enabled: false,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
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
                            pointFormat: '{point.percentage:.1f}%'
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
                                    enabled: false,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
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
                            pointFormat: '{point.percentage:.1f}%'
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
            cargarEmpresas:function(){
                this.empresasCargando=false;
                axios.get('./api/estadisticas/empresas')
                    .then(response=>{
                        this.listaEmpresas=response.data;
                        this.empresasCargando=true;
                        this.empresasInicio();
                    });
            },

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
                                enabled: false,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
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
                        pointFormat: '{point.percentage:.1f}%'
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
            this.cargarEmpresas();
            this.cargarCvs();
        },
    }
</script>

<style scoped>

</style>