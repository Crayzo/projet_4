$(function()
{
    var scrollTop = 
    {
        top: 0,
        delay: 600,
        btnElt: $('#scroll-top'),
        page: $('body,html'),
        init: function()
        {
            this.onClick();
        },
        onClick: function()
        {
            var myThis = this;
            this.btnElt.click(function(){
                myThis.page.animate({scrollTop: myThis.top}, myThis.delay);
            });
        }
    }

    var alert =
    {
        alertElt: $('#alert'),
        delay: 500,

        init: function()
        {
            if(this.alertElt.length > 0)
            {
                this.show();
                this.close();
            }
        },
        show: function()
        {
            this.alertElt.hide().fadeIn(this.delay);
        },
        close: function()
        {
            var myThis = this;
            this.alertElt.find('.close').click(function(e)
            {
                e.preventDefault();
                myThis.alertElt.fadeOut();
            });
        }
    }

    var footerScroll = Object.create(scrollTop);
    footerScroll.init();

    var alertSubmit = Object.create(alert);
    alertSubmit.init();

    // AJAX
    $('.card-header').on('click', '.delete-comment', function(e)
    {
        e.preventDefault();
        var $this = $(this);
        var url = $this.attr('href');
        var result = confirm("Voulez-vous vraiment supprimer votre commentaire ?");
        if(!result) 
        {
            return false;
        }
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
});