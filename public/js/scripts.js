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
