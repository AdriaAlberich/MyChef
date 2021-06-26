
@extends('layouts.principal')

@section('title') Factura PDF @stop

@section('content')

<script type="text/javascript">
    function genPDF() {
      
        html2canvas(document.body,{

            onrendered : function(canvas) {

                var img = canvas.toDataURL("image/png");
                var doc = new jsPDF();
                doc.addImage(img,'JPEG',-75,0);
                doc.save('Factura.pdf');

            }
        });
      
    }
</script>
</br>
</br>
<div class="container" id="testdiv">

    <div class="row col-lg-offset-3 col-lg-6" id="hidediv">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Factura</h3>
            </div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-lg-6">
                        <div class="panel panel-default ">
                            <div class="panel-heading">Datos de la Empresa</div>
                            <div class="panel-body">
                                <p><b>Mychef.cat</b></p>
                                <p><b>CIF:</b> B73347494</p>
                                <p>Avda Europa, 2-3, Pol.Ind. Las Salinas.</p>
                                <p><b>Telefono gratuito:</b> 900 832 342</p>
                                <p>Barcelona</p>
                                <p>08905 L'Hospitalet de llobregat</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Datos de Personales</div>
                            <div class="panel-body">
                                <p><b>Nombre:</b> {{$usuario->nombre}}</p>
                                <p><b>Dirección: </b>{{$usuario->direccion}}</p>
                                <p><b>Población:</b>{{$usuario->poblacion}}</p>
                                <p><b>NIF/CIF:</b>{{$usuario->dni}}</p>
                                <p><b>Teléfono:</b>666666666</p>
                                <p><b>E-mail: </b>{{$usuario->email}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Chef</th>
                                <th>Menú</th>
                                <th>Precio</th>
                                <th>Personas</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$contratos->fecha}}</td>
                                <td>{{$nombrechef2->nombre}}</td>
                                <td>{{$menu->menu}}</td>
                                <td>{{$precio->precio}}</td>
                                <td>2</td>
                                <td>{{$precio->precio}}</td>
                            </tr>

                        </tbody>
                    </table>


                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Recargos</th>
                                <th>IVA</th>
                                <th>Total</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td>21%</td>
                                <td>{{$precio->precio*0.21+$precio->precio}}</td>
                            </tr>

                        </tbody>
                    </table>


                    <a href="javascript:genPDF()">Descargar</a>
                </div>

            </div>
        </div>
    </div>

</div>
@stop