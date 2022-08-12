{{-- 

Os dados virão sob o nome $name, por que esta é a variavel padrão
aceita como primeiro parametro do construtor, fiz assim para criar 
uma sintaxe mais limpo.

--}}

<?php

$actions = $actions ?? true;

?>

<table id="{{ $id }}" class="dataTable table table-hover table-bordered" width="100%">
<thead>
	<tr>
		@foreach ($name[0] as $colName => $d)
			<td>{{ $colName }}</td>
		@endforeach
		<?php if ($actions): ?>
      <td class="actions">Ações</td>
    <?php endif; ?>
	</tr>
</thead>
<tbody>
	@foreach ($name as $row)
		<tr>
			@foreach ($row as $col)
				<td>{{ $col }}</td>
			@endforeach
			<?php if ($actions): ?>
        <td class="actions">
  				<center>
            <button class="btn btn-primary btn-sm buttons-delete" type="submit">
              <i class="fa fa-trash"></i>
            </button>

            <button class="btn btn-primary btn-sm buttons-edit">
              <i class="fa fa-pencil"></i>
            </button>
  				</center>
  			</td>
      <?php endif; ?>
		</tr>
	@endforeach
</tbody>
</table>

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

      $('#{{$id}}').on('init.dt', function() {

      var table = $('#{{$id}}').dataTable().api();

      table.buttons().container()
          .appendTo( '#{{$id}}_wrapper .col-md-6:eq(0)' );
      
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

        <?php if ($actions): ?>
          $("td.actions button.buttons-delete").attr('title', 'Remove o registro');
          $("td.actions button.buttons-edit").attr('title', 'Edita o registro');
          $("td.actions button").tooltip();
        <?php endif; ?>

        // Search input tooltip
        $('div.dataTables_filter input', table.table().container()).attr('title', 'Caixa de pesquisa<br>(Ctrl+Alt+P)');
        $('div.dataTables_filter input', table.table().container()).tooltip();

        // Buttons Tooltip
        <?php if ($actions): ?>
        $('button.buttons-new',table.table().container()).attr('title', 'Novo registro<br>(Ctrl+Alt+N)');
        <?php endif; ?>
        $('button.buttons-page-length',table.table().container()).attr('title', 'Resultados por página<br>(Ctrl+Alt+[+/-])');
        $('button.buttons-colvis',table.table().container()).attr('title', 'Colunas visíveis<br>(Ctrl+Alt+[1-9])');
        $('button.buttons-excel',table.table().container()).attr('title', 'Exportar para o excel<br>(Ctrl+Alt+E)');
        $('button.buttons-pdf',table.table().container()).attr('title', 'Exportar para PDF<br>(Ctrl+Alt+F)');
        $('button.buttons-print',table.table().container()).attr('title', 'Imprimir<br>(Ctrl+Alt+I)');
        $('button', table.table().container()).tooltip({
          html: true
        });
      });



        var table = $('#{{$id}}').DataTable( {
          lengthChange: false,
          order: [],

          buttons: [
          <?php if ($actions): ?>
            {text: "<i class=\"fa fa-plus\" aria-hidden=\"true\"></i>", className: "buttons-new"},
          <?php endif; ?>
          {extend: 'pageLength', text: "<i class=\"fa fa-list-ol\" aria-hidden=\"true\"></i>"},
          {extend: 'colvis', text: "<i class=\"fa fa-columns\" aria-hidden=\"true\"></i>"}, 
          {extend: 'excel', text: "<i class=\"fa fa-file-excel-o\" aria-hidden=\"true\"></i>", exportOptions: { columns: ':visible' }}, 
          {extend: 'pdf', text: "<i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i>", exportOptions: { columns: ':visible' }}, 
          {extend: 'print', text: "<i class=\"fa fa-print\" aria-hidden=\"true\"></i>"},
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


      } );

	</script>
@endpush
