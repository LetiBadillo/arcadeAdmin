$(function() {

    $('.multiselect').multiSelect({
        keepOrder: true,
        selectableHeader: "<input type='text' style='width:100%; background: black;' class='search-input form-control' autocomplete='off' placeholder='Buscar...'>",
        selectionHeader: "<input type='text' style='width:100%; background: black;' class='search-input form-control' autocomplete='off' placeholder='Buscar...'>",
        afterInit: function(ms){
          var that = this,
              $selectableSearch = that.$selectableUl.prev(),
              $selectionSearch = that.$selectionUl.prev(),
              selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
              selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';
          that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
          .on('keydown', function(e){
            if (e.which === 40){
              that.$selectableUl.focus();
              return false;
            }
          });
          that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
          .on('keydown', function(e){
            if (e.which == 40){
              that.$selectionUl.focus();
              return false;
            }
          });
        },
        afterSelect: function(){
          this.qs1.cache();
          this.qs2.cache();
        },
        afterDeselect: function(){
          this.qs1.cache();
          this.qs2.cache();
        }   
      });
});

$('.searchInput').on('keyup', function(){
  $.get(search_url+'?ws=search&search='+$(this).val(), function(data){
    $('#subjectsTableBody').html(getTable(data));
  });
  $('.pagination').addClass('d-none');
});


function fillSelect(select, url, flag){
  $.get(url, function(data){
  var options = '';
  $(data).each(function(key, value){
      options += '<option style="background-color:rgba(84, 210, 1, 1)"; value="'+value.id+'">'+value.label+'</option>';
  });
  $(select).append(options);
  if(flag == 1){
      $(select).multiSelect('refresh');
  }
});
}

function saveForm(form, url, action){
  $(form).on('submit', function(e){
    e.preventDefault();
    hide($('.feedback'));
    $.post(url, $(form).serialize())
    .done(function(data){
      responses(data, action);
    }).fail(function(data){
      getErrors(data);      
    });
  });

}

function responses(data, action){
  switch (action) {
    case 1: /*Alert*/ 
    $('.modal-body').html(data);
    $('.modal-footer').html('<button type="button" class="button" data-dismiss="modal">Cerrar</button>');
    $('#myModal').modal('show');
    break;
    case 2: /*Alert with redirect*/ 
      $('.modal-body').html(data.response);
      $('.modal-footer').html('<a type="button" href="'+data.location+'" class="button pink">Continuar</a>');
      $('#myModal').modal('show');
    break;
    default:
    window.location.href = ''+action; //Redirect
    break;
  }
}

function getTable(data){
  var subjects = '<tr>';
  if(data.length == 0){
    console.log(data.length);
    subjects = '<td colspan="3" class="text-center">No se encontraron resultados.</td>\
    </tr>';
  }else{
    $.each(data, function(key,value){
      subjects += '<td>\
          <a style="color: white;" data-toggle="collapse" href="#c-'+value.id+'" role="button" aria-expanded="false" aria-controls="collapseExample">\
              +\
          </a>\
      </td>\
      <td>'+ value.subject_name +'</td>\
      <td>'+ value.branchName +'</td>\
      </tr>\
      <tr class="collapse detail" id="c-'+value.id+'">\
      <td></td>\
      <td>Preguntas: \
          <p>30</p>\
          <p><a href="/subjects/'+value.id+'" class="button text-center p-2">Ver detalle</a></p>\
      </td>\
      <td>';
          if(value.assignedUsers.lenght > 0){
            if(value.assignedUsers.lenght == 1){
              subjects += 'Titular:';
            }else{
              subjects += 'Titulares:';
            }
            $.each(value.assignedUsers, function(k, v){
              subjects += '<p>'+v.label+'<p>';
            });
          }else{
            subjects += '<p>Aún no hay titulares asignados<p>'
          }
             
          subjects +='</td>\
          </tr>';
    });
  }
    
    return subjects;
}

function getErrors(data){
  if(data.responseJSON.error){
    responses(data.responseJSON.error, 1);
  }else{
    $.each(data.responseJSON.errors, function(key,value){
      $('#'+key+'_error').text(value).removeClass('d-none');
    });
  }
}

function hide(data){
  $(data).each(function(k, v){
    $(v).html("").addClass('d-none');
  });
}
