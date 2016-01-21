/**Graficas de la pagina inicial
 * @author aurigadl@gmail.com
 */

$(document).ready(function(){
    debugger 
    var color1 = '#4bb2c5',
        color2 = '#eaeef9',
        color3 = '#ff0000';
    
    $.ajax({
        type:       "POST",
        url:        "../include/ajax/graficAlert.php",        
        cache:      false,        
        data:       returnUsu_Dep(),
        dataType:   "json",
        success: function(data){    
                                
                    var line1 = data[1][0],
                        line2 = data[1][1],
                        line3 = data[1][2],
                        ticks = data[1][3],
                        s2 = data[0]; 
                    
                    //Crea la grafica de barras
                    plot1 = $.jqplot('chart1', [line1, line2, line3], {
                        seriesColors: [ color1,color2 ,color3],
                        title:'Radicados Discriminados',
                        seriesDefaults: {
                            renderer: $.jqplot.BarRenderer,                            
                            pointLabels: {show: true, formatString: '%d'},
                            rendererOptions: {                               
                                highlightMouseDown: true    
                            }
                        },
                        legend:{
                            show:true, 
                            location:'ne', 
                            xoffset:10,
                            placement: 'outside'
                        },
                        shadowAngle: 135,
                        series:[
                            {label:'Activos'}, 
                            {label:'Proximos'}, 
                            {label:'Vencidos'}
                        ],
                        axes: {                            
                            xaxis:{
                                label: 'Tipos documentales',
                                renderer:$.jqplot.CategoryAxisRenderer, 
                                ticks:ticks,
                                tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                                tickOptions: {
                                    angle: -90,
                                    fontSize: '8pt',
                                    showMark: false,
                                    showGridline: false
                                }
                            },
                            yaxis: {
                              label: 'No. radicados',
                              labelRenderer: $.jqplot.CanvasAxisLabelRenderer
                            }
                        },
                        axesDefaults: {        
                            min: 0,      // minimum numerical value of the axis.  Determined automatically.
                        },
                        tickOptions: {
                            mark: 'outside',    // Where to put the tick mark on the axis
                                                // 'outside', 'inside' or 'cross',
                            showMark: true,
                            showGridline: true, // wether to draw a gridline (across the whole grid) at this tick,
                            markSize: 4,        // length the tick will extend beyond the grid in pixels.  For
                                                // 'cross', length will be added above and below the grid boundary,
                            show: true,         // wether to show the tick (mark and label),
                            showLabel: true,    // wether to show the text label at the tick,
                            formatString: '',   // format string to use with the axis tick formatter
                        },
                        showTicks: true,        // wether or not to show the tick labels,
                        showTickMarks: true    // wether or not to show the tick marks
                    });
                        
                    //Crea la grafica de torta        
                    plot2 = $.jqplot('chart2', [s2], {                        
                        seriesColors: [ color1,color2 ,color3],                                 
                        title:'Estados de Radicados En Bandeja',                        
                        grid: {
                            drawBorder: false, 
                            drawGridlines: false,
                            background: '#ffffff',
                            shadow:false
                        },
                        axesDefaults: {
                            
                        },
                        seriesDefaults:{
                            renderer:$.jqplot.PieRenderer,
                            rendererOptions: {
                                showDataLabels: true
                            }                            
                        },
                        legend: {
                            show: true,
                            rendererOptions: {
                                numberRows: 1
                            },
                            location: 's'
                        }
                    });
                }      
    });
});