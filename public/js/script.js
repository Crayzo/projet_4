var scrollTop = 
{
    top: 0,
    delay: 600,
    btn: $('#scroll-top'),
    page: $('body,html'),
    init: function()
    {
        this.onClick();
    },
    onClick: function()
    {
        var myThis = this;
        this.btn.click(function(){
            myThis.page.animate({scrollTop: myThis.top}, myThis.delay);
        });
    }
}
var footerScroll = Object.create(scrollTop);
footerScroll.init();
$('.card-header').on('click', '#delete-comment', function(e)
{
    e.preventDefault();
    var $this = $(this);
    var url = $this.attr('href');
    var result = confirm("Voulez-vous vraiment supprimer votre commentaire ?");
    if(!result) 
        return false;
    else 
    {
        $.ajax(url)
        .done(function(data, text, jqxhr){        
            $this.parents('.card').fadeOut();
        })
        .fail(function(jqxhr){
            alert(jqxhr.responseText);
        })
        .always(function(){
            $this.text('Chargement...');
        });
    }

});