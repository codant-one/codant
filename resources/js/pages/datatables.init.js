/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: datatables init js
*/

function initializeTables() {
    // Only initialize tables that exist on the page
    if ($('#example').length) {
        let example = new DataTable('#example');
    }

    if ($('#scroll-vertical').length) {
        let scrollVertical = new DataTable('#scroll-vertical', {
            "scrollY": "210px",
            "scrollCollapse": true,
            "paging": false
        });
    }

    if ($('#scroll-horizontal').length) {
        let scrollHorizontal = new DataTable('#scroll-horizontal', {
            "scrollX": true
        });
    }

    if ($('#alternative-pagination').length) {
        let alternativePagination = new DataTable('#alternative-pagination', {
            "pagingType": "full_numbers"
        });
    }

    //fixed header
    if ($('#fixed-header').length) {
        let fixedHeader = new DataTable('#fixed-header', {
            "fixedHeader": true
        });
    }

    //modal data data tables - only if Responsive plugin is available
    if ($('#model-datatables').length && $.fn.dataTable.Responsive) {
        let modelDataTables = new DataTable('#model-datatables', {
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Details for ' + data[0] + ' ' + data[1];
                        }
                    }),
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            }
        });
    }

    //buttons examples
    if ($('#buttons-datatables').length) {
        let buttonsDataTables = new DataTable('#buttons-datatables', {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'print', 'pdf'
            ]
        });
    }

    //ajax examples
    if ($('#ajax-datatables').length) {
        let ajaxDataTables = new DataTable('#ajax-datatables', {
            "ajax": 'assets/json/datatable.json'
        });
    }

    // Add rows functionality
    if ($('#add-rows').length) {
        var t = $('#add-rows').DataTable();
        var counter = 1;

        $('#addRow').on('click', function () {
            t.row.add([
                counter + '.1',
                counter + '.2',
                counter + '.3',
                counter + '.4',
                counter + '.5',
                counter + '.6',
                counter + '.7',
                counter + '.8',
                counter + '.9',
                counter + '.10',
                counter + '.11',
                counter + '.12'
            ]).draw(false);

            counter++;
        });

        // Automatically add a first row of data
        $('#addRow').trigger('click');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    initializeTables();
});
