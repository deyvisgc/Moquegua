$(document).ready(function(){
             $('#tabla_clientes').jtable({
                          title: 'Movimientos de Clientes',
                          paging: true,
                          sorting: true,
				          pageSize: 10,
                          pageSizeChangeArea: false,
                          defaultSorting: 'id ASC',
                          gotoPageArea: 'none',
                          //selecting: true,
                          //multiselect: true, //Allow multiple selecting
                          //selectingCheckboxes: true,
                          actions: {
                                   listAction: 'busca_clientes.php',
                                   updateAction: 'update_clientes.php',
                                   //deleteAction:'elimina_proveedor.php',
                                   createAction:'add_cliente.php',
                                   },
                          fields: {
                                  id: {
                                   title: 'ID Cliente',
                                   width: '10%',
                                   key: true,
                                   list: true
                                     },
                                  nombre: {
                                   title: 'Nombre',
                                   width: '30%',
                                   list: true,
                                   create: true,
                                   edit: true
                                     },
                                  telefono: {
                                   title: 'Telefono',
                                   width: '10%',
                                   list: true,
                                   create: true,
                                   edit: true
                                     },
                                  domicilio: {
                                   title: 'Domicilio',
                                   width: '10%',
                                   list: true,
                                   create: true,
                                   edit: true
                                   },
                                  ciudad: {
                                    title: 'Ciudad',
                                    width: '10%',
                                    list: true,
                                    create: true,
                                    edit: true
                                  }
                                  }
                               });

            //Re-load records when user click 'load records' button.
             $('#CargarRegistros').click(function (e){
             e.preventDefault();
             $('#tabla_clientes').jtable('load', {
                nombre: $('#name').val()
            });
        });

        //Cargar todos los registros cuando se muestre por primera vez
        $('#CargarRegistros').click();
         });