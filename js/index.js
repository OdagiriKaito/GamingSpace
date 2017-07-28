jQuery(function($){
  console.log("Hello World");
  console.log($(document));
  $(document).on('change',':input[name="category"]',categoryChangeEvent)
             .on('click','.category',clickCategory);

  function categoryChangeEvent(){
    $self = $(this);
    catId = $self.val();
    console.log($self.val());
    $.ajax('/category.php',{
      data:{
        id: catId
      }
    }).done(function(res){
      $(':input[name="subcategory"]').empty().append($(res).children());
      console.log(res);
    });
  };

  function clickCategory(){

    var $self = $(this);
    var $subcategory = $self.next('.subcategory');

    if($subcategory.is(':visible')){
      $subcategory.slideToggle();
      return;
    }

    $('.subcategory').hide();

    var left = $self.offset().left + $self.outerWidth() - $subcategory.outerWidth();
    var top = $self.offset().top+$self.outerHeight();

  $subcategory
  .css({
    left:left,
    top:top
  })
  .slideToggle();

}

  $(':input[name="category"]').change();
});
