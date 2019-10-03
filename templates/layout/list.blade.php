@extends('ArgonForm::layout.base')

<?php

if (!isset($labels)) $labels = [];

$t = (new $model);
$primaryKey = $t->getKeyName();
$table = $t->getTable();
$c = Schema::getColumnListing($table);
$columns = array_intersect($c, array_merge([$primaryKey],$columns ?? $c ));
$data = $model::all($columns);

?>

@section('_content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
    @if (isset($title) or isset($titleForm))

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ $titleForm ?? ($title ?? "") }}</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
    @endif

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

          <!-- /.col-lg-12 -->
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">

              	<table id="dataTable" class="dataTable table table-hover table-bordered" width="100%">
                  <thead>
                    <tr>
                      @foreach ($columns as $colName)
                        @if ($colName != $primaryKey)
                          @if (isset($labels[$colName]))
                            <td>{{ $labels[$colName] }}</td>
                          @else 
                            <td>{{ $colName }}</td>
                          @endif
                        @endif
                      @endforeach
                      <td class="actions">Ações</td>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $row)
                      <tr>
                        @foreach ($columns as $col)
                          
                          @if ($col != $primaryKey)
                            <td>{{ $row->$col }}</td>
                          @endif
                        @endforeach
                        <td class="actions">
                          <center>
                            <form style="display:inline; " method="post" action="{{ Form::_route("$routePrefix.destroy", $row[$primaryKey]) }}">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-primary btn-sm buttons-delete" type="submit">
                                <i class="fa fa-trash"></i>
                              </button>
                            </form>

                            <a href="{{ Form::_route("$routePrefix.edit", $row[$primaryKey]) }}">
                              <button class="btn btn-primary btn-sm buttons-edit">
                                <i class="fa fa-pencil"></i>
                              </button>
                            </a>
                          </center>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>

              </div>
            </div>
          </div>
          <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
@endsection


@style
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/w/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.min.css"/>
@endstyle

@script

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/w/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-html5-1.5.6/b-print-1.5.6/cr-1.5.0/r-2.2.2/datatables.min.js"></script>

@endscript


