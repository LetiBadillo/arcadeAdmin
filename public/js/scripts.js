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
  $.get(search_url+'?ws=search&'+$('#searchForm').serialize(), function(data){
    $('#subjectsTableBody').html(getTable(data));
  });
  $('.pagination').addClass('d-none');
});

$('.searchQuestionsInput').on('keyup', function(){
  $.get(search_url+'?ws=search&'+$('#searchForm').serialize(), function(data){
    $('#questionsTableBody').html(getTableQuestions(data));
  });
  $('.pagination').addClass('d-none');
});


function fillSelect(select, url, flag){
  $.get(url, function(data){
  var options = '';
  console.log(url);
  $(data).each(function(key, value){
      var attr = '';
      if(value.permission){
        attr = "selected";
      }
      options += '<option style="background-color:rgba(84, 210, 1, 1)"; '+attr+' value="'+value.id+'">'+value.label+'</option>';
  });
  $(select).append(options);
  if(flag == 1){
      $(select).multiSelect('refresh');
  }
  
  if($(select)[0].hasAttribute('option')){
    $(select).val($(select).attr('option'));
    console.log($(select).attr('option'));
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
    case 3: /*un modal ya abierto*/ 
    $('.modal-title').html(data.title);
    $('.modal-body').html(data.response);
    $('.modal-footer').html('<a type="button" href="'+data.location+'" class="button pink">Continuar</a>').removeClass('bg-black');;
    break;
    default:
    window.location.href = ''+action; //Redirect
    break;
  }
}

function getTable(data){
var subjects = '<tr>';
if(data.length == 0){
  
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

function getTableQuestions(data){
  var questions = '<tr>';
  if(data.length == 0){
    subjects = '<td colspan="3" class="text-center">No se encontraron resultados.</td>\
    </tr>';
  }else{
    $.each(data, function(key,value){
      questions+= '<tr class="m-3">\
        <th scope="col" class="text-uppercase align-middle text-center" > <i class="far fa-dot-circle"></i>'+value.question+'<br>\
      <small>'+value.authorName+' </small>\
      </th>\
      <th scope="col">\
          <i class="yellow-txt fas fa-caret-right"></i>\
          <span class="yellow-txt">'+value.answer+'</span><br>';
          $(value.otheroptions).each(function(k,v){
            questions+= '<i class="fas fa-caret-right"></i>\
            <span>'+v+'</span><br>';
          });
          questions += '</th>\
      <th>';
      if(value.hasQuestionPermission){
        questions += '<div style="float: right;" class="dropdown">\
        <button type="button" class="btn btn-link text-light" data-toggle="dropdown">\
        <h2><i class="fas fa-bars"></i></h2>\
        </button>\
        <div class="dropdown-menu">\
            <a class="dropdown-item editQuestion" data-id="'+value.id+'" href="#"><i class="far fa-edit"></i> Editar</a>';
            if(value.enabled == 1){
              questions += '<a class="dropdown-item enableQuestion" data-action="deshabilitar" data-id="'+value.id+'" href="#"><i class="fas fa-ban"></i>  Desactivar</a>';
            }else{
              questions += '<a class="dropdown-item enableQuestion" data-action="habilitar" data-id="'+value.id+'" href="#"><i class="fas fa-check"></i>  Activar</a>';
            }
        questions += '</div>\
        </div>';
      }
      
      questions +='</th>\
    </tr>';
    });
  }
    
    return questions;
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
