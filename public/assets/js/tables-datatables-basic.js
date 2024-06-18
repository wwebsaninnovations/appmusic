/**
 * DataTables Basic
 */

'use strict';

// datatable (jquery)
$(function () {
  var dt_basic_table = $('.datatables-basic'),
    dt_basic;

  // DataTable with buttons
  // --------------------------------------------------------------------

  

  if (dt_basic_table.length) {
    dt_basic = dt_basic_table.DataTable({
      ajax: '/releases/getReleaseData',       
      processing: true,
      serverSide: true,
  
      columns: [
        { data: '' },
        { data: "id" },
        { data: "thumbnail" },
        { data: "release_name" },
        { dat: "format" },
        {data: "code" },
        {data: "upc" },
        { data: "status" },
        { data: '' }
      ],
      columnDefs: [
        
        {
          // Actions
          targets: -1,
          title: 'Actions',
          orderable: false,
          searchable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block">' +
              '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></a>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              '<a href="javascript:;" class="dropdown-item">Details</a>' +
              '<a href="javascript:;" class="dropdown-item">Archive</a>' +
              '<div class="dropdown-divider"></div>' +
              '<a href="javascript:;" class="dropdown-item text-danger delete-record">Delete</a>' +
              '</div>' +
              '</div>' +
              '<a href="javascript:;" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>'
            );
          }
        }
      ]



    
     });
  }
});
