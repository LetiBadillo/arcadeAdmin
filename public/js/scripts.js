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
            console.log(e);
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