@push('script')

  <script type="text/javascript">
      $(document).ready(function() {

      $('#dataTable').on('init.dt', function() {

      var table = $('#dataTable').dataTable().api();

      table.buttons().container()
          .appendTo( '#dataTable_wrapper .col-md-6:eq(0)' );

      $('button.buttons-delete').click(function(event) {
        if (!confirm('Tem certeza que deseja apagar o registro?')) {
          event.stopPropagation();
          event.preventDefault();
          $(this).blur();
          return false;
        }
      });

      $('.btn-secondary', table.buttons().container()).removeClass('btn-secondary').addClass('btn-primary');
          
      $('div.dataTables_filter input', table.table().container()).unbind();

      $('div.dataTables_filter input', table.table().container()).keyup(function(e) {
        if (e.keyCode == 27) {
          $(this).blur();
          e.preventDefault();
          e.stopPropagation();
          return false;
        }

        if (e.keyCode == 13) {
          table.search($(this).val()).draw(false);
          e.preventDefault();
          e.stopPropagation();
          return false;
        }

      });

      $(document).bind('keyup', function(e) {
        if (e.ctrlKey && e.altKey) {
          switch (e.keyCode) {
            case 34: 
              table.page('next').draw(false); 
              return;
            break;
            case 33: 
              table.page('previous').draw(false); 
              return;
            break;
            case 80: 
              $('div.dataTables_filter input', table.table().container()).focus(
                function () {
              $('html, body').animate({
                  scrollTop: ($(this).offset().top - $('nav.navbar').outerHeight() - 10) + 'px'
              }, 'fast');
              });
              $('div.dataTables_filter input', table.table().container()).focus();
              return;
            break;
            case 69:
              $('button.buttons-excel', table.table().container()).click();
              return;
            break;
            case 70:
              $('button.buttons-pdf', table.table().container()).click();
              return;
            break;
            case 73:
              $('button.buttons-print', table.table().container()).click();
              return;
            break;
            case 78:
              $('button.buttons-new', table.table().container()).click();
              return;
            break;
            case  49: // 1
            case  50: // 2
            case  51: // 3
            case  52: // 4
            case  53: // 5
            case  54: // 6
            case  55: // 7
            case  56: // 8
            case  57: // 9
              var columnNumber = e.keyCode - 49;
              if (table.column(columnNumber).visible() == true) {
                table.column(columnNumber).visible(false);
              } else {
                table.column(columnNumber).visible(true);
              }
              return;
            break;
            case 48:
              table.column(0).visible(true);
              table.column(1).visible(true);
              table.column(2).visible(true);
              table.column(3).visible(true);
              table.column(4).visible(true);
              table.column(5).visible(true);
              table.column(6).visible(true);
              table.column(7).visible(true);
              table.column(8).visible(true);
              return;
            break;
            case 173:
              if (table.page.len() == 100) table.page.len(50).draw(false)
              else if (table.page.len() == 50) table.page.len(25).draw(false)
              else if (table.page.len() == 25) table.page.len(10).draw(false);
              return;
            break;
            case 61:
              if (table.page.len() == 10) table.page.len(25).draw(false)
              else if (table.page.len() == 25) table.page.len(50).draw(false)
              else if (table.page.len() == 50) table.page.len(100).draw(false);
              return;
            break;
            // default: alert(e.keyCode);
            
          }
        }

        if( e.ctrlKey  ) {
          switch (e.keyCode) {
            case  49: // 1
            case  50: // 2
            case  51: // 3
            case  52: // 4
            case  53: // 5
            case  54: // 6
            case  55: // 7
            case  56: // 8
            case  57: // 9
              
              var columnNumber = e.keyCode - 49;
              if (table.order() == false) {
                table.column(columnNumber).order('asc').draw(false);
                return;
              }
              
              var orderColumn = table.order()[0][0];
              var orderType = table.order()[0][1]
              
              if (columnNumber == orderColumn && orderType == 'asc') {
                table.column(columnNumber).order('desc').draw(false);
              } else {
                table.column(columnNumber).order('asc').draw(false);
              }

              return;
            break;
          }
        }
        });

        $('button.buttons-new',table.table().container()).click(function() {
          window.location = "{{ route("$routePrefix.create") }}";
        });

        $("td.actions button.buttons-delete").attr('title', 'Remove o registro');
        $("td.actions button.buttons-edit").attr('title', 'Edita o registro');
        $("td.actions button").tooltip();

        // Search input tooltip
        $('div.dataTables_filter input', table.table().container()).attr('title', 'Caixa de pesquisa<br>(Ctrl+Alt+P)');
        $('div.dataTables_filter input', table.table().container()).tooltip();

        // Buttons Tooltip
        $('button.buttons-new',table.table().container()).attr('title', 'Novo registro<br>(Ctrl+Alt+N)');
        $('button.buttons-page-length',table.table().container()).attr('title', 'Resultados por página<br>(Ctrl+Alt+[+/-])');
        $('button.buttons-colvis',table.table().container()).attr('title', 'Colunas visíveis<br>(Ctrl+Alt+[1-9])');
        $('button.buttons-excel',table.table().container()).attr('title', 'Exportar para o excel<br>(Ctrl+Alt+E)');
        $('button.buttons-pdf',table.table().container()).attr('title', 'Exportar para PDF<br>(Ctrl+Alt+F)');
        $('button.buttons-print',table.table().container()).attr('title', 'Imprimir<br>(Ctrl+Alt+I)');
        $('button', table.table().container()).tooltip({
          html: true
        });
      });



        var table = $('#dataTable').DataTable( {
          lengthChange: false,
          order: [],

          buttons: [
          {text: "<i class=\"fa fa-plus\" aria-hidden=\"true\"></i>", className: "buttons-new"},
          {extend: 'pageLength', text: "<i class=\"fa fa-list-ol\" aria-hidden=\"true\"></i>"},
          {extend: 'colvis', text: "<i class=\"fa fa-columns\" aria-hidden=\"true\"></i>"}, 
          {extend: 'excel', text: "<i class=\"fa fa-file-excel-o\" aria-hidden=\"true\"></i>", exportOptions: { columns: ':visible' }}, 
          {extend: 'pdf', text: "<i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i>", exportOptions: { columns: ':visible' }}, 
          {extend: 'print', text: "<i class=\"fa fa-print\" aria-hidden=\"true\"></i>", exportOptions: { columns: ':visible' }},
          ],
          
          // Responsive DataTables Config
          responsive: true,

          // Change Label on search for a placeholder
          language: {
            search: "_INPUT_",
            searchPlaceholder: "Pesquisar...",
            // search: "<u>P</u>esquisar:",
            emptyTable: "Nenhum registro encontrado",
            info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 até 0 de 0 registros",
            infoFiltered: "(Filtrados de _MAX_ registros)",
            infoPostFix: "",
            infoThousands: ".",
            lengthMenu: "_MENU_ resultados por página",
            loadingRecords: "Carregando...",
            processing: "Processando...",
            zeroRecords: "Nenhum registro encontrado",
            paginate: {
                next: "<i class=\"fa fa-chevron-right\" aria-hidden=\"true\"></i>",
                previous: "<i class=\"fa fa-chevron-left\" aria-hidden=\"true\"></i>",
                first: "Primeiro",
                last: "Último"
            },
            aria: {
                sortAscending: ": Ordenar colunas de forma ascendente",
                sortDescending: ": Ordenar colunas de forma descendente"
            }
          }
        } 
      );
      

      





      // table.button(4).text('a');


      } );

  </script>
@endpush